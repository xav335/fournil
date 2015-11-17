<? include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-auth-granted.php" );?>
<? include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );?>
<? 
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/News.php";

	$news = new News();
	$result = $news->newsGet(null);
	//print_r($result);
	if ( empty( $result ) ) {
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
								<th class="col-md-1" style="">Date</th>
								<th class="col-md-1" style="">Titre</th>
								<th class="col-md-5" style="">Contenu</th>
								<th class="col-md-1" style="">Photo</th>
								<th class="col-md-1" style="">En ligne</th>
								<th class="col-md-1" colspan="2" style="">Actions</th>
							</tr>
						</thead>
						<tbody>
							<? 
							if ( !empty( $result ) ) {
								$i=0;
								foreach ( $result as $value ) {
									$i++;
									
									$online = ( $value[ "online" ] == '1' ) ? 'check' : 'vide';
									$classe_affichage = ( $i % 2 != 0 ) ? "info" : "";
									$image_ok = ( !empty( $value[ "image1" ] ) && isset( $value[ "image1" ] ) ) ? "image OK" : "&nbsp;";
									
									echo "<tr class='" . $classe_affichage . "'>\n";
									echo "	<td>" . traitement_datetime_affiche( $value[ "date_news" ] ) . "</td>\n";
									echo "	<td>" . $value[ "titre" ] . "</td>\n";
									echo "	<td>" . $value[ "contenu" ] . "</td>\n";
									echo "	<td>" . $image_ok . "</td>\n";
									echo "	<td><img src='../img/" . $online . ".png' width='30' ></td>\n";
									echo "	<td><a href='./edition.php?id=" . $value[ "id_news" ] . "'><img src='../img/modif.png' width='30' alt='Modifier' ></a></td>\n";
									echo "	<td>\n";
									echo "		<div style='display: none;' class='supp" . $value[ "id_news" ] . " alert alert-warning alert-dismissible fade in' role='alert'>\n";
									echo "			<button type='button' class='close' aria-label='Close' onclick=\"$('.supp" . $value[ "id_news" ] . "').css('display', 'none');\"><span aria-hidden='true'>×</span></button>\n";
									echo "			<strong>Voulez vous vraiment supprimer ?</strong>\n";
									echo "			<button type='button' class='btn btn-danger' onclick=\"location.href='../formprocess.php?reference=news&action=delete&id=" . $value[ "id_news" ] . "'\">Oui !</button>\n";
									echo "		</div>\n";
									echo "		<img src='../img/del.png' width='20' alt='Supprimer' onclick=\"$('.supp" . $value[ "id_news" ] . "').css('display', 'block');\">\n";
									echo "	</td>\n";
									echo "</tr>\n";
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


