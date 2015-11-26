<? 
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require 'admin/classes/Contact.php';
	require 'admin/classes/utils.php';
	session_start();
	
	$debug = false;
	
	$contact = new Contact();
	
	$mon_action = $_POST[ "mon_action" ];
	$anti_spam = $_POST[ "as" ];
	$demande_carte = $_GET[ "carte" ];
	//print_pre( $_POST );
	
	// ---- Demande de carte de fidélité --------------------- //
	$checked_carte = ( $_GET[ "carte" ] == 1 ) ? "selected" : "";
	$titre_page = ( $_GET[ "carte" ] == 1 ) ? "Demande de carte de fidélité" : "Contactez-nous";
	
	// ---- Post du formulaire ------------------------------- //
	if ( $mon_action == "poster" && $anti_spam == '' ) {
		if ( $debug ) echo "On poste...<br>";
		
		// ---- Enregistrement dans "contact" -------- //
		if ( 1 == 1 ) {
			$num_contact = $contact->isContact( $_POST[ "email" ], $debug );
			
			unset( $val );
			$val[ "id"] = $num_contact;
			$val[ "firstname"] = $_POST[ "prenom" ];
			$val[ "name"] = $_POST[ "nom" ];
			$val[ "adresse"] = $_POST[ "adresse" ];
			$val[ "cp"] = $_POST[ "cp" ];
			$val[ "ville"] = $_POST[ "ville" ];
			$val[ "email"] = $_POST[ "email" ];
			$val[ "tel"] = $_POST[ "tel" ];
			$val[ "message"] = $_POST[ "message" ];
			$val[ "newsletter"] = $_POST[ "newsletter" ];
			$val[ "fromcontact"] = "on";
			if ( $num_contact <= 0 ) $contact->contactAdd( $val, $debug );
			else $contact->contactModify( $val, $debug );
		}
		// ------------------------------------------- //
		
		// ---- Envoi du mail à l'admin -------------- //
		if ( 1 == 1 ) {
			$entete = "From:" . MAILNAMECUSTOMER . " <" . MAILCUSTOMER . ">\n";
			$entete .= "MIME-version: 1.0\n";
			$entete .= "Content-type: text/html; charset= iso-8859-1\n";
			$entete .= "Bcc:" . MAIL_BCC . "\n";
			//echo "Entete :<br>" . $entete . "<br><br>";
			
			$sujet = utf8_decode( "Prise de contact" );
			
			//$_to = "franck_langleron@hotmail.com";
			$_to = ( MAIL_TEST != '' )
		    	? MAIL_TEST
		    	: MAIL_CONTACT;
			//echo "Envoi du message à : " . $_to . "<br><br>";
			
			$message = "Bonjour,<br><br>";
			$message .= "La personne suivante a rempli le formulaire de contact de votre site :<br>";
			$message .= "Nom : <b>" . $_POST[ "nom" ] . " " . $_POST[ "prenom" ] . "</b><br>";
			$message .= "E-mail / Téléphone : <b>" . $_POST[ "email" ] . " / " . $_POST[ "tel" ] . "</b><br>";
			$message .= "Adresse postale : <b>" . $_POST[ "adresse" ] . ", " . $_POST[ "cp" ] . " " . $_POST[ "ville" ] . "</b><br>";
			$message .= "Sujet : <b>" . $_POST[ "sujet" ] . "</b><br>";
			$message .= "Message : <br><i>" . nl2br( $_POST[ "message" ] ) . "</i><br><br>";
			$message .= "Cordialement.";
			$message = utf8_decode( $message );
			if ( $debug ) echo $message;
			
			mail( $_to, $sujet, stripslashes( $message ), $entete );
			//exit();
		}
		// ------------------------------------------- //
		//exit();
		
	}
	// ------------------------------------------------------- //
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<title>Le Fournil d’Artigues > Contact</title>
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/meta.php" ); ?>
	</head>
	<body class="page">
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/top.php" ); ?>
		
		<!-- Content -->
		<div class="row">
			<h2><?=$titre_page?></h2>
			
			<div class="large-6 medium-6 small-12 columns">
				<h3>Le Fournil d’Artigues</h3>
				<p>
					Ouverture :<br/>
					7j/7<br/>
					de 5h30 à 20h30
				</p>
				<p>
					Tél. 05 56 86 70 93<br/>
					5 Bis Avenue Virecourt<br/>
					33370 Artigues-près-Bordeaux
				</p>
			</div>
			<div class="large-6 medium-6 small-12 columns">
				<form id="formulaire" class="row contact" method="post" action="contact.php">
					<input type="hidden" name="mon_action" id="mon_action" value="" />
					<input type="hidden" name="as" value="" />
					
					<div class="large-6 medium-12 columns">
						<input type="text" name="prenom" id="prenom" placeholder="Votre prénom" />						
					</div>
					<div class="large-6 medium-12 columns">
						<input type="text" name="nom" id="nom" placeholder="Votre nom" required />
					</div>
					<div class="large-12 columns">
						<input type="text" name="adresse" placeholder="Votre adresse">
					</div>
					<div class="large-4 medium-5 small-12 columns">
						<input type="text" name="cp" placeholder="Code postal" />						
					</div>
					<div class="large-8 medium-7 small-12 columns">
						<input type="text" name="ville" placeholder="Ville" />
					</div>
					<div class="large-6 medium-12 columns">
						<input type="tel" name="tel" id="tel" placeholder="Votre n° de téléphone" required />						
					</div>
					<div class="large-6 medium-12 columns">
						<input type="email" name="email" id="email" placeholder="Votre e-mail" required />
					</div>
					<div class="large-12 columns">
						<select name="sujet" required>
							<option	value="" selected>A propos de ...</option>
							<option	value="Renseignements">Renseignements</option>
							<option	value="Demande de carte de fidélité" <?=$checked_carte?> >Demande de carte de fidélité</option>
							<option	value="Autre">Autre</option>
						</select>
					</div>
					<div class="large-12 columns">
						<textarea name="message" id="message" placeholder="Votre message" required></textarea>
					</div>
					<div class="large-12 columns">
						<input type="submit" value="Envoyer" />
					</div>
				</form>
			</div>
			
		</div>
		<!-- End Content -->
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/footer.php" ); ?>
		
	    <script>
			$(document).ready(function() {
				
				$('.menu a:last-of-type').addClass('active');
				
				// ---- Validation du formulaire ---------------------------- //
				if ( 1 == 1 ) {
					
					function initialiser() {
						$( "#nom" ).removeClass( "erreur" );
						$( "#prenom" ).removeClass( "erreur" );
						$( "#email" ).removeClass( "erreur" );
						$( "#tel" ).removeClass( "erreur" );
						$( "#message" ).removeClass( "erreur" );
					}
					
					function checkEmail( adr ) {
						if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(adr)) {
								return (true);
						}
						return (false);
					}
					
					$( "#formulaire" ).submit(function() {
						//alert( "validation..." );
						var erreur = 0;
						initialiser();
						
						if ( $.trim( $( "#nom" ).val() ) == '' ) {
							erreur = 1;
							$( "#nom" ).addClass( "erreur" );
						}
						
						if ( $.trim( $( "#prenom" ).val() ) == '' ) {
							erreur = 1;
							$( "#prenom" ).addClass( "erreur" );
						}
						
						if ( $.trim( $( "#email" ).val() ) == '' ) {
							erreur = 1;
							$( "#email" ).addClass( "erreur" );
						}
						else if ( !checkEmail( $.trim( $( "#email" ).val() ) ) ) {
							erreur = 1;
							$( "#email" ).addClass( "erreur" );
						}
						
						if ( $.trim( $( "#tel" ).val() ) == '' ) {
							erreur = 1;
							$( "#tel" ).addClass( "erreur" );
						}
						
						if ( $.trim( $( "#message" ).val() ) == '' ) {
							erreur = 1;
							$( "#message" ).addClass( "erreur" );
						}
						
						if ( erreur == 0 ) $( "#mon_action" ).val( "poster" );
						return ( erreur == 0 ) ? true : false;
					});
				}
				// ---------------------------------------------------------- //
				
			});
		</script>
		
	</body>
</html>
