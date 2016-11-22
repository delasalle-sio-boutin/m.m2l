<?php
// Service web du projet Réservations M2L
// Ecrit le 22/11/2016 par Tony
// Modifié le

// Ce service web permet à un utilisateur verifier le digicode du batiment
// et fournit un compte-rendu d'exécution

// Le service web doit être appelé avec 1 paramètres : digicode
// Les paramètres peuvent être passés par la méthode GET (pratique pour les tests, mais à éviter en exploitation) :
// http://<hébergeur>/TesterDigicodeBatiment.php?digicode=
// Les paramètres peuvent être passés par la méthode POST (à privilégier en exploitation pour la confidentialité des données) :
// http://<hébergeur>/TesterDigicodeBatiment.php

// inclusion de la classe Outils
include_once ('../modele/Outils.class.php');
// inclusion des paramètres de l'application
include_once ('../modele/parametres.localhost.php');

// Récupération des données transmises
// la fonction $_GET récupère une donnée passée en paramètre dans l'URL par la méthode GET
// Récupération des données transmises
// la fonction $_GET récupère une donnée passée en paramètre dans l'URL par la méthode GET
if (empty ( $_GET ["digicode"] ) == true)
	$digicode = "";
else
	$digicode = $_GET ["digicode"];

	
	// si l'URL ne contient pas les données, on regarde si elles ont été envoyées par la méthode POST
	// la fonction $_POST récupère une donnée envoyées par la méthode POST
if ($digicode == "") {
	if (empty ( $_POST ["digicode"] ) == true)
		$digicode = "";
	else
		$digicode = $_POST ["digicode"];

}
// Contrôle de la présence des paramètres
if ($digicode == "") {
	$msg = "Erreur : données incomplètes ou incorrectes.";
} else {
	
	// connexion du serveur web à la base MySQL ("include_once" peut être remplacé par "require_once")
	include_once ('../modele/DAO.class.php');
	$dao = new DAO ();
	$msg = $dao->testerDigicodeBatiment($digicode);
	
}
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
$elt_commentaire = $doc->createComment('Service web TesterDigicodeSalle - BTS SIO - Lycée De La Salle - Rennes');
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