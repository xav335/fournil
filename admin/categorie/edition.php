<?
	include_once '../../inc/inc.config.php';
	include_once '../inc-auth-granted.php';
	include_once '../classes/utils.php';
	require '../classes/Categorie.php';
	
	$debug = false;
	$categorie = new Categorie();
	
	// ---- Modification ---------------------------- //
	if ( !empty( $_GET ) ) {
		$action = 'modif';
		$categorie = new Categorie();
		$result = $categorie->load( $_GET[ "id" ] );

		if ( !empty( $result ) ) {
			$titre_page = 	'Catégorie "'. $result[ 0 ][ "nom" ] . '"';
			$id =			$_GET[ "id" ];
			$id_parent = 	$result[ 0 ][ "id_parent" ];
			$nom = 			$result[ 0 ][ "nom" ];
			$image[ 1 ] = 	$result[ 0 ][ "image" ];
			$tag = 			$result[ 0 ][ "tag" ];
			
			if( empty( $image[ 1 ] ) || !isset( $image[ 1 ] ) ) {
				$img[ 1 ] = "/img/favicon.png";
				$imgval[ 1 ] = "/img/favicon.png";
			} 
			else {
				$img[ 1 ] = '/photos/categorie'. $image[ 1 ];
				$imgval[ 1 ] = $image[ 1 ];
			}
		}
		else $message = 'Aucun enregistrement';
	} 

	// ---- Ajout d'une rubrique -------------------- //
	else {
		$action = 'add';
		$titre_page = 	'Nouvelle catégorie';
		$id	=			null;
		$nom = 			null;
		$sous_titre =	null;
		$img[ 1 ] = 	"/img/favicon.png";
		$imgval[ 1 ] = 	"/img/favicon.png";
		$tag = 			null;
	}
	
	// ---- Liste des catégories de niveau 0 -------- //
	if ( 1 == 1 ) {
		unset( $recherche );
		$recherche[ "id_parent" ] = 0;
		$liste_categorie = $categorie->getListe( $recherche, $debug );
	}
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<? include_once "../inc-meta.php" ; ?>
	</head>
	
	<body>	
		<? require_once "../inc-menu.php" ; ?>
	
		<div class="container">
	
			<div class="row">
				<h3><?=$titre_page?></h3><br>
				<div class="col-xs-12 col-sm-12 col-md-12">
					
					<form name="formulaire" class="form-horizontal" method="POST" action="traitement.php">
						<input type="hidden" name="mon_action" value="gerer">
						<input type="hidden" name="id" id="id" value="<?=$id?>">
						
						<div class="form-group" >
							<label class="col-sm-2" for="titre">Catégorie parent :</label>
							<select name="id_parent">
								<option value="0" selected>-- Aucune --</option>
								<?
								if ( !empty( $liste_categorie ) ) {
									foreach( $liste_categorie as $_categorie ) {
										$selected = ( $id_parent == $_categorie[ "id" ] ) ? "selected" : "";
										
										echo "<option value='" . $_categorie[ "id" ] . "' " . $selected . " >" . $_categorie[ "nom" ] . "</option>\n";
									}
								}
								?>
							</select>
						</div>
						
						<div class="form-group" >
							<label class="col-sm-2" for="titre">Titre :</label>
							<input type="text" class="col-sm-10" name="nom" required value="<?=$nom?>">
						</div>
						
						<div class="form-group"><br>
							<label for="titre">Choisissez la photo </label>
							<input type="hidden" name="idImage" id="idImage" value="">
						</div>	
						
						<div class="col-md-4" style="margin-bottom:20px;">
							<input type="hidden" name="url1" id="url1" value="<?=$imgval[ 1 ]?>"><br>
							<a href="javascript:openCustomRoxy('1')"><img src="<?=$img[ 1 ]?>" id="customRoxyImage1" style="max-width:200px;"></a>
							<img src="img/del.png" width="20" alt="Supprimer" onclick="clearImage( 1 )"/>
						</div>	
						
						<div id="roxyCustomPanel" style="display:none;">
							<iframe src="/admin/fileman2/index.php?integration=custom" style="width:100%;height:100%" frameborder="0"></iframe>
						</div>
						
						<div style="clear:both;"></div>
						<a href="./liste.php" class="btn btn-success col-sm-6" class="btn btn-default annuler"> Annuler </a>	
						<button type="submit" class="btn btn-success col-sm-6" class="btn btn-default"> Valider </button>
				  </form>
				  
				</div>
			</div>
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
		
		
	</body>
</html>


