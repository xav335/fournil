		<!-- Footer -->
		<div class="row fullwidth footer">
			<div class="row">
				<form id="form_news" method="post" action="#" class="newsletter">
					<input type="hidden" name="as" value="" />
					<div class="large-12 columns">Abonnez-vous à notre newsletter <input type="email" name="email_news" id="email_news" placeholder="saisissez votre e-mail" required /><input type="submit" value="OK" /></div>
				</form>
			</div>
			
			<div class="row fullwidth">
				<div id="map-canvas"></div>
				<div class="row infos-footer">
					<div class="large-4 medium-6 small-12 columns">
						<a href="http://facebook.com/lesfournilsdejeanphilippe?fref=ts" target="_blank"><img src="img/facebook.png" alt="" /></a>
					</div>
					<div class="large-8 medium-6 small-12 columns">
						<p>
							<a href="/">Accueil</a>, 
							<a href="qui-sommes-nous.php">Qui sommes-nous</a>,
							<a href="nos-produits.php">Nos produits</a>,
							<a href="traiteur.php">Traiteur</a>,
							<a href="actualites.php">Actu</a>,
							<a href="livre-dor.php">Livre d’or</a>,
							<a href="contact.php">Contact</a>
						</p>
						<p>
							Les Fournils de Jean-Philippe<br/>
							5 Bis Avenue Virecourt Artigues, Aquitaine, France<br/>
							© 2015 - <a href="http://www.iconeo.fr" target="_blank">Création iconeo</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer -->
		
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
		<script src="js/vendor/jquery.js"></script>
		<script src="js/foundation.min.js"></script>
	    <script src="js/vendor/swiper/swiper.min.js"></script>
	    <script src="js/vendor/scripts.js"></script>
	    
		<script>
			
			// ---- Validation du formulaire de newsletter -------------- //
			if ( 1 == 1 ) {
				
				$( "#form_news" ).submit(function() {
					//alert( "validation..." );
					var erreur = 0;
					
					$.ajax({
						type: "POST",
						cache: false,
						url: '/ajax/ajax_newsletter.php?task=inscrire',
						data: $( "#form_news" ).serialize(),
						error: function() { alert( "Une erreur s'est produite..." ); },
						success: function( data ){
							var obj = $.parseJSON( data );
							
							// Tout s'est bien passé!
							if ( !obj.error ) {
								$( "#form_news #email_news" ).val( '' );
								alert( "Votre e-mail a été correctement ajouté à notre base de données." );
							}
							else {
								
							}
							
						}
					});
					
					return false;
				});
			}
			// ---------------------------------------------------------- //
			
		</script>