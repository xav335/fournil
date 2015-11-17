<?
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require( $_SERVER['DOCUMENT_ROOT'] . "/admin/classes/Contact.php" );
	include_once( $_SERVER['DOCUMENT_ROOT'] . "/admin/classes/utils.php" );
	
	$task = $_GET[ "task" ];
	
	switch( $task ) {
	    case "inscrire":
	        inscrire();
	        break;
		
	}
	
	// Inscription du visiteur à la newsletter
	function inscrire() {
		$debug = false;
		$contact = new Contact();
		
		if ( $_POST[ "as" ] == '' ) {
			
			// ---- Enregistrement dans "contact" -------- //
			if ( $_POST[ "email_news" ] != '' ) {
				$num_contact = $contact->isContact( $_POST[ "email_news" ], $debug );
				
				unset( $val );
				$val[ "id"] = $num_contact;
				$val[ "email"] = $_POST[ "email_news" ];
				$val[ "newsletter"] = "on";
				if ( $num_contact <= 0 ) $contact->contactAdd( $val, $debug );
				else $contact->contactModify( $val, $debug );
			}
			// ------------------------------------------- //
			
			$erreur = "false";
			$message = "Inscription réalisée avec succès";
			
			die('{
				"error":' . $erreur . ', 
				"message":"' . $message . '"
			}');
		}
	}
?>