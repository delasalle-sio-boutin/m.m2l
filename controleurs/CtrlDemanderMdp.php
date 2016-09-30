<?php
// Projet Réservations M2L - version web mobile
// fichier : controleurs/CtrlCreerUtilisateur.php
// Rôle : traiter la demande de création d'un nouvel utilisateur
// Création : 28/09/2016 par Killian BOUTIN
// Mise à jour : 28/09/2016 par Killian BOUTIN


if ( ! isset ($_POST ["txtName"])){
	// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
	$name = '';
	$message = '';
	$typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
	$themeFooter = $themeNormal;
	include_once ('vues/VueDemanderMdp.php');
}
else {	
	if ($_POST ["txtName"] == '') {
		$name = "";
		// si les données sont incorrectes ou incomplètes, réaffichage de la vue de suppression avec un message explicatif
		$message = 'Données incomplètes ou incorrectes !';
		$typeMessage = 'avertissement';
		$themeFooter = $themeProbleme;
		include_once ('vues/VueDemanderMdp.php');
	}
	else {
			
		// inclusion de la classe Outils pour utiliser les méthodes statiques creerMdp
		include_once ('modele/Outils.class.php');
		// connexion du serveur web à la base MySQL
		include_once ('modele/DAO.class.php');
		$dao = new DAO();
			
		if ( ! $dao->existeUtilisateur($_POST ["txtName"]) ) {
			// si le nom n'existe pas, on demande a l'utilisateur d'entrer un bon nom
			$message = "Nom d'utilisateur incorrect, merci de réessayer !";
			$typeMessage = 'avertissement';
			$themeFooter = $themeProbleme;
			include_once ('vues/VueDemanderMdp.php');
		}
		else {
			
			$name = $_POST ["txtName"];
			// création d'un mot de passe aléatoire de 8 caractères
			$password = Outils::creerMdp();

			$ok = $dao->modifierMdpUser($name, $password);
			if ( ! $ok ) {
				// si l'enregistrement a échoué, réaffichage de la vue avec un message explicatif					
				$message = "Problème lors de l'enregistrement !";
				$typeMessage = 'avertissement';
				$themeFooter = $themeProbleme;
				include_once ('vues/VueDemanderMdp.php');
			}
			else {
				// envoi d'un mail de confirmation de l'enregistrement
				
				$unUtilisateur = $dao->getUtilisateur($name);
				$adrMail = $unUtilisateur->getEmail();
				
				$level = $dao->getNiveauUtilisateur($name, $password);
				$sujet = "Votre nouveau mot de passe";
				$contenuMail = "Voici les nouvelles données vous concernant :\n\n";
				$contenuMail .= "Votre nom : " . $name . "\n";
				$contenuMail .= "Votre mot de passe : " . $password . " (nous vous conseillons de le changer)\n";
				$contenuMail .= "Votre niveau d'accès : " . $level . "\n";
				
				$ok = Outils::envoyerMail($adrMail, $sujet, $contenuMail, $ADR_MAIL_EMETTEUR);
				if ( ! $ok ) {
					
					// si l'envoi de mail a échoué, réaffichage de la vue avec un message explicatif
					$message = "Enregistrement effectué.<br>L'envoi du mail à l'utilisateur a rencontré un problème !";
					$typeMessage = 'avertissement';
					$themeFooter = $themeProbleme;
					include_once ('vues/VueDemanderMdp.php');
				}
				else {
					// tout a fonctionné
					$message = "Enregistrement effectué.<br>Un mail va être envoyé à l'utilisateur !";
					$typeMessage = 'information';
					$themeFooter = $themeNormal;
					include_once ('vues/VueDemanderMdp.php');
				}
			}
		}
		unset($dao);		// fermeture de la connexion à MySQL
	}
}
