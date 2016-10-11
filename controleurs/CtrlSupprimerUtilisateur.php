<?php
// Projet Réservations M2L - version web mobile
// fichier : controleurs/CtrlSupprimerUtilisateur.php
// Rôle : traiter la demande de suppression d'un nouvel utilisateur
// Création : 11/10/2016 par Killian BOUTIN

// on vérifie si le demandeur de cette action a le niveau administrateur
if ($_SESSION['niveauUtilisateur'] != 'administrateur') {
	// si l'utilisateur n'a pas le niveau administrateur, il s'agit d'une tentative d'accès frauduleux
	// dans ce cas, on provoque une redirection vers la page de connexion
	header ("Location: index.php?action=Deconnecter");
}
else {
	if ( ! isset ($_POST ["txtName"]) ) {
		// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
		$name = '';
		$message = '';
		$typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
		$themeFooter = $themeNormal;
		include_once ('vues/VueSupprimerUtilisateur.php');
	}
	else {
		// récupération des données postées
		if ( empty ($_POST ["txtName"]) == true)  $name = "";  else   $name = $_POST ["txtName"];
		
		// inclusion de la classe Outils pour utiliser les méthodes statiques estUneAdrMailValide et creerMdp
		include_once ('modele/Outils.class.php');
		
		if ($name == '') {
			// si les données sont incorrectes ou incomplètes, réaffichage de la vue de suppression avec un message explicatif
			$message = 'Données incomplètes ou incorrectes !';
			$typeMessage = 'avertissement';
			$themeFooter = $themeProbleme;
			include_once ('vues/VueSupprimerUtilisateur.php');
		}
		else {
			// connexion du serveur web à la base MySQL
			include_once ('modele/DAO.class.php');
			$dao = new DAO();
			
			if ( ! $dao->existeUtilisateur($name) ) {
				// si le nom existe déjà, réaffichage de la vue
				$message = "Utilisateur non existant !";
				$typeMessage = 'avertissement';
				$themeFooter = $themeProbleme;
				include_once ('vues/VueSupprimerUtilisateur.php');
			}
			else {
				// envoi d'un mail de confirmation de l'enregistrement
				$sujet = "Création de votre compte dans le système de réservation de M2L";
				$contenuMail = "L'administrateur du système de réservations de la M2L vient de vous créer un compte utilisateur.\n\n";
				$contenuMail .= "Les données enregistrées sont :\n\n";
				$contenuMail .= "Votre nom : " . $name . "\n";
				$contenuMail .= "Votre mot de passe : " . $password . " (nous vous conseillons de le changer lors de la première connexion)\n";
				$contenuMail .= "Votre niveau d'accès (0 : invité    1 : utilisateur    2 : administrateur) : " . $level . "\n";
					
				$ok = Outils::envoyerMail($adrMail, $sujet, $contenuMail, $ADR_MAIL_EMETTEUR);
				if ( ! $ok ) {
					// si l'envoi de mail a échoué, réaffichage de la vue avec un message explicatif
					$message = "Enregistrement effectué.<br>L'envoi du mail à l'utilisateur a rencontré un problème !";
					$typeMessage = 'avertissement';
					$themeFooter = $themeProbleme;
					include_once ('vues/VueSupprimerUtilisateur.php');
				}
				else {
					// tout a fonctionné
					$message = "Enregistrement effectué.<br>Un mail va être envoyé à l'utilisateur !";
					$typeMessage = 'information';
					$themeFooter = $themeNormal;
					include_once ('vues/VueSupprimerUtilisateur.php');
				}
			}
			unset($dao);		// fermeture de la connexion à MySQL
		}
	}
}
