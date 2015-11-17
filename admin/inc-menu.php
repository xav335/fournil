	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                	<div class="navbar-header">
	                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	                        <span class="icon-bar"></span>
	                        <span class="icon-bar"></span>
	                        <span class="icon-bar"></span>
	                    </button>
                    <a class="navbar-brand" href="/admin/"><img src="/admin/img/xlogo.png" width="150" alt="Back-Office"/></a>
                	</div>
                	<div class="col-md-6 collapse navbar-collapse">
	           			<ul class="nav navbar-nav">
	           				<li class="dropdown">
					          	<a href="/admin/categorie/liste.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Catégories<span class="caret"></span></a>
					          	<ul class="dropdown-menu" role="menu">
					            	<li><a href="/admin/categorie/edition.php">Ajout</a></li>
					            	<li><a href="/admin/categorie/liste.php">Modif / Suppr</a></li>
					          	</ul>
					        </li>
	           				<li class="dropdown">
					          	<a href="/admin/produit/liste.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Produits<span class="caret"></span></a>
					          	<ul class="dropdown-menu" role="menu">
					            	<li><a href="/admin/produit/edition.php">Ajout</a></li>
					            	<li><a href="/admin/produit/liste.php">Modif / Suppr</a></li>
					          	</ul>
					        </li>
	           				<li class="dropdown">
					          	<a href="/admin/actualite/liste.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Actualités <span class="caret"></span></a>
					          	<ul class="dropdown-menu" role="menu">
					            	<li><a href="/admin/actualite/edition.php">Ajout</a></li>
					            	<li><a href="/admin/actualite/liste.php">Modif / Suppr</a></li>
					          	</ul>
					        </li>
	                        <li class="dropdown">
					          	<a href="/admin/livre_dor/liste.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Livre d'or <span class="caret"></span></a>
					          	<ul class="dropdown-menu" role="menu">
					            	<li><a href="/admin/livre_dor/edition.php">Ajout</a></li>
					            	<li><a href="/admin/livre_dor/liste.php">Modif / Suppr</a></li>
					          	</ul>
					        </li>
					         <li class="dropdown">
					          	<a href="contact-list.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Contacts <span class="caret"></span></a>
					          	<ul class="dropdown-menu" role="menu">
					            	<li><a href="/admin/contact-edit.php">Ajout</a></li>
					            	<li><a href="/admin/contact-list.php">Modif / Suppr</a></li>
					            	<li class="divider"></li>
					            	<li><a href="/admin/contact-import.php">Import / Export</a></li>
					          	</ul>
					        </li>
					         <li class="dropdown">
					          	<a href="newsletter-list.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Newsletter<span class="caret"></span></a>
					          	<ul class="dropdown-menu" role="menu">
					            	<li><a href="/admin/newsletter-edit.php">Ajout Newsletter</a></li>
					            	<li><a href="/admin/newsletter-list.php">Modif / Suppr / Envoi</a></li>
					            	<li class="divider"></li>
					            	<li><a href="/admin/newsletterjournal-list.php">Journal des envoi</a></li>
					          	</ul>
					        </li>
							<!--<li class="dropdown">
					          	<a href="bdc.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Bon de commande <span class="caret"></span></a>
					          	<ul class="dropdown-menu" role="menu">
					            	<li><a href="planning.php">Modification</a></li>
					          	</ul>
					        </li>-->
	                    </ul>
	                    
                    </div> 
                    <div class="col-md-2 collapse navbar-collapse">
                      	<a class="btn btn-success pull-right" href="/admin/?action=getout">Déconnexion</a>
                     </div> 
                </div><!--/.nav-collapse -->
               
            </div>
        </nav>
<script type="text/javascript">
$(document).ready(function () {
	var url = window.location;
	// Will only work if string in href matches with location
	$('ul.nav a[href="'+ url +'"]').parent().addClass('active');

	// Will also work for relative and absolute hrefs
	$('ul.nav a').filter(function() {
	    return this.href == url;
	}).parent().addClass('active');
	});
</script>
