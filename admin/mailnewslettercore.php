<?php include_once 'inc-auth-granted.php';?>
<?php include_once 'classes/utils.php';?>
<?php 
require 'classes/Newsletter.php';

if (!empty($_GET)){ //Modif 
	$newsletter = new Newsletter();
	$result = $newsletter->newsletterAllGet($_GET['id']);
	//print_r($result);
	if (empty($result)) {
		$message = 'Aucun enregistrements';
	} else {
		$id= 			$_GET['id'];
		$titre=  		$result[0]['titre'];
		$date= 			traitement_datetime_affiche($result[0]['date']);
		$bas_page= 		$result[0]['bas_page'];
		$detail=		$result[0]['newsletter_detail'];
	}
} else { 
	echo 'Erreur contactez votre administrateur <br> :\n';
	exit();
}
?>

<?php
$urlSite = $_SERVER['HTTP_HOST'];

//$_to = "contact@bsport.fr";
$_to = "fjavi.gonzalez@gmail.com";
$sujet = "Bsport - Newsletter ";
//echo "Envoi du message à " . $_to . "<br>";

$entete = "From:Bsport <contact@bsport.fr>\n";
$entete .= "MIME-version: 1.0\n";
$entete .= "Content-type: text/html; charset= iso-8859-1\n";
$entete .= "Bcc: fjavi.gonzalez@gmail.com,xav335@hotmail.com,xavier.gonzalez@laposte.net,jav_gonz@yahoo.com\n";

$corps = <<<EOD

<html>
<head>
<meta charset="utf-8" />
<title>Newsletter Bsport</title>
<style type="text/css">
	@import url('http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700');
	
	body {background: #fff;font-family:'PT Sans Narrow', sans-serif;}
	p {font-size:18px; text-align: justify;}
	p.bas {font-size:11px;}
	h1 {font-family:inherit;font-weight:bold;font-style:italic;font-size:36px;line-height:36px;color:#18293c;text-transform:uppercase;margin-bottom:0;}
	h2 {font-family:inherit;font-style:italic;font-size:20px;line-height:18px;color:#d75b00;text-transform:uppercase;margin-top:0;margin-bottom:30px;}
	h3 {font-family:inherit;font-weight:bold;font-size:20px;line-height:18px;color:#d75b00;text-transform:uppercase;margin-top:0;margin-bottom:0px;}
	h4 {font-family:inherit;font-style:normal;font-size:18px;line-height:18px;color:#18293c;text-transform:none;margin-top:0;margin-bottom:0px;}

</style>
</head>
<body>
	<table width="640" border="0"  cellpadding="0" cellspacing="0" >
		<tr>
		    <td align="center">
				<div style="text-align:center;  margin-left:auto;margin-right:auto; width: 640px; border: 4px ridge white; padding:20px 20px 20px 20px; ">
					
					<a href="http://$urlSite"><img  src="http://$urlSite/newsletter/logo.png"></a>
				
					<h1>$titre</h1>
					<br><br>
EOD;
if(isset($detail)) {
	
	foreach ($detail as $value) {
		$titre = $value['titre'];
		if ($titre !='') {
			$titre = "<h2>$titre</h2>";
		} else {
			$titre= '';
		}
		$link = $value['link'];
		$url = $value['url'];
		if ($url!='' & $url != '/img/ajoutImage.jpg') {
			$url = "<a href=\"". $link ."\"><img width=\"640\" src=\"http://$urlSite". $url ."\"></a><br>";
		} else {
			$url= '';
		}
		$texte = $value['texte'];
		if ($titre != '' || $url != '' || $texte != '') {
			$corps .= <<<EOD
					$titre
					$url
					<p >$texte</p>
					<img  src="http://$urlSite/newsletter/sep.png">
					<br><br><br>
EOD;
		}
	}
}
$corps .= <<<EOD

					<a href="http://$urlSite"><img  src="http://$urlSite/newsletter/pano.png"></a><br>
					<p>$bas_page</p>
					<a><img src="http://$urlSite/newsletter/log2.png"></a><br>
					<p class="bas">Si vous souhaitez vous désinscrire de cette newslettrer suivez le lien suivant : <a href="http://$urlSite/newsletter/desinscription.php?id=" >désinscription</a></p>
					
				</div>
			</td>
		</tr>	
	</table>	
</body>
</html>

EOD;

if (empty($_GET['action']) && empty($_GET['postaction']) ) {
	echo $corps;
}	

$corps = utf8_decode( $corps );


// Envoi des identifiants par mail
if (!empty($_GET['postaction']) && $_GET['postaction']=='preview') {
	echo "<br><br><h3>Newsletter de Test envoyee a contact@bsport.fr !!!! </h3><br><br>
		<a href='javascript:history.back()'>retour</a>";
	mail($_to, $sujet, stripslashes($corps), $entete);
} 
