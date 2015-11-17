<?
	include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/News.php";
	
	$debug = false;
	$news = new News();
	
	// ---- Liste des actualités en ligne ---- //
	if ( 1 == 1 ) {
		$liste_actualite = $news->newsValidGet( $debug );
		$contenu_actualite = '';
		$classe_texte = "large-12 medium-12";
		
		if ( !empty( $liste_actualite ) ) {
			foreach( $liste_actualite as $_actualite ) {
				$accroche = couper_correctement( $_actualite[ "contenu" ], 45, ' ', false );
				if ( strlen( $_actualite[ "contenu" ] ) > 45 ) $accroche .= " ...";
				$image = ( $_actualite[ "image1" ] != '' )
					? "/photos/news/thumbs" . $_actualite[ "image1" ]
					: "/img/favicon.png";
				
				$contenu_actualite = "<div class='large-4 medium-4 small-12 columns'>\n";
				$contenu_actualite .= "	<div class='actualite' onclick=\"location.href='actualites.php'\">\n";
				$contenu_actualite .= "		<h3>(Actualité)</h3>\n";
				$contenu_actualite .= "		<img src='" . $image . "' alt='' />\n";
				$contenu_actualite .= "		<p>" . $accroche . "</p>\n";
				$contenu_actualite .= "	</div>\n";
				$contenu_actualite .= "</div>\n";
				
				$classe_texte = "large-8 medium-8";
				break;
			}
		}
	}
	// --------------------------------------- //
	
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<title>Le Fournil d’Artigues</title>
		<?php include('meta.php'); ?>
	</head>
	
	<body>
		
		<?php include('top.php'); ?>
		
		<!-- Content -->
		<div class="row">
			
			<?
			// ---- Affichage des actualités ------ //
			if ( $contenu_actualite != '' ) {
				echo $contenu_actualite;
			}
			?>
			
			<div class="<?=$classe_texte?> small-12 columns">
				<h2>Le Fournil d’Artigues</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis impedit fugit voluptates sunt! Debitis, maxime, aspernatur, aperiam distinctio perspiciatis mollitia possimus cumque aut minus non tenetur vitae illo ea dicta!</p>
				<p>In neque nibh, porttitor vel viverra eu, vestibulum id nibh. Fusce aliquam magna sed accumsan sodales. Quisque ullamcorper hendrerit est. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<p>Proin eu nulla turpis. Phasellus dapibus lorem sit amet dui accumsan, vitae malesuada sem varius. Mauris porttitor sit amet sapien at venenatis.</p>
			</div>
		</div>
		<!-- End Content -->
		
		<?php include('footer.php'); ?>
	    <script>
			$(document).ready(function(){
				$('.menu a:first-of-type').addClass('active');
			});
		</script>
		
	</body>
</html>
