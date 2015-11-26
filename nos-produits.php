<?
	include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Categorie.php";
	
	$debug = false;
	$categorie = new Categorie();
	
	// ---- Liste des catégories de niveau 0 ------ //
	if ( 1 == 1 ) {
		unset( $recherche );
		$recherche[ "id_parent" ] = 0;
		$liste_categorie = $categorie->getListe( $recherche, $debug );
	}
	// -------------------------------------------- //
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<title>Le Fournil d’Artigues > Nos Produits</title>
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/meta.php" ); ?>
	</head>
	<body class="page">
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/top.php" ); ?>
		
		<div class="row catalogue">
			
			<h2>Nos produits</h2>
			
			<?
			if ( !empty( $liste_categorie ) ) {
				foreach ( $liste_categorie as $value ) {
					$titre = $value[ "nom" ];
					$image = ( $value[ "image" ] != '' ) 
						? "/photos/categorie" . $value[ "image" ]
						: "/img/favicon.png";
					
					echo "<div class='large-4 medium-4 small-12 columns'>\n";
					echo "	<a href='produit_detail.php?idc=" . $value[ "id" ] . "' class='produit' title='" . $titre . "'>\n";
					echo "		<h3>" . $titre . "</h3>\n";
					echo "		<img src='" . $image . "' alt='' />\n";
					echo "		<p>Voir nos produits</p>\n";
					echo "	</a>\n";
					echo "</div>\n";
				}
			}
			?>
			
		</div>
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/footer.php" ); ?>
		
	    <script>
	    	
			$(document).ready(function(){
				$('.menu a:nth-of-type(3)').addClass('active');
			});
			
		</script>
		
	</body>
</html>
