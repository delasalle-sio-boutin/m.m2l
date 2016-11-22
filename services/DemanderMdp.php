<?php
// Service web du projet Réservations M2L
// Ecrit le 22/11/2016 par Killian BOUTIN

// Ce service web permet à un utilisateur de s'authentifier
// et fournit un flux XML contenant un compte-rendu d'exécution

// Le service web doit recevoir 2 paramètres : nom, mdp
// Les paramètres peuvent être passés par la méthode GET (pratique pour les tests, mais à éviter en exploitation) :
//     http://<hébergeur>/ConsulterSalles.php

// Les paramètres peuvent être passés par la méthode POST (à privilégier en exploitation pour la confidentialité des données) :
//     http://<hébergeur>/ConsulterSalles.php

// inclusion de la classe Outils
include_once ('../modele/Outils.class.php');
// inclusion des paramètres de l'application
include_once ('../modele/parametres.localhost.php');
	
// Récupération des données transmises
// la fonction $_GET récupère une donnée passée en paramètre dans l'URL par la méthode GET
if ( empty ($_GET ["nom"]) == true)  $nom = "";  else   $nom = $_GET ["nom"];

// si l'URL ne contient pas les données, on regarde si elles ont été envoyées par la méthode POST
// la fonction $_POST récupère une donnée envoyées par la méthode POST
if ( $nom == "" )
{	if ( empty ($_POST ["nom"]) == true)  $nom = "";  else   $nom = $_POST ["nom"];
}

// Contrôle de la présence des paramètres
if ( $nom == "" )
{	$msg = "Erreur : données incomplètes.";
}
else
{	// connexion du serveur web à la base MySQL
	include_once ('../modele/DAO.class.php');
	$dao = new DAO();
	$unUtilisateur = $dao->getUtilisateur($nom);
	
	if ( $unUtilisateur == NULL ) $msg = "Erreur : nom d'utilisateur inexistant.";
	else{

		$adrMail = $unUtilisateur->getEmail();
		$password = Outils::creerMdp();
		$dao->modifierMdpUser($nom, $password);
		$level = $dao->getNiveauUtilisateur($nom, $password);
		
		
		$sujet = "Votre nouveau mot de passe";
		$contenuMail = "Voici les nouvelles données vous concernant :\n\n";
		$contenuMail .= "Votre nom : " . $nom . "\n";
		$contenuMail .= "Votre mot de passe : " . $password . " (nous vous conseillons de le changer)\n";
		$contenuMail .= "Votre niveau d'accès : " . $level . "\n";
		
		$ok = Outils::envoyerMail($adrMail, $sujet, $contenuMail, $ADR_MAIL_EMETTEUR);
		if ( ! $ok ) {
			$msg = "Erreur : échec lors de l'envoi du mail.";
		}
		else {
			$msg = "Vous allez recevoir un mail avec votre nouveau mot de passe.";
		}
	}
	
	// ferme la connexion à MySQL :
	unset($dao);
}

// création du flux XML en sortie
creerFluxXML ($msg);

// fin du programme (pour ne pas enchainer sur la fonction qui suit)
exit;


// création du flux XML en sortie
function creerFluxXML($msg)
{	// crée une instance de DOMdocument (DOM : Document Object Model)
	$doc = new DOMDocument();
	
	// specifie la version et le type d'encodage
	$doc->version = '1.0';
	$doc->encoding = 'ISO-8859-1';
	
	// crée un commentaire et l'encode en ISO
	$elt_commentaire = $doc->createComment('Service web Connecter - BTS SIO - Lycée De La Salle - Rennes');
	// place ce commentaire à la racine du document XML
	$doc->appendChild($elt_commentaire);
	
	// crée l'élément 'data' à la racine du document XML
	$elt_data = $doc->createElement('data');
	$doc->appendChild($elt_data);
	
	// place l'élément 'reponse' juste après l'élément 'data'
	$elt_reponse = $doc->createElement('reponse', $msg);
	$elt_data->appendChild($elt_reponse);
	
	// Mise en forme finale
	$doc->formatOutput = true;
	
	// renvoie le contenu XML
	echo $doc->saveXML();
	return;
}
?>