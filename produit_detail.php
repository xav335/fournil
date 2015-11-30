<?
	include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Categorie.php";
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Produit.php";
	
	$debug = false;
	$categorie = new Categorie();
	$produit = new Produit();
	
	$id_categorie = intval( $_GET[ "idc" ] );
	$id_produit = intval( $_GET[ "idp" ] );
	
	// ---- Liste des catégories enfants ---------- //
	if ( 1 == 1 ) {
		unset( $recherche );
		$recherche[ "id_parent" ] = $id_categorie;
		$liste_categorie = $categorie->getListe( $recherche, $debug );
	}
	// -------------------------------------------- //
	
	// ---- Infos sur le produit à afficher ------- //
	if ( 1 == 1 ) {
		$data = $produit->getInfoProduit( $id_categorie, $id_produit, $debug );
		//print_pre( $data );
		//exit();
		
		$id_produit =	$data[ 0 ][ "id" ];
		$titre = 		$data[ 0 ][ "nom" ];
		$description =	$data[ 0 ][ "description" ];
		$image =		$data[ 0 ][ "image" ];
		$tab_tag =		explode( ";", $data[ 0 ][ "tag" ] );
	}
	// -------------------------------------------- //
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<title>Le Fournil d'Artigues > <?=$titre?></title>
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/meta.php" ); ?>
	</head>
	<body class="page">
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/top.php" ); ?>
		
		<!-- Content -->
		<div class="row">
			
			<h2><a href="nos-produits.php">Nos produits</a> > <?=$titre?></h2>
			
			<div class="large-4 medium-4 small-12 columns liste-produits">
				<?
				// ---- Affichage des catégories enfants ----- //
				if ( !empty( $liste_categorie ) ) {
					foreach( $liste_categorie as $_categorie ) {
						echo "<p class='active'>" . $_categorie[ "nom" ] . "</p>\n";
						
						// ---- Recherche des produits associés à cette sous catégorie ---- //
						unset( $recherche );
						$recherche[ "id_categorie" ] = $_categorie[ "id" ];
						$recherche[ "online" ] = '1';
						$liste_produit = $produit->getListe( $recherche, $debug );
						// ---------------------------------------------------------------- //
						
						// ---- Affichage des produits ------------------------------------ //
						if ( !empty( $liste_produit ) ) {
							foreach( $liste_produit as $_produit ) {
								
								$classe_active = ( $id_produit == $_produit[ "id" ] ) ? "class='active'" : "";
								$url = "produit_detail.php?idc=" . $id_categorie . "&idp=" . $_produit[ "id" ];
								echo "<a href='" . $url . "' title='" . $_produit[ "nom" ] . "' " . $classe_active . ">" . $_produit[ "nom" ] . "</a>\n";
							}
							echo "<p>&nbsp;</p>\n";
						}
						// ---------------------------------------------------------------- //
						
					}
				}
				// ------------------------------------------- //
				?>
			</div>
			<div class="large-8 medium-8 small-12 columns fiche">
				
				<?
				// ---- Description du produit -------------- //
				echo "<p>" . nl2br( $description ) . "</p>\n";
				
				// ---- Affichage de la zone des tags ------- //
				/*if ( !empty( $tab_tag ) ) {
					echo "<ul class='parfum'>\n";
					
					foreach( $tab_tag as $_tag ) {
						echo "<li>" . trim( $_tag ) . "</li>\n";
					}
					
					echo "</ul>\n";
					echo "<div style='clear:both;'></div>\n";
				}*/
				// ------------------------------------------ //
				
				// ---- Image du produit -------------------- //
				echo "<p><img src='/photos/produit" . $image . "' alt='" . $titre . "' title='" . $titre . "' /></p>\n";
				?>
				
			</div>
		</div>
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/footer.php" ); ?>
		
	    <script>
	    	
			$(document).ready(function(){
				$('.menu a:nth-of-type(3)').addClass('active');
			});
			
		</script>
		
	</body>
</html>
