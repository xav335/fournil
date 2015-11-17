<?php include_once 'inc-auth-granted.php';?>
<?php include_once 'classes/utils.php';?>
<?php 
require 'classes/Planning.php';
$planning = new Planning();
$result = $planning->planningGet();
//print_r($result);
$planning = null;

$titre= null;
$url= null;
$pdf= null;
if (!empty($result)) {
	$titre= $result[0]['titre'];
	$url= $result[0]['url'];
	$pdf= $result[0]['pdf'];
}
//print_r($result);
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
				<form name="formulaire" class="form-horizontal" method="POST"  action="formprocess.php">
					<input type="hidden" name="reference" value="planning">
					<input type="hidden" name="action" id="action" value="modif">
					
					<input type="hidden"  name="idImage"  id="idImage" value="">
					
				<div class="col-md-9" >
					<div class="form-group">
						<label class="col-sm-1" for="titre">Titre :</label>
		            	<input type="text" class="col-sm-4" name="titre" required id="titre" value="<?php echo $titre ?>">
		            </div>
		            <div class="form-group" style=" border:6px ridge white; padding: 30px 10px 30px 10px; ">
		            	<a href="javascript:openCustomRoxy('pdf')"><img src="/admin/img/imgPDF.png" id="customRoxyImage" style="max-width:700px;"></a>
		            	<input type="hidden"  name="pdf"  id="pdfpdf" value="<?php echo $pdf ?>"><br>
		            	<h3><a id="customRoxyImagepdf" href="<?php echo '/photos/bdc'.$pdf ?>" target="_blank"><?php echo $pdf ?></a></h3>
					<br>
					</div>
					
		 		</div>
		    	<div class="col-md-3">
		    		<br><br><br><br><br><br>
					<button class="btn btn-success col-sm-12" type="submit" class="btn btn-default" onclick="return validation('envoi')"> valider </button>
				</div>
				</form>
					<script type="text/javascript">
						function validation(variable){
							$('#postaction').val(variable);
							return confirm('Etes vous certain !');
						}
					
					</script>
					
					<script type="text/javascript">
						function openCustomRoxy(idImage){
							$('#idImage').val(idImage);
							$('#roxyCustomPanel').dialog({modal:true, width:875,height:600});
						}
						function closeCustomRoxy(){
						  	$('#roxyCustomPanel').dialog('close');
						}
						function clearImage(idImage){
							$('#customRoxyImage'+idImage).attr('src', '/img/ajoutImage.jpg');
							$('#url'+idImage).val('');
						}
					</script>
			</div>
		</div>
		<div id="roxyCustomPanel" style="display: none;">
  			<iframe src="/admin/fileman2/index.html?integration=custom" style="width:100%;height:100%" frameborder="0"></iframe>
		</div>
</body>
</html>


