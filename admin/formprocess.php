<?php
	require '../inc/inc.config.php';
	require 'classes/Authentication.php';
	require 'classes/Offre_type_bien.php';
	require 'classes/Offre.php';
	require 'classes/Offre_image.php';
	require 'classes/News.php';
	require 'classes/Contact.php';
	require 'classes/Goldbook.php';
	require 'classes/Catproduct.php';
	require 'classes/Planning.php';
	require 'classes/ImageManager.php';
	require 'classes/utils.php';
	session_start();
	
	$debug = false;
	
	$authentication = new Authentication();
	
	// ---- Security ---------------------------------------------------------- //
	if (!isset($_SESSION[ "accessGranted" ]) || !$_SESSION[ "accessGranted" ]) {
		$result = $storageManager->grantAccess($_POST[ "login" ], $_POST[ "mdp" ]);
		if (!$result){
			header('Location: /admin/?action=error');
		} else {
			$_SESSION[ "accessGranted" ] = true;
		}
	}
	// ------------------------------------------------------------------------ //
	
	// ---- Forms processing -------------------------------------------------- //
	if ( $debug ) print_pre( $_POST );
	if (!empty($_POST)){
		
		// ---- Traitement des Contact
		if ($_POST[ "reference" ] == 'contact'){
			$contact = new Contact();
			if ($_POST[ "action" ] == 'modif') { //Modifier
				try {
					$result = $contact->contactModify($_POST);
					$contact = null;
					header('Location: /admin/contact-list.php');
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$contact = null;
					exit();
				}
		
			} else {  //ajouter
				try {
					$result = $contact->contactAdd($_POST);
					$contact = null;
					header('Location: /admin/contact-edit.php?id='.$result);
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$contact = null;
					exit();
				}
			}
		}
		// ----------------------------------------------------------- //
		
		// ---- Traitement des offres -------------------------------- //
		if ( $_POST[ "reference" ] == "offres" ){
			if ( $debug ) echo "Traitement des offres...<br>";
			
			$offre = new Offre();
			$offre_type_bien = new Offre_type_bien();
			$offre_image = new Offre_image();
			$imageManager = New ImageManager();
			
			// ---- Modifier l'offre --------------------------------------------- //
			if ( $_POST[ "action" ] == 'modif' ) {
				try {
					$num_offre = $offre->modifier( $_POST, $debug );
					
					// ---- Suppression éventuelle des anciennes données ----------------- //
					$offre_type_bien->supprimer( $num_offre, 0, $debug );
					
					// ---- MAJ des types de bien associés à l'offre --------------------- //
					foreach( $_POST[ "type_bien" ] as $num_type_bien ) {
						$val[ "num_offre" ] = $num_offre;
						$val[ "num_type_bien" ] = $num_type_bien;
						$offre_type_bien->ajouter( $val, $debug );
					}
					
					$page = "/admin/offre/liste.php";
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					exit();
				}
				
			} 
			// ------------------------------------------------------------------- //
			
			// ---- Ajouter une offre -------------------------------------------- //
			else {
				try {
					$num_offre = $offre->ajouter( $_POST, $debug );
					//$page = "/admin/offre/edition.php?id=" . $num_offre;
					$page = "/admin/offre/liste.php";
				} catch ( Exception $e ) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					exit();
				}
			}
			// ------------------------------------------------------------------- //
			
			// ---- Gestion des images de l'offre -------------------------------- //
			//print_pre( $_POST[ "mes_images" ] );
			if ( !empty( $_POST[ "mes_images" ] ) ) {
				foreach( $_POST[ "mes_images" ] as $_image ) {
					$source = $_SERVER[ "DOCUMENT_ROOT" ] . $_image;
					$filenameDest = $imageManager->fileDestManagement( $source, $num_offre );
					if ( $debug ) echo "--- filenameDest : " . $filenameDest . "<br>";
					
					// ---- En fonction de l'orientation de l'image ---- //
					if ( 1 == 1 ) {
						/*$size = getimagesize( $filenameDest );
						$largeur = $size[ 0 ];
						$hauteur = $size[ 1 ];
					
						// ---- Format Paysage ----------------------------- //
						if ( $largeur >= $hauteur ) {*/
							
							// ---- Image de taille "grande" ----- //
							$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/photos/offre/grande' . $filenameDest;
							if ( $debug ) echo "--- destination : " . $destination . "<br>";
							$imageManager->imageResize( $source, $destination, 1500, null );
							
							// ---- Image de taille "normale" ---- //
							$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/photos/offre/normale' . $filenameDest;
							if ( $debug ) echo "--- destination : " . $destination . "<br>";
							$imageManager->imageResize( $source, $destination, 470, null );
							
							// ---- Image de taille "vignette" --- //
							$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/photos/offre/vignette' . $filenameDest;
							if ( $debug ) echo "--- destination : " . $destination . "<br>";
							$imageManager->imageResize( $source, $destination, 303, null );
							
						/*}
						// ------------------------------------------------- //
						
						// ---- Format Portrait ---------------------------- //
						else {
							
							// ---- Image de taille "normale" ---- //
							$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/photos/offre/normale' . $filenameDest;
							if ( $debug ) echo "--- destination : " . $destination . "<br>";
							$imageManager->imageResize( $source, $destination, null, null );
							
							// ---- Image de taille "grande" ----- //
							$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/photos/offre/grande' . $filenameDest;
							if ( $debug ) echo "--- destination : " . $destination . "<br>";
							$imageManager->imageResize( $source, $destination, null, 710 );
							
							// ---- Image de taille "vignette" --- //
							$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/photos/offre/vignette' . $filenameDest;
							if ( $debug ) echo "--- destination : " . $destination . "<br>";
							$imageManager->imageResize( $source, $destination, 303, 215 );
							
						}*/
						// ------------------------------------------------- //
					
					}
					// ------------------------------------------------- //
					
					// ---- Enregistrement de l'image ------------------ //
					unset( $val );
					$val[ "num_offre" ] = $num_offre;
					$val[ "fichier" ] = $filenameDest;
					$val[ "defaut" ] = 'non';
					$offre_image->ajouter( $val, $debug );
					// ------------------------------------------------- //
				}
			}
			// ------------------------------------------------------------------- //
			
			// ---- Gestion du PDF ----------------------------------------------- //
			if ( $_POST[ "url1_changement" ] != '' ) {
				if ( $_POST[ "url1" ] != '' ) {
					$source = $_SERVER[ "DOCUMENT_ROOT" ] . $_POST[ "url1" ];
					$filenameDest = $imageManager->fileDestManagement( $source, $num_offre );
					if ( $debug ) echo "--- filenameDest : " . $filenameDest . "<br>";
					
					$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/fichier/pdf' . $filenameDest;
					if ( $debug ) echo "--- destination : " . $destination . "<br>";
					
					// ---- Copie du fichier ----------- //
					copy( $source, $destination );
				}
				
				// ---- MAJ de l'enregistrement ---- //
				$offre->setChamp( "fichier_pdf", $filenameDest, $num_offre, $debug );
			}
			// ------------------------------------------------------------------- //
			
			// ---- Redirection ... ---------------------------------------------- //
			if ( !$debug ) header( "Location: " . $page );
		}
		if ( $_POST[ "reference" ] == "par defaut" ){
			$offre_image = new Offre_image();
			
			// ---- Liste des autres images de l'offre ---- //
			unset( $recherche );
			$recherche[ "num_offre" ] = $_POST[ "num_offre" ];
			$liste_image = $offre_image->getListe( $recherche, $debug );
			
			// ---- On passe toutes les autres à "non" ---- //
			if ( !empty( $liste_image ) ) {
				foreach( $liste_image as $_image ) {
					$offre_image->setChamp( "defaut", 'non', $_image[ "num_image" ], $debug );
				}
			}
			
			$offre_image->setChamp( "defaut", 'oui', $_POST[ "num_image" ], $debug );
			if ( !$debug ) header( "Location: /admin/offre/edition.php?id=" . $_POST[ "num_offre" ] );
		}
		if ( $_POST[ "reference" ] == "supprimer image" ){
			$offre_image = new Offre_image();
			$offre_image->supprimer( $_POST[ "num_image" ], $debug );
			if ( !$debug ) header( "Location: /admin/offre/edition.php?id=" . $_POST[ "num_offre" ] );
		}
		// ----------------------------------------------------------- //
		
		// ---- Traitement des news ---------------------------------- //
		if ( $_POST[ "reference" ] == 'news' ) {
			if ( $debug ) echo "Traitement des news...<br>";
			
			$news = new News();
			$imageManager = New ImageManager();
			
			for ( $i=1; $i<2; $i++ ) {
				$source = $_SERVER[ "DOCUMENT_ROOT" ] . $_POST[ 'url' . $i ];
				if ( $debug ) echo "Source : " . $source . "<br>";
				
				if( strstr( $source, 'uploads' ) ) {
					$source = $_SERVER[ "DOCUMENT_ROOT" ] . $_POST[ 'url' . $i ];
					$filenameDest = $imageManager->fileDestManagement( $source, $_POST[ "id" ] );
					
					// ---- Image
					$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/photos/news' . $filenameDest;
					if ( $debug ) echo "Destination : " . $destination . "<br>";
					$imageManager->imageResize( $source, $destination, 313, null );
					
					// ---- Vignette
					$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/photos/news/thumbs' . $filenameDest;
					$imageManager->imageResize( $source, $destination, 279, null );
					$_POST[ 'url' . $i ] = $filenameDest;
				}
			}
			$imageManager =null;
			
			// ---- Modifier la news --------------------------------------------- //
			if ( $_POST[ "action" ] == 'modif' ) {
				try {
					$result = $news->newsModify( $_POST );
					if ( !$debug ) header( "Location: /admin/actualite/liste.php" );
				} 
				catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					exit();
				}
				
			} 
			
			// ---- ajouter une news --------------------------------------------- //
			else {
				try {
					$result = $news->newsAdd( $_POST );
					if ( !$debug ) header( "Location: /admin/actualite/edition.php?id=" . $result );
				} 
				catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					exit();
				}
			}
			
		}
		// ----------------------------------------------------------- //
		
		// ---- Traitement des livres d'or --------------------------- //
		if ($_POST[ "reference" ] == 'goldbook'){
			$goldbook = new Goldbook();
			if ($_POST[ "action" ] == 'modif') { //Modifier 
				try {
					$result = $goldbook->goldbookModify($_POST);
					$goldbook = null;
					header('Location: /admin/livre_dor/liste.php');
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$goldbook = null;
					exit();
				}
					
			} else {  //ajouter 
				try {
					$result = $goldbook->goldbookAdd($_POST);
					$goldbook = null;
					header('Location: /admin/livre_dor/edition.php?id='.$result);
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$goldbook = null;
					exit();
				}
			}
		}
		// ----------------------------------------------------------- //
		
		// Traitement des Categories --------------------------------- //
		if ($_POST[ "reference" ] == 'categorie'){
			//print_r($_POST);exit();
			$imageManager = New ImageManager();
			$catproduct = new Catproduct();
			if ($_POST[ "action" ] == 'modif') { //Modifier
				try {
					//Gestion des images
					$source = $_SERVER[ "DOCUMENT_ROOT" ].$_POST[ "url1" ];
	
					if (strstr($source,'uploads')){
						$source = $_SERVER[ "DOCUMENT_ROOT" ].$_POST[ "url1" ];
						$filenameDest = $imageManager->fileDestManagement($source,$_POST[ "id" ]);
						//Image
						$destination=$_SERVER[ "DOCUMENT_ROOT" ].'/photos/categories'.$filenameDest;
						$imageManager->imageResize($source, $destination, null, 650);
						//Vignette
						$destination=$_SERVER[ "DOCUMENT_ROOT" ].'/photos/categories/thumbs'.$filenameDest;
						$imageManager->imageResize($source, $destination, null, 350);
						$_POST[ "url1" ]=$filenameDest;
					}
					$imageManager =null;
					
					$result = $catproduct->catproductModify($_POST);
					$catproduct = null;
					header('Location: /admin/catproduct-list.php');
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$catproduct = null;
					exit();
				}
		
			} else {  //ajouter
				try {
					//print_r($_POST);exit();
					$result = $catproduct->catproductAdd($_POST);
					$catproduct = null;
					header('Location: /admin/catproduct-list.php');
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$catproduct = null;
					exit();
				}
			}
		}
		// ----------------------------------------------------------- //
		
		// ---- Traitement des Produits ------------------------------ //
		if ($_POST[ "reference" ] == 'product'){
			//print_r($_POST);exit();
			$catproduct = new Catproduct();
			$imageManager = New ImageManager();
			for ($i=1;$i<4;$i++){
				$source = $_SERVER[ "DOCUMENT_ROOT" ].$_POST[ "url" . $i ];
				if(strstr($source,'uploads')){
					$source = $_SERVER[ "DOCUMENT_ROOT" ].$_POST[ "url" . $i ];
					$filenameDest = $imageManager->fileDestManagement($source,$_POST[ "id" ]);
					//Image
					$destination=$_SERVER[ "DOCUMENT_ROOT" ].'/photos/products'.$filenameDest;
					$imageManager->imageResize($source, $destination, null, 650);
					//Vignette
					$destination=$_SERVER[ "DOCUMENT_ROOT" ].'/photos/products/thumbs'.$filenameDest;
					$imageManager->imageResize($source, $destination, null, 250);
					$_POST[ "url" . $i ]=$filenameDest;
				}
			}
	
			if ($_POST[ "action" ] == 'modif') { //Modifier
				try {
					$result = $catproduct->productModify($_POST);
					$catproduct = null;
					header('Location: /admin/product-list.php');
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$catproduct = null;
					exit();
				}
		
			} else {  //ajouter
				try {
					//print_r($_POST);exit();
					$result = $catproduct->productAdd($_POST);
					$catproduct = null;
					header('Location: /admin/product-list.php');
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$catproduct = null;
					exit();
				}
			}
		}
		// ----------------------------------------------------------- //
		
	} 
	// ------------------------------------------------------------------------ //
	
	// ---- GET GET GET ------------------------------------------------------- //
	elseif ( !empty( $_GET ) ) {
		
		// ---- Suppression d'une offre -------------------- //
		if ( $_GET[ "reference" ] == "offre" ) {
			$offre = new Offre();
			
			if ( $_GET[ "action" ] == 'delete' ) {
				try {
					$result = $offre->supprimer( $_GET[ "id" ], $debug );
					$offre = null;
					if ( !$debug ) header( "Location: /admin/contact-list.php" );
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$offre = null;
					exit();
				}
			}
		}
		// ------------------------------------------------- //
		
		
		if ($_GET[ "reference" ] == 'contact'){ //supprimer
			$contact = new Contact();
			if ($_GET[ "action" ] == 'delete'){
				try {
					$result = $contact->contactDelete($_GET[ "id" ]);
					$contact = null;
					header('Location: /admin/contact-list.php');
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$contact = null;
					exit();
				}
			}
		}
		
		if ($_GET[ "reference" ] == 'news'){ //supprimer
			$news = new News();
			if ($_GET[ "action" ] == 'delete'){
				try {
					$result = $news->newsDelete($_GET[ "id" ]);
					$news = null;
					header('Location: /admin/actualite/liste.php');
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$news = null;
					exit();
				}
			}	
		}
		
		if ($_GET[ "reference" ] == 'goldbook'){ //supprimer
			$goldbook = new Goldbook();
			if ($_GET[ "action" ] == 'delete'){
				try {
					$result = $goldbook->goldbookDelete($_GET[ "id" ]);
					$goldbook = null;
					header('Location: /admin/livre_dor/liste.php');
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					$goldbook = null;
					exit();
				}
			}
		}
		
		if ($_GET[ "reference" ] == 'categorie'){ //supprimer
			$catproduct = new Catproduct();
			if ($_GET[ "action" ] == 'delete'){
				try {
					$result = $catproduct->catproductDelete($_GET[ "id" ]);
					$catproduct = null;
					header('Location: /admin/catproduct-list.php');
				} catch (Exception $e) {
						echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage() , '\n';
						$catproduct = null;
						if($e->getCode() == 1234){
							header('Location: /admin/catproduct-list.php?message='.$e->getCode());
						}
						exit();
				}
			}
		}
		
		if ($_GET[ "reference" ] == 'product'){ //supprimer
			$catproduct = new Catproduct();
			if ($_GET[ "action" ] == 'delete'){
				try {
					$result = $catproduct->productDelete($_GET[ "id" ]);
					$catproduct = null;
					header('Location: /admin/product-list.php');
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage() , '\n';
					$catproduct = null;
					if($e->getCode() == 1234){
						header('Location: /admin/catproduct-list.php?message='.$e->getCode());
					}
					exit();
				}
			}
		}
		
		if ($_GET[ "reference" ] == 'newsletter'){ //supprimer
			$newsletter = new Newsletter();
			if ($_GET[ "action" ] == 'delete'){
				try {
					$result = $newsletter->newsletterDelete($_GET[ "id" ]);
					$newsletter = null;
					header('Location: /admin/newsletter-list.php');
				} catch (Exception $e) {
					echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
					exit();
				}
			}
		}
		
	} 
	// ------------------------------------------------------------------------ //
	
	else {
		header('Location: /admin/');
	}
?>