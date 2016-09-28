<?php
	// Projet Réservations M2L - version web mobile
	// fichier : vues/VueDemanderMdp.php
	// Rôle : Demander un nouveau mot de passe
	// cette vue est appelée par le contôleur controleurs/CtrlDemanderMdp.php
	// Création : 27/09/2016 par Killian BOUTIN
	// Mise à jour : 27/09/2016 par Killian BOUTIN
?>
<!doctype html>
<html>
	<head>
		<?php include_once ('vues/head.php'); ?>
		
		<script>
			// associe une fonction à l'événement pageinit
			$(document).bind('pageinit', function() {
				<?php if ($typeMessage != '') { ?>
					// affiche la boîte de dialogue 'affichage_message'
					$.mobile.changePage('#affichage_message', {transition: "<?php echo $transition; ?>"});
				<?php } ?>
			} );
		</script>
	</head>
	 
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="<?php echo $themeNormal; ?>">
				<h4>M2L-GRR</h4>
				<a href="index.php" data-transition="<?php echo $transition; ?>">Retour index</a>
			</div>
			<div data-role="content">
				<h4 style="text-align: center; margin-top: 0px; margin-bottom: 0px;">Demander un nouveau mot de passe</h4>
				<form action="index.php?action=DemanderMdp" method="post" data-ajax="false">
					<div data-role="fieldcontain" class="ui-hide-label">
						<label for="txtName">Entrez votre nom</label>
						<input type="text" name="txtName" id="txtName" placeholder="Entrez votre nom d'utilisateur" value="<?php echo $name ?>">
					</div>
					<div data-role="fieldcontain">
						<input type="submit" name="btnNouveauMdp" id="btnNouveauMdp" value="M'envoyer un nouveau mot de passe" data-mini="true">
					</div>
				</form>

				<?php if($debug == true) {
					// en mise au point, on peut afficher certaines variables dans la page
					echo "<p>name = " . $name . "</p>";
					echo "<p>adrMail = " . $adrMail . "</p>";
					echo "<p>level = " . $level . "</p>";
				} ?>
				
			</div>
			
			<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeNormal;?>">
				<h4>Suivi des réservations de salles<br>Maison des ligues de Lorraine (M2L)</h4>
			</div>
		</div>
		
		<?php include_once ('vues/dialog_message.php'); ?>
		
	</body>
</html>