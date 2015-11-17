<? include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/inc-auth-granted.php" );?>
<? include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/classes/utils.php" );?>
<? 
	require $_SERVER['DOCUMENT_ROOT'] . "/admin/classes/Offre.php";

	$news = new Offre();
	$result = $news->getListe();
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
		<? include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc-meta.php";?>
	</head>
	
	<body>	
		<? require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc-menu.php";?>
	
		<div class="container">
	
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
	
					<table class="table table-hover table-bordered table-condensed table-striped" >
						<thead>
							<tr>
								<th class="col-md-1" style="">Titre</th>
								<th class="col-md-1" style="">Surface</th>
								<th class="col-md-6" style="">Description</th>
								<th class="col-md-1" style="">Prix</th>
								<th class="col-md-1" style="">1iere page</th>
								<th class="col-md-1" style="">En ligne</th>
								<th class="col-md-1" colspan="2" style="">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if (!empty($result)) {
								$i=0;
								foreach ($result as $value) { 
								$i++;
								$a_la_une = ( $value['a_la_une'] == "oui" ) ? "check" : "vide";
								$online = ( $value['online'] == "oui" ) ? "check" : "vide";
								?>
								<tr class="<?php if ($i%2!=0) echo 'info'?>">
									
									<td><?=$value[ "titre" ]?></td>
									<td><?=$value[ "surface" ]?></td>
									<td><?=couper_correctement( $value[ "description" ], 200, ' ', false )?> ...</td>
									<td><?=number_format( $value[ "prix" ], 0, '', ' ' )?>€</td>
									<td><img src="../img/<?=$a_la_une?>.png" width="30" ></td>
									<td><img src="../img/<?=$online?>.png" width="30" ></td>
									<td><a href="./edition.php?id=<?=$value[ "num_offre" ]?>"><img src="../img/modif.png" width="30" alt="Modifier" ></a></td>
									<td>
										<div style="display: none;" class="supp<?=$value[ "num_offre" ]?> alert alert-warning alert-dismissible fade in" role="alert">
									      <button type="button" class="close"  aria-label="Close" onclick="$('.supp<?=$value[ "num_offre" ]?>').css('display', 'none');"><span aria-hidden="true">×</span></button>
									      <strong>Voulez vous vraiment supprimer ?</strong>
									      <button type="button" class="btn btn-danger" onclick="location.href='../formprocess.php?reference=offre&action=delete&id=<?=$value[ "num_offre" ] ?>'">Oui !</button>
									 	</div>
									<img src="../img/del.png" width="20" alt="Supprimer" onclick="$('.supp<?=$value[ "num_offre" ]?>').css('display', 'block');"> </td>
								</tr>
								<?php } ?>
							<?php } ?>	
						</tbody>
					</table>
	
					<h3><?php echo $message?></h3>
				</div>
			</div>
		</div>
	</body>
</html>


