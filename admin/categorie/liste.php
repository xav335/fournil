<? include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-auth-granted.php" );?>
<? include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );?>
<? 
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

	if ( empty( $liste_categorie ) ) {
		$message = 'Aucun enregistrement';
	} 
	else {
		$message = '';
	}

?>

<!doctype html>
<html class="no-js" lang="en">
	<head>
		<? include_once $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-meta.php";?>
	</head>
	
	<body>	
		<? require_once $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-menu.php";?>
	
		<div class="container">
	
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
	
					<table class="table table-hover table-bordered table-condensed table-striped" >
						<thead>
							<tr>
								<th class="col-md-8" style="">Titre</th>
								<th class="col-md-2" style="">Photo</th>
								<th class="col-md-2" colspan="2" style="">Actions</th>
							</tr>
						</thead>
						<tbody>
							<? 
							if ( !empty( $liste_categorie ) ) {
								$i=0;
								foreach ( $liste_categorie as $value ) {
									$i++;
									
									$classe_affichage = ( $i % 2 != 0 ) ? "info" : "";
									$image_ok = ( !empty( $value[ "image" ] ) && isset( $value[ "image" ] ) ) ? "image OK" : "&nbsp;";
									
									echo "<tr class='" . $classe_affichage . "'>\n";
									echo "	<td>#" . $i . " - " . $value[ "nom" ] . "</td>\n";
									echo "	<td>" . $image_ok . "</td>\n";
									echo "	<td><a href='./edition.php?id=" . $value[ "id" ] . "'><img src='../img/modif.png' width='30' alt='Modifier' ></a></td>\n";
									echo "	<td>\n";
									echo "		<div style='display: none;' class='supp" . $value[ "id" ] . " alert alert-warning alert-dismissible fade in' role='alert'>\n";
									echo "			<button type='button' class='close' aria-label='Close' onclick=\"$('.supp" . $value[ "id" ] . "').css('display', 'none');\"><span aria-hidden='true'>×</span></button>\n";
									echo "			<strong>Voulez vous vraiment supprimer ?</strong>\n";
									echo "			<button type='button' class='btn btn-danger' onclick=\"location.href='./traitement.php?reference=news&action=delete&id=" . $value[ "id" ] . "'\">Oui !</button>\n";
									echo "		</div>\n";
									echo "		<img src='../img/del.png' width='20' alt='Supprimer' onclick=\"$('.supp" . $value[ "id" ] . "').css('display', 'block');\">\n";
									echo "	</td>\n";
									echo "</tr>\n";
									
									// ---- Recherche des catégories enfants ------- //
									unset( $recherche );
									$recherche[ "id_parent" ] = $value[ "id" ];
									$liste_enfant = $categorie->getListe( $recherche, $debug );
									// --------------------------------------------- //
									
									if ( !empty( $liste_enfant ) ) {
										$cpt = 0;
										foreach( $liste_enfant as $_categorie ) {
											$cpt++;
											$tabulation = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											
											$classe_affichage = ( $i % 2 != 0 ) ? "info" : "";
											$image_ok = ( !empty( $_categorie[ "image" ] ) && isset( $_categorie[ "image" ] ) ) ? "image OK" : "&nbsp;";
											
											echo "<tr class='" . $classe_affichage . "'>\n";
											echo "	<td>" . $tabulation . "#" . $cpt . " - " . $_categorie[ "nom" ] . "</td>\n";
											echo "	<td>" . $image_ok . "</td>\n";
											echo "	<td><a href='./edition.php?id=" . $_categorie[ "id" ] . "'><img src='../img/modif.png' width='30' alt='Modifier' ></a></td>\n";
											echo "	<td>\n";
											echo "		<div style='display: none;' class='supp" . $_categorie[ "id" ] . " alert alert-warning alert-dismissible fade in' role='alert'>\n";
											echo "			<button type='button' class='close' aria-label='Close' onclick=\"$('.supp" . $_categorie[ "id" ] . "').css('display', 'none');\"><span aria-hidden='true'>×</span></button>\n";
											echo "			<strong>Voulez vous vraiment supprimer ?</strong>\n";
											echo "			<button type='button' class='btn btn-danger' onclick=\"location.href='./traitement.php?reference=news&action=delete&id=" . $_categorie[ "id" ] . "'\">Oui !</button>\n";
											echo "		</div>\n";
											echo "		<img src='../img/del.png' width='20' alt='Supprimer' onclick=\"$('.supp" . $_categorie[ "id" ] . "').css('display', 'block');\">\n";
											echo "	</td>\n";
											echo "</tr>\n";
										}
									}
								}
							}
							?>
						</tbody>
					</table>
	
					<h3><?=$message?></h3>
				</div>
			</div>
		</div>
	</body>
</html>


