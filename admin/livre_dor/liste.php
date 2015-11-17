<? include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/inc-auth-granted.php" );?>
<? include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/classes/utils.php" );?>
<? 
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require $_SERVER['DOCUMENT_ROOT'] . "/admin/classes/Goldbook.php";

	$goldbook = new Goldbook();
	$result = $goldbook->goldbookGet(null);
	//print_r($result);
	if (empty($result)) {
		$message = 'Aucun enregistrements';
	} else {
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
								<th class="col-md-1" style="">
									ID
								</th>
								<th class="col-md-1" style="">
									Date
								</th>
								<th class="col-md-2" style="">
									Nom
								</th>
								<th class="col-md-2" style="">
									Email
								</th>
								<th class="col-md-4" style="">
									Message
								</th>
								<th class="col-md-1" style="">
									En ligne
								</th>
								<th class="col-md-1" colspan="2" style="">
									Actions
								</th>
								
							</tr>
						</thead>
						<tbody>
							<?php 
							if (!empty($result)) {
								$i=0;
								foreach ($result as $value) { 
								$i++;
								if($value['online']=='1') {
									$online = 'check';
								} else {
									$online = 'vide';
								}
								?>
								<tr class="<?php if ($i%2!=0) echo 'info'?>">
									<td><?php echo $value['id']?></td>
									<td><?php echo traitement_datetime_affiche($value['date'])?></td>
									<td><?php echo $value['nom']?></td>
									<td><?php echo $value['email']?></td>
									<td><?php echo $value['message']?></td>
									<td><img src="../img/<?php echo $online ?>.png" width="30" ></td>
									<td><a href="./edition.php?id=<?php echo $value['id'] ?>"><img src="../img/modif.png" width="30" alt="Modifier" ></a></td>
									<td>
										<div style="display: none;" class="supp<?php echo $value['id']?> alert alert-warning alert-dismissible fade in" role="alert">
									      <button type="button" class="close"  aria-label="Close" onclick="$('.supp<?php echo $value['id']?>').css('display', 'none');"><span aria-hidden="true">×</span></button>
									      <strong>Voulez vous vraiment supprimer ?</strong>
									      <button type="button" class="btn btn-danger" onclick="location.href='../formprocess.php?reference=goldbook&action=delete&id=<?php echo $value['id'] ?>'">Oui !</button>
									 	</div>
									<img src="../img/del.png" width="20" alt="Supprimer" onclick="$('.supp<?php echo $value['id']?>').css('display', 'block');"> </td>
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


