<? 
	include_once '../../inc/inc.config.php';
	include_once '../classes/utils.php';
	require '../classes/ImageManager.php';
	require '../classes/Produit.php';
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
	
	
	 // ---- Gestion des produits --------------------------------------------- //
	if ( $_POST[ "mon_action" ] == "gerer" ) {
		$produit = new Produit();
		$imageManager = New ImageManager();
		
		// ---- Traitement de l'image ------------------- //
		if ( $_POST[ "url1" ] != '' ) {
			$source = $_SERVER[ "DOCUMENT_ROOT" ] . $_POST[ "url1" ];
			if ( $debug ) echo "Source : " . $source . "<br>";
			
			if( strstr( $source, 'uploads' ) ) {
				$source = $_SERVER[ "DOCUMENT_ROOT" ] . $_POST[ "url1" ];
				$filenameDest = $imageManager->fileDestManagement( $source, $_POST[ "id" ] );
				
				// ---- Image -------- //
				$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/photos/produit' . $filenameDest;
				if ( $debug ) echo "Destination : " . $destination . "<br>";
				$imageManager->imageResize( $source, $destination, 637, null, ZEBRA_IMAGE_CROP_CENTER );
				
				$_POST[ "image" ] = $filenameDest;
			}
		}
		$imageManager = null;
		// ---------------------------------------------- //
		
		// ---- Traitement des donn�es ------------------ //
		if ( 1 == 1 ) {
			$id = $produit->gererDonnees( $_POST, $debug );
		}
		// ---------------------------------------------- //
		
		// ---- Redirection apr�s traitement ------------ //
		if ( 1 == 1 ) {
			
			// ---- Modification... ---- //
			if ( $_POST[ "id" ] != '' ) $page_redirection = "/admin/produit/edition.php?id=" . $id;
			
			// ---- Ajout... ----------- //
			else $page_redirection = "/admin/produit/liste.php";
			
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
			$produit = new Produit();
			$result = $produit->supprimer( $_GET[ "id" ], $debug );
			
			if ( !$debug ) header( "Location: /admin/produit/liste.php" );
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