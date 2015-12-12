<?

	// ---- D�finition des constantes du site ------------------------ //
	//echo $_SERVER[ "DOCUMENT_ROOT" ] . "<br>";
	switch( $_SERVER[ "DOCUMENT_ROOT" ] ) {
		
		// ---- Serveur local Franck -------- //
		case "/var/www/fournil" :
			$localhost = "localhost";
			$dbname = "fournil";
			$user = "fournil";
			$mdp = "fournil";
			break;
		
		// ---- Serveur PRE-PROD ------------ //
		case "/home/web/fournil" :
			$localhost = "localhost";
			$dbname = "fournil";
			$user = "fournil";
			$mdp = "fournil33";
			break;
		
		// ---- Serveur PROD ---------------- //
		case "/var/www/fournildartigues.com" :
			$localhost = "localhost";
			$dbname = "fournil";
			$user = "fournil";
			$mdp = "fournil33";
			break;
		default:
		    $localhost = "localhost";
		    $dbname = "fournil";
		    $user = "fournil";
		    $mdp = "fournil33";
		    break;
	}
		
	define( "DBHOST",	$localhost );
	define( "DBNAME",	$dbname );
	define( "DBUSER",	$user );
	define( "DBPASSWD", $mdp );
	
	define( "MAILCUSTOMER", 	"contact@fournildartigues.com" );
	define( "MAILNAMECUSTOMER", "Le fournil d'Artigues" );
	define( "URLSITEDEFAULT", 	"http://www.fournildartigues.com/" );
	define( "FACEBOOK_LINK", 	"https://www.facebook.com/lesfournilsdejeanphilippe" );
	
	// ---- Mail d'envoi
	define( "MAIL_TEST", 	"" ); // Si rempli alors cette valeur ser utilis�e pour les diff�rents envois de mails
	define( "MAIL_CONTACT", "contact@fournildartigues.com" );
	define( "MAIL_BCC", 	"xav335@hotmail.com,fjavi.gonzalez@gmail.com,jav_gonz@yahoo.com" );
?>