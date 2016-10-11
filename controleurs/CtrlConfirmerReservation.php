<?php
// connexion du serveur web à la base MySQL
include_once ('modele/DAO.class.php');
$dao = new DAO();
	
if ( ! isset ($_POST ["btnConfirmerReservation"]) == true) {
// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur

$idReservation = '';
include_once ('vues/VueConfirmerReservation.php');

}
else
{
$idReservation = $_POST ["numReservation"];
}
	$nomUtilisateur = $_SESSION['nom'];
	
	
	// On teste si la réservation existe
	if (!$dao->existeReservation($idReservation)){
		$message = "Confirmation impossible, la réservation n'existe pas.";
		$typeMessage = 'avertissement';
		$themeFooter = $themeNormal;
		include_once ('vues/VueConfirmerReservation.php');	
	}
	else{
		// On teste si l'utilisateur est le créateur de la réservation
		if ( !$dao->estLeCreateur($nomUtilisateur,$idReservation)){
			$message = "Annulation impossible, vous n'êtes pas le créateur.";
			$typeMessage = 'avertissement';
			$themeFooter = $themeNormal;
			include_once ('vues/VueConfirmerReservation.php');
		}
		
		
	}