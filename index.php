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
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/meta.php" ); ?>
	</head>
	
	<body>
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/top.php" ); ?>
		
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
				<p>Pain, pâtisseries, gâteaux, viennoiseries, snacks... Venez vous ressourcer et passer un bon moment au Fournil d'Artigues !</p>
				<p>L'artisan boulanger Jean-Philippe Boucaud vous accueille chaque jour pour déguster un bon repas avec ses formules Panini, Hamburger ou Sandwich. Venez également goûter nos différentes sortes de pain : maïs, moisson, coeur de lin...</p>

                <p>Le Fournil c'est aussi des bonnes pâtisseries et gâteaux faits maison pour les grandes occasions ou les petits creux. A votre disposition : macarons, meringues, tartes...
</p><p>
A découvrir également, notre espace confiseries pour les petits comme pour les grands : bonbons de toutes sortes, gâteaux aux chocolat.
</p><p>
Nous vous attendons, à très vite !
				</p>
			</div>
		</div>
		<!-- End Content -->
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/footer.php" ); ?>
		
	    <script>
			$(document).ready(function(){
				$('.menu a:first-of-type').addClass('active');
			});
		</script>
		
	</body>
</html>
