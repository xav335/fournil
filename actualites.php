<?
	include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/News.php";
	
	$debug = false;
	$news = new News();
	
	// ---- Liste des actualités en ligne ---- //
	$liste_actualite = $news->newsValidGet( $debug );
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<title>Le Fournil d'Artigues > Actualités</title>
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/meta.php" ); ?>
	</head>
	<body class="page">
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/top.php" ); ?>
		
		<div class="row">
			<h2>Actualités</h2>
			
			<?
			if ( !empty( $liste_actualite ) ) {
				foreach( $liste_actualite as $_actualite ) {
					$image = ( $_actualite[ "image1" ] != '' )
						? "/photos/news/thumbs" . $_actualite[ "image1" ]
						: "/img/favicon.png";
					
					echo "<div class='row actu'>\n";
					echo "	<div class='large-4 medium-4 small-12 columns'>\n";
					echo "		<img src='" . $image . "' alt='' />\n";
					echo "	</div>\n";
					echo "	<div class='large-8 medium-8 small-12 columns'>\n";
					echo "		<h3>" . $_actualite[ "titre" ] . "</h3>\n";
					echo "		<p>" . $_actualite[ "contenu" ] . "</p>\n";
					echo "	</div>\n";
					echo "</div>\n";
				}
			}
			?>
			
			
		</div>
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/footer.php" ); ?>
		
	    <script>
			$(document).ready(function(){
				$('.menu a:nth-of-type(5)').addClass('active');
			});
		</script>
		
	</body>
</html>
