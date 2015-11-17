<?
	include_once 'inc-auth-granted.php';
	include_once 'classes/utils.php';
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require 'classes/Contact.php';
	
	// ---- Modification ----------------- //
	if ( !empty( $_GET ) ) {
		$action = 'modif';
		$contact = new Contact();
		$result = $contact->contactGet( $_GET[ "id" ], null, null );

		if (empty($result)) {
			$message = 'Aucun enregistrements';
		} 
		else {
			$labelTitle= 	'Contact N°: '. $_GET[ "id" ];
			$id= 			$_GET[ "id" ];
			$firstname= 	$result[ 0 ][ "firstname" ];
			$name= 		$result[ 0 ][ "name" ];
			$adresse= 		$result[ 0 ][ "adresse" ];
			$cp= 			$result[ 0 ][ "cp" ];
			$ville= 		$result[ 0 ][ "ville" ];
			$email= 		$result[ 0 ][ "email" ];
			$tel= 			$result[ 0 ][ "tel" ];
			
			($result[ 0 ][ "newsletter" ]=='1') ? $online = 'checked' : $online = '';
			($result[ 0 ][ "fromcontact" ]=='1') ? $fromcontact = "origine: formulaire de contact" : $fromcontact = '';
			($result[ 0 ][ "fromgoldbook" ]=='1') ? $fromgoldbook = "origine: livre d'or" : $fromgoldbook = '';
		}
	} 
	
	// ---- Ajout ------------------------ //
	else {
		$action = 'add';
		$labelTitle =	'Edition Contact';
		$id= 			null;
		$firstname= 	null;
		$name= 		null;
		$adresse= 		null;
		$cp= 			null;
		$villes= 		null;
		$email= 		null;
		$tel= 			null;
		$online= 		null;
		$fromcontact = '';
		$fromgoldbook = '';
	}
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<?php include_once 'inc-meta.php';?>
	</head>
<body>	
	
	<?php require_once 'inc-menu.php';?>

	<div class="container">

		<div class="row">
			<h3><?=$labelTitle?></h3><br>
			<div class="col-xs-12 col-sm-12 col-md-12">
				
				<form name="formulaire" class="form-horizontal" method="POST" action="formprocess.php">
					<input type="hidden" name="reference" value="contact">
					<input type="hidden" name="action" value="<?=$action?>">
					<input type="hidden" name="id" id="id" value="<?=$id?>">
					
					<div class="form-group" >
						<label class="col-sm-2" for="titre">Prénom :</label>
					  <input type="text" class="col-sm-10" name="firstname" required value="<?=$firstname?>">
					</div>
					<div class="form-group" >
						<label class="col-sm-2" for="titre">Nom :</label>
					  <input type="text" class="col-sm-10" name="name" required value="<?=$name?>">
					</div>
					
					<div class="form-group" >
						<label class="col-sm-2" for="titre">Adresse :</label>
					  <input class="col-sm-10" name="adresse" type="adresse" value="<?=$adresse?>">
					</div>
					
					<div class="form-group" >
						<label class="col-sm-2" for="titre">Code postal :</label>
					  <input class="col-sm-10" name="cp" type="cp" value="<?=$cp?>">
					</div>
					
					<div class="form-group" >
						<label class="col-sm-2" for="titre">Ville :</label>
					  <input class="col-sm-10" name="ville" type="ville" value="<?=$ville?>">
					</div>
					
					<div class="form-group" >
						<label class="col-sm-2" for="titre">Email :</label>
					  <input class="col-sm-10" name="email" type="email" required value="<?=$email?>">
					</div>
					
					<div class="form-group" >
						<label class="col-sm-2" for="titre">Téléphone :</label>
					  <input class="col-sm-10" name="tel" type="tel" value="<?=$tel?>">
					</div>
					
					<div class="form-group" >
						<label for="titre"> Newsletter:</label>
					  <input type="checkbox" name="newsletter" <?= $online?>>
					</div>
					<div class="form-group" >
						<label class="col-sm-3"><?=$fromcontact?></label> ---- <label class="col-sm-3"><?=$fromgoldbook?></label><br>
					</div>
					
		      		<a href="./contact-list.php" class="btn btn-success col-sm-6" class="btn btn-default"> Annuler </a>
		      		<button type="submit" class="btn btn-success col-sm-6" class="btn btn-default"> Valider </button>
		    </form>
		</div>
	</div>
</body>
</html>


