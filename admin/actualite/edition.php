<? include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-auth-granted.php" );?>
<? include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );?>
<? 
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/News.php";
	
	// ---- Modification ---------------------------- //
	if ( !empty($_GET) ) {
		$action = 'modif';
		$news = new News();
		$result = $news->newsGet( $_GET[ "id" ] );
		//print_r($result);
		
		if (empty($result)) {
			$message = 'Aucun enregistrements';
		} 
		else {
			$labelTitle = 'Actu N°: '. $_GET[ "id" ];
			$id= 			$_GET[ "id" ];
			$titre= 		$result[ 0 ][ "titre" ];
			$date_news= 	traitement_datetime_affiche($result[ 0 ][ "date_news" ]);
			$contenu= 		$result[ 0 ][ "contenu" ];
			$online = ( $result[ 0 ][ "online" ]=='1' ) ? "checked" : '';
			
			for ( $i=1; $i<2; $i++ ) {
				$image[ $i ] = $result[ 0 ][ "image" . $i ];
				
				if(empty( $image[ $i ] ) || !isset( $image[ $i ] ) ) {
					$img[ $i ] = 	"/img/favicon.png";
					$imgval[ $i ] = '';
				} 
				else {
					//$img[ $i ] = 	'/photos/news/thumbs'. $image[ $i ];
					$img[ $i ] = 	'/photos/news/thumbs'. $image[ $i ];
					$imgval[ $i ] = $image[ $i ];
				}
			}
		}
	} 
	// ---- Ajout ----------------------------------- //
	else {
		$action = 'add';
		$labelTitle = 'Edition Nouvelle actu ';
		$id= 				null;
		$titre= 			null;
		$date_news= 		null;
		$contenu= 			null;
		$online = 			null;
		for ( $i=1; $i<2; $i++ ) {
			$img[ $i ] = 	'/img/favicon.png';
			$imgval[ $i ] = '';
		}
	}
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<? include_once $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-meta.php";?>
	</head>
	
	<body>	
		<? require_once $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-menu.php";?>
	
		<div class="container">
	
			<div class="row">
				<h3><?=$labelTitle?></h3>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<form name="formulaire" class="form-horizontal" method="POST" action="../formprocess.php">
						<input type="hidden" name="reference" value="news">
						<input type="hidden" name="action" value="<?=$action?>">
						<input type="hidden" name="id" id="id" value="<?=$id?>">
						
						<div class="form-group" >
							<label class="col-sm-1">Date :</label>
							<input class="col-sm-2" type="text" name="datepicker" id="datepicker" required value="<?=$date_news?>" >
						</div>
						
						<div class="form-group" >
							<label class="col-sm-1" for="titre">Titre :</label>
							<input type="text" class="col-sm-11" name="titre" required value="<?=$titre?>">
						</div>
						
						<div class="form-group">
							<label for="contenu">Contenu :</label><br>
							<textarea class="col-sm-12" name="contenu" id="contenu" rows="5" ><?=$contenu?></textarea>
						</div>
						
						<div class="form-group" >
							<label class="col-sm-1" for="titre">En ligne :</label>
							<input type="checkbox" name="online" <?=$online?>>
						</div>
						
						<div class="form-group"><br>
							<label for="titre">Choisissez la photos </label>
							<input type="hidden" name="idImage" id="idImage" value="">
						</div>	
						
						<?
						for ( $i=1; $i<2; $i++ ) {
							?>
							<div class="col-md-4" style="margin-bottom:20px;">
								<input type="hidden" name="url<?=$i?>" id="url<?=$i?>" value="<?=$imgval[ $i ]?>"><br>
								<a href="javascript:openCustomRoxy('<?=$i?>')"><img src="<?=$img[ $i ]?>" id="customRoxyImage<?=$i?>" style="max-width:200px;"></a>
								<img src="img/del.png" width="20" alt="Supprimer" onclick="clearImage(<?=$i?>)"/>
							</div>	
							<?
						}
						?>
						
						<div id="roxyCustomPanel" style="display:none;">
							<iframe src="/admin/fileman2/index.html?integration=custom" style="width:100%;height:100%" frameborder="0"></iframe>
						</div>
						
						<div style="clear:both;"></div>
						<button class="btn btn-success col-sm-6 annuler" type="button"> Annuler </button>
						<button class="btn btn-success col-sm-6" type="submit"> Valider </button>
					
					</form>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			
			$( "#datepicker" ).datepicker({
				altField: 			"#datepicker",
				closeText: 			'Fermer',
				prevText: 			'Précédent',
				nextText: 			'Suivant',
				currentText: 		'Aujourd\'hui',
				monthNames: 		[ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
				monthNamesShort: 	[ 'Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.' ],
				dayNames: 			[ 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi' ],
				dayNamesShort: 		[ 'Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.' ],
				dayNamesMin: 		[ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
				weekHeader: 		'Sem.',
				dateFormat: 		'dd/mm/yy'
			});

			tinymce.init({
				selector: "textarea.editme",
				// ===========================================
				// INCLUDE THE PLUGIN
				// ===========================================
				plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen textcolor",
				"insertdatetime media table contextmenu paste jbimages"
				],
									
				// ===========================================
				// PUT PLUGIN'S BUTTON on the toolbar
				// ===========================================
				toolbar: "insertfile undo redo | styleselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
				// ===========================================
				// SET RELATIVE_URLS to FALSE (This is required for images to display properly)
				// ===========================================
				// AJOUTE LES URL EN ENTIER decommenter les 2 lignes suivantes
				//document_base_url: "http://dev.bsport.fr",
				//remove_script_host : false,
				relative_urls: false,
				file_browser_callback: RoxyFileBrowser
			});

			function RoxyFileBrowser(field_name, url, type, win) {
				var roxyFileman = '/admin/fileman/index.html';
				if (roxyFileman.indexOf("?") < 0) {   
					roxyFileman += "?type=" + type;  
				}
				else {
					roxyFileman += "&type=" + type;
				}
				roxyFileman += '&input=' + field_name + '&value=' + document.getElementById(field_name).value;
				if(tinyMCE.activeEditor.settings.language){
					roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
				}
				tinyMCE.activeEditor.windowManager.open({
					file: roxyFileman,
					title: 'Gestionnaire de fichiers',
					width: 850, 
					height: 650,
					resizable: "yes",
					plugins: "media",
					inline: "yes",
					close_previous: "no" 
				}, {   
					window: win,
					input: field_name
				});
				return false; 
			}
			
			function openCustomRoxy(idImage){
				$('#idImage').val(idImage);
			 	$('#roxyCustomPanel').dialog({modal:true, width:875,height:600});
			}
			function closeCustomRoxy(){
			 	$('#roxyCustomPanel').dialog('close');
			}
			
			function clearImage(idImage){
				$( '#customRoxyImage' + idImage ).attr( "src", "/img/favicon.png" );
				$( '#url' + idImage ).val( '' );
			}
			
			$( ".annuler" ).click(function() {
				window.location.href = "./liste.php";
			});
				
		</script>
		
	</body>
</html>


