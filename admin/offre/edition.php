<? include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/inc-auth-granted.php" );?>
<? include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/classes/utils.php" );?>
<? 
	require $_SERVER['DOCUMENT_ROOT'] . "/admin/classes/Type_bien.php";
	require $_SERVER['DOCUMENT_ROOT'] . "/admin/classes/Offre.php";
	require $_SERVER['DOCUMENT_ROOT'] . "/admin/classes/Offre_type_bien.php";
	require $_SERVER['DOCUMENT_ROOT'] . "/admin/classes/Offre_image.php";
	
	$debug = false;
	
	$type_bien = new Type_bien();
	$offre_type_bien = new Offre_type_bien();
	$offre_image = new Offre_image();
	
	// ---- Liste des types de bien ----------------- //
	if ( 1 == 1 ) {
		$liste_type_bien = $type_bien->getListe();
		//print_pre( $liste_type_bien );
	}
	// ---------------------------------------------- //
	
	
	// ---- Modification ---------------------------- //
	if ( !empty( $_GET ) ) {
		$action = 'modif';
		$news = new Offre();
		$result = $news->load( $_GET[ "id" ], false );
		//print_r($result);
		
		if ( empty( $result ) ) $message = 'Aucun enregistrement';
		else {
			$labelTitle = 	'Offre N°: '. $_GET[ "id" ];
			$num_offre =	$_GET[ "id" ];
			$type_bien =	$result[0][ "type_bien" ];
			$titre =		$result[0][ "titre" ];
			$surface =		$result[0][ "surface" ];
			$description =	$result[0][ "description" ];
			$fichier_pdf = 	$result[0][ "fichier_pdf" ];
			$prix =			$result[0][ "prix" ];
			$online = 		( $result[0][ "online" ] == 'oui' ) ? "checked" : '';
			$a_la_une = 	( $result[0][ "a_la_une" ] == 'oui' ) ? "checked" : '';
			
			$checked_location = ( $offre_type_bien->load( $_GET[ "id" ], 1, $debug ) ) ? "checked" : '';
			$checked_vente = ( $offre_type_bien->load( $_GET[ "id" ], 2, $debug ) ) ? "checked" : '';
			$checked_investisseur = ( $offre_type_bien->load( $_GET[ "id" ], 3, $debug ) ) ? "checked" : '';
			
			$display_pdf = ( $fichier_pdf != '' ) ? "block" : "none";
			$display_pdf_img = ( $fichier_pdf != '' ) ? "none" : "block";
			
			// ---- Liste des photos associées à cette offre ---- //
			if ( 1 == 1 ) {
				unset( $recherche );
				$recherche[ "num_offre" ] = $_GET[ "id" ];
				$liste_image = $offre_image->getListe( $recherche, $debug );
			}
			// -------------------------------------------------- //
		}
	} 
	// ---------------------------------------------- //
	
	// ---- Ajout ----------------------------------- //
	else {
		$action = 'add';
		$labelTitle = 	"Edition Nouvelle offre";
		$num_offre =	null;
		$type_bien =	"vente";
		$titre =  		null;
		$surface = 		null;
		$description =	null;
		$fichier_pdf = 	'';
		$prix =			null;
		$a_la_une = 	null;
		$online = 		null;
		
		$display_pdf = "none";
		$display_pdf_img = "block";
			
	}
	// ---------------------------------------------- //
	
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<? include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc-meta.php";?>
	</head>
	
	<body>	
		<? require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc-menu.php";?>
	
		<div class="container">
	
			<div class="row">
				<h3><?php echo $labelTitle ?></h3>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<form name="formulaire" id="formulaire" class="form-horizontal" method="POST"  action="../formprocess.php">
						<input type="hidden" name="reference" id="reference" value="offres">
						<input type="hidden" name="action" value="<?=$action?>">
						<input type="hidden" name="num_offre" id="num_offre" value="<?=$num_offre ?>">
						<input type="hidden" name="num_image" id="num_image" value="">
						
						<div class="form-group" >
							<label class="col-sm-2">Type de bien :</label>
						    <input type="checkbox" name="type_bien[]" value="1" <?=$checked_location?> />&nbsp;Location&nbsp;&nbsp;
						    <input type="checkbox" name="type_bien[]" value="2" <?=$checked_vente?> />&nbsp;Vente&nbsp;&nbsp;
						    <input type="checkbox" name="type_bien[]" value="3" <?=$checked_investisseur?> />&nbsp;Investisseur
						</div>
						
						<div class="form-group" >
							<label class="col-sm-2" for="titre">Titre :</label>
						    <input type="text" class="col-sm-10" name="titre" required  value="<?=$titre?>">
						</div>
						
						<div class="form-group" >
							<label class="col-sm-2" for="surface">Surface (en chiffres) :</label>
						    <input type="text" class="col-sm-1" name="surface" required  value="<?=$surface?>">&nbsp;m2
						</div>
						
						<div class="form-group" >
							<label class="col-sm-2" for="prix">Prix :</label>
						    <input type="text" class="col-sm-1" name="prix" required  value="<?=$prix?>">
						</div>
						
						<div class="form-group">
							<label class="col-sm-2" for="description">Description :</label>
			           		<textarea class="col-sm-10" name="description" id="description" rows="5" required ><?=$description?></textarea>
			            </div>
			            
						<div class="form-group" >
							<label class="col-sm-2" for="online">Offre en 1iere page :</label>
						    <input type="checkbox" name="a_la_une" value="oui" <?=$a_la_une?>>
						</div>
						 
						<div class="form-group" >
							<label class="col-sm-2" for="online">Offre en ligne :</label>
						    <input type="checkbox" name="online" value="oui" <?=$online?>>
						</div>
						
						<div class="col-md-6" style="margin-bottom:20px;">
							<label for="titre">Choix des photos </label><br>
							<input type="hidden" name="url0" id="url0" value=""><br>
							<input type="hidden"  name="idImage"  id="idImage" value="">
	            			<a href="javascript:openCustomRoxy('0')"><img id="" src="http://www.placehold.it/400x150/EFEFEF/171717&text=Choisir les images ici" id="customRoxyImage0" style="max-width:400px;"></a>
						</div>
						
						<div class="col-md-6" style="margin-bottom:20px;">
							<label for="titre">Choix du PDF</label><br>
							<input type="hidden" name="url1_changement" id="url1_changement" value="">
							<input type="hidden" name="url1" id="url1" value="<?=$fichier_pdf?>">
							
							<div id="div_pdf" style="display:<?=$display_pdf?>;">
								<img src="/admin/img/pdf.png" />&nbsp;
								<span id="span_pdf"><?=$fichier_pdf?></span>&nbsp;&nbsp;
						  		<input type="button" value="Changer" onclick="javascript:openCustomRoxy('1');" />&nbsp;
						  		<input type="button" value="Annuler" onclick="javascript:annuler_pdf();" />
							</div>
							<div id="div_pdf_img" style="display:<?=$display_pdf_img?>;">
	            				<a href="javascript:openCustomRoxy('1')"><img id="img_pdf" src="http://www.placehold.it/400x150/EFEFEF/171717&text=Choisir le PDF ici" id="customRoxyImage1" style="max-width:400px;"></a>
	            			</div>
						</div>
						<div style="clear:both;"></div>
						
						<div id="div_liste_image">
							<?
							// ---- Affichage de la liste des images déjà associées à cette offre ---- //
							if ( !empty( $liste_image ) ) {
								$cpt = 0;
								foreach( $liste_image as $_image ) {
									
									echo "<div class='col-md-3' style='text-align:center; margin-bottom:20px; border:0px solid red;'>\n";
				            		echo "	<img src='/photos/offre/vignette/" . $_image[ "fichier" ] . "' width='230' style='max-width:230px;'></a><br>\n";
				            		if ( $_image[ "defaut" ] == 'non' ) echo "	<input type='button' id='" . $_image[ "num_image" ] . "' value='Par défaut' class='par_defaut' />\n";
				            		echo "	<input type='button' id='" . $_image[ "num_image" ] . "' value='Supprimer' class='supprimer_image_precise' />\n";
									echo "</div>\n";
									
									if ( $cpt % 4 == 4 )echo "<div style='clear:both;'></div>\n";
									$cpt++;
								}
							}
							// ----------------------------------------------------------------------- //
							?>
						</div>
						
			            <div id="roxyCustomPanel" style="display:none;">
							<iframe src="/admin/fileman2/index.php?integration=custom" style="width:100%;height:100%" frameborder="0"></iframe>
						</div>
						
						<div style="clear:both;"></div>
			            <button class="btn btn-success col-sm-6 annuler" type="button"> Annuler </button>
			            <button class="btn btn-success col-sm-6" type="submit"> Valider </button>
			            
			        </form>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			
			var cpt = 0;
			
			$( "#datepicker" ).datepicker({
				altField: "#datepicker",
				closeText: 'Fermer',
				prevText: 'Précédent',
				nextText: 'Suivant',
				currentText: 'Aujourd\'hui',
				monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
				monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
				dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
				dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
				dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
				weekHeader: 'Sem.',
				dateFormat: 'dd/mm/yy'
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
				var roxyFileman = '/admin/fileman/index.php';
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
					//input: field_name
				});
				return false; 
			}
			
			function openCustomRoxy(idImage){
				$('#idImage').val(idImage);
			 	$('#roxyCustomPanel').dialog({modal:true, width:875,height:600});
			}
			function closeCustomRoxy(){
			  	$('#roxyCustomPanel').dialog('close');
			  	
			  	// ---- Contenu photo --------------------- //
			  	if ( $( "#url0" ).val() != '' ) {
			  		//alert( "Photos..." );
			  		
			  		var fichier_image = $( "#url0" ).val();
			  		var contenu = "<div id='div_image_" + cpt + "' class='col-md-3' style='text-align:center; margin-bottom:20px; border:0px solid red;'>\n";
					contenu += "	<input type='hidden' name='mes_images[]' value='" + fichier_image + "' />\n";
            		contenu += "	<img src='" + fichier_image + "' width='230' style='max-width:230px;'></a><br>\n";
            		//contenu += "	<input type='button' value='Par défaut' />\n";
            		contenu += "	<input type='button' id='" + cpt + "' value='Supprimer' class='supprimer_image' />\n";
					contenu += "</div>";
					
					if ( ( cpt % 4 ) == 4 ) contenu += "<div style='clear:both;'></div>\n";
					
					$( "#div_liste_image" ).append( contenu );
					cpt++;
			  	}
			  	// ---------------------------------------- //
			  	
			  	
			  	// ---- Contenu du PDF -------------------- //
			  	else if ( $( "#url1" ).val() != '' ) {
			  		$( "#div_pdf_img" ).hide();
			  		
			  		$( "#url1_changement" ).val( "changer pdf" );
			  		$( "#span_pdf" ).html( $( "#url1" ).val() );
			  		$( "#div_pdf" ).show();
			  	}
			  	// ---------------------------------------- //
			  	
			}
			
			function clearImage(idImage){
				$( '#customRoxyImage' + idImage ).attr( "src", "http://www.placehold.it/200x150/EFEFEF/171717&text=Pas d'image" );
				$( '#url' + idImage ).val( '' );
			}
			
			function annuler_pdf() {
				$( "#url1_changement" ).val( "changer pdf" );
				$( "#url1" ).val( '' );
				
				$( "#div_pdf" ).hide();
				$( "#div_pdf_img" ).show();
			}
			
			$( document ).on( "click", ".supprimer_image", function() {
				var val = $(this).attr( "id" );
				//alert( "Suppression de l'image " + val );
				$( "#div_image_" + val ).remove();
			});
			
			$( ".par_defaut" ).click(function() {
				var val = $(this).attr( "id" );
				//alert( "Image #" + val + " par defaut" );
				
				$( "#num_image" ).val( val );
				$( "#reference" ).val( "par defaut" );
				$( "#formulaire" ).submit();
			});
			
			$( ".supprimer_image_precise" ).click(function() {
				var val = $(this).attr( "id" );
				//alert( "Suppression de l'image #" + val );
				
				$( "#num_image" ).val( val );
				$( "#reference" ).val( "supprimer image" );
				$( "#formulaire" ).submit();
			});
			
			$( ".annuler" ).click(function() {
				window.location.href = "./liste.php";
			});
				
		</script>
		
	</body>
</html>


