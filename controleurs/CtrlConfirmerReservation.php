<?php
if ( ! isset ($_POST ["btnVerifierReservation"]) == true) {
	
	$idReservation = "";
	
	$message = '';
	$typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
	$themeFooter = $themeNormal;
	include_once ('vues/VueConfirmerReservation.php');
}
else {
	
	
}