<? 
	include_once '../../inc/inc.config.php';
	include_once '../classes/utils.php';
	require '../classes/ImageManager.php';
	require '../classes/Categorie.php';
	session_start();
	
	$debug = false;
	if ( $debug ) print_pre( $_POST );
	
	// ---- Security ---------------------------------------------------------- //
	if ( !isset( $_SESSION[ "accessGranted" ] ) || !$_SESSION[ "accessGranted" ] ) {
		$result = $storageManager->grantAccess($_POST[ "login" ], $_POST[ "mdp" ]);
		if (!$result){
			header('Location: /admin/?action=error');
		} else {
			$_SESSION[ "accessGranted" ] = true;
		}
	}
	// ------------------------------------------------------------------------ //
	
	
	 // ---- Gestion des catégories ------------------------------------------- //
	if ( $_POST[ "mon_action" ] == "gerer" ) {
		$categorie = new Categorie();
		$imageManager = New ImageManager();
		
		// ---- Traitement de l'image ------------------- //
		if ( $_POST[ "url1" ] != '' ) {
			$source = $_SERVER[ "DOCUMENT_ROOT" ] . $_POST[ "url1" ];
			if ( $debug ) echo "Source : " . $source . "<br>";
			
			if( strstr( $source, 'uploads' ) ) {
				$source = $_SERVER[ "DOCUMENT_ROOT" ] . $_POST[ "url1" ];
				$filenameDest = $imageManager->fileDestManagement( $source, $_POST[ "id" ] );
				
				// ---- Image -------- //
				$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/photos/categorie' . $filenameDest;
				if ( $debug ) echo "Destination : " . $destination . "<br>";
				$imageManager->imageResize( $source, $destination, 312, 154, ZEBRA_IMAGE_CROP_CENTER );
				
				$_POST[ "image" ] = $filenameDest;
			}
		}
		$imageManager = null;
		// ---------------------------------------------- //
		
		// ---- Traitement des données ------------------ //
		if ( 1 == 1 ) {
			$id = $categorie->gererDonnees( $_POST, $debug );
		}
		// ---------------------------------------------- //
		
		// ---- Redirection après traitement ------------ //
		if ( 1 == 1 ) {
			
			// ---- Modification... ---- //
			if ( $_POST[ "id" ] != '' ) $page_redirection = "/admin/categorie/edition.php?id=" . $id;
			
			// ---- Ajout... ----------- //
			else $page_redirection = "/admin/categorie/liste.php";
			
			if ( $debug ) echo "Redirection vers " . $page_redirection;
			else header( "Location: " . $page_redirection );
			exit();
		}
		// ---------------------------------------------- //
		
	} 
	// ------------------------------------------------------------------------ //
	
	
	// ---- GET GET GET ------------------------------------------------------- //
	elseif ( $_GET[ "action" ] == 'delete' ) {
		try {
			$categorie = new Categorie();
			$result = $categorie->supprimer( $_GET[ "id" ], $debug );
			
			if ( !$debug ) header( "Location: /admin/categorie/liste.php" );
		} 
		catch (Exception $e) {
			echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
			$goldbook = null;
			exit();
		}
	}
	// ------------------------------------------------------------------------ //
	
	
	// ---- ERREUR!!! --------------------------------------------------------- //
	else {
		header('Location: /admin/');
	}
	// ------------------------------------------------------------------------ //
?>