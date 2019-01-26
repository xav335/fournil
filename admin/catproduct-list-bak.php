<?php include_once 'inc-auth-granted.php';?>
<?php include_once 'classes/utils.php';?>
<?php 
require 'classes/Catproduct.php';

	$catproduct = new Catproduct();
	$catproduct->catproduitViewIterative(null);
	$result = $catproduct->tabView;
	$catproduct = null;
	
	//print_r($result);
	//exit();

	$parent =null;
	$label = null;
	$message = null;
	
	if (!empty($_GET)){ //Modif
		$action = 'modif';
		//print_r($result);
		//print_r($result[0]['newsletter_detail']);
		//exit();
		if (empty($result)) {
			$message = 'Aucun enregistrements';
		} else {
			$labelTitle = 'Newsletter N°: '. $_GET['id'];
			$id= 			$_GET['id'];
			$titre=  		$result[0]['titre'];
			$date= 			traitement_datetime_affiche($result[0]['date']);
		}
	} else { //ajout News
		$action = 'add';
		$labelTitle = 'Edition Nouvelle Newsletter ';
		$id= 			null;
		$titre=  		null;
	}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<?php include_once 'inc-meta.php';?>
</head>
<body>	
	<?php require_once 'inc-menu.php';?>

	<div class="container">

		<div class="row">

			<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Choisissez la catégorie parent puis indiquez le nom de la catégorie fille</h3>
						</div>
						<div class="panel-body">
							<form name="formulaire" class="form-horizontal" method="POST"  action="formprocess.php" >
								<input type="hidden" name="reference" value="categorie">
								<input type="hidden" name="action" id="action" value="<?php echo $action ?>">
								<input type="hidden" name="id" id="id" value="<?php echo $id ?>">
								
								<input type="hidden"  name="idImage"  id="idImage" value=""><br>
								<div class="row">
										<div class="row">
											<label class="col-md-3" >Catégorie Parent :</label>
											<select name="num_parent" id="num_parent">
											<option value="0" selected>-- racine --</option>
											<?
											foreach ($result as $value) { 
												$decalage = "";
												for ($i=0; $i<($value['level'] * 5); $i++) {
													$decalage .= "&nbsp;";
												}
												?>
												<option value="<?php echo $value['id'] ?>" <? if ( $parent ==  $value['id'] ) { ?> selected <? } ?>>
													<?=$decalage?><?php echo $value['label'] ?>
												</option>
												<?
											}
											?>
											</select>	
										</div>	
										<div class="row">
											<label class="col-md-3" >Nom catégorie :</label>
				            				<input type="text" class="col-md-5" name="titre" required id="titre" value="<?php echo $label ?>">
				            			</div>
								</div>	
								
				            	<div class="row">	
				            		
				            			<div class="col-md-2"><br>
											<label  for="titre">Choisissez une image pour la catégorie: </label>
										</div>	
										<div class="col-md-4">
											<?php for ($i=1;$i<2;$i++) {?>
											<input type="hidden"  name="url<?php echo $i ?>"  id="url<?php echo $i ?>" value=""><br>
					            			<a href="javascript:openCustomRoxy('<?php echo $i ?>')"><img  src="img/favicon.png"" id="customRoxyImage<?php echo $i ?>" style="max-width:200px;"></a>
											<img src="img/del.png" width="20" alt="Supprimer" onclick="clearImage(<?php echo $i ?>)"/>
											<br>
											<?php }?>
										</div>	
										<div class="col-md-6">	<br><br><br><br><br><br>
												<button class="btn btn-success col-sm-6 " type="submit" > Créer la catégorie </button>
										</div>		
								
								</div>	
							</form>
						</div>
					</div>
				</div>
					<div id="roxyCustomPanel" style="display: none;">
  							<iframe src="/admin/fileman2/index.php?integration=custom" style="width:100%;height:100%" frameborder="0"></iframe>
					</div>
					
					<script type="text/javascript">
						function openCustomRoxy(idImage){
							$('#idImage').val(idImage);
						 	$('#roxyCustomPanel').dialog({modal:true, width:875,height:600});
						}
						function closeCustomRoxy(){
						  	$('#roxyCustomPanel').dialog('close');
						}
	
						function clearImage(idImage){
							$('#customRoxyImage'+idImage).attr('src', '/img/favicon.png');
							$('#url'+idImage).val('');
						}
						
					</script>
						
				<table class="table table-hover table-bordered table-condensed table-striped" >
					<thead>
						<tr>
							<th class="col-md-4" style="">
								Liste des Categories
							</th>
							<th class="col-md-1" style="">
								Image
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
								$decalage = "";
								for ($i=0; $i<($value['level'] * 10); $i++) {
									$decalage .= "&nbsp;";
								}
							$i++;
							?>
							<tr class="<?php if ($value['level']==0) echo 'info';  if ($value['level']==1) echo 'success';?>">
								<td><?php echo $decalage.$value['label']?></td>
								<td><?php echo $value['image']?></td>
								<td><a href="catproduct-list.php?id=<?php echo $value['id'] ?>"><img src="img/modif.png" width="30" alt="Modifier" ></a></td>
								<td>
									<div style="display: none;" class="supp<?php echo $value['id_news']?> alert alert-warning alert-dismissible fade in" role="alert">
								      <button type="button" class="close"  aria-label="Close" onclick="$('.supp<?php echo $value['id_news']?>').css('display', 'none');"><span aria-hidden="true">×</span></button>
								      <strong>Voulez vous vraiment supprimer ?</strong>
								      <button type="button" class="btn btn-danger" onclick="location.href='formprocess.php?reference=news&action=delete&id=<?php echo $value['id_news'] ?>'">Oui !</button>
								 	</div>
								<img src="img/del.png" width="20" alt="Supprimer" onclick="$('.supp<?php echo $value['id_news']?>').css('display', 'block');"> </td>
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


