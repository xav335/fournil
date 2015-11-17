<?php
require_once("StorageManager.php");
class Contact extends StorageManager {

	public function __construct(){

	}

	public function isContact( $email='', $debug=false ) {
		$this->dbConnect();
		try {
			$sql = "SELECT * FROM `contact` WHERE email = '". $email . "'";
			
			if ( $debug ) echo $sql . "<br>";
			$result = mysqli_query( $this->mysqli, $sql );
			
			$row = mysqli_fetch_assoc( $result );
			$retour = ( $row ) ? $row[ "id" ] : false;
			$this->dbDisConnect();
			return $retour;
		} 
		catch (Exception $e) {
			throw new Exception("Erreur Mysql contactGet ". $e->getMessage());
			return "errrrrrrooooOOor";
		}	
	}
	
	public function contactGet( $id, $offset, $count ) {
		$this->dbConnect();
		try {
			if (!isset($id)){
				if (isset($offset) && isset($count)) {
					$sql = "SELECT * FROM `contact` ORDER BY `name` ASC LIMIT ". $offset .",". $count .";" ;
				} else {
					$sql = "SELECT * FROM `contact` ORDER BY `name`;" ;
				}
			} else {
				$sql = "SELECT * FROM `contact` WHERE id=". $id;
			}
			//print_r($requete);
			$new_array = null;
			$result = mysqli_query($this->mysqli,$sql);
			while( $row = mysqli_fetch_assoc( $result)){
				$new_array[] = $row;
			}
			$this->dbDisConnect();
			return $new_array;
		} catch (Exception $e) {
			throw new Exception("Erreur Mysql contactGet ". $e->getMessage());
			return "errrrrrrooooOOor";
		}	
	}
	
	public function contactNumberGet(){
		 $this->dbConnect();
		try {
			$requete = "SELECT count(*) as nb FROM `contact`;" ;
			//print_r($requete);
			$new_array = null;
			$result = mysqli_query($this->mysqli,$requete);
			while( $row = mysqli_fetch_assoc( $result)){
				$new_array[] = $row;
			}
			$this->dbDisConnect();
			return $new_array[0]['nb'];
		} catch (Exception $e) {
			throw new Exception("Erreur Mysql contactGet ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
	}
	
	public function contactAdd( $value, $debug=false ){
		//print_r($value);
		//exit();
	    $fromcontact=1;
		$this->dbConnect();
		$this->begin();
		try {
			(!empty($value['newsletter']) && $value['newsletter']=='on') ? $newsletter = 1 : $newsletter = 0;
            (!empty($value['fromgoldbook']) && $value['fromgoldbook']=='on') ? $fromgoldbook = 1 : $fromgoldbook = 0;
            (!empty($value['fromcontact']) && $value['fromcontact']=='on') ? $fromcontact = 1 : $fromcontact = 0;

			$sql = "INSERT INTO  .`contact`
				(`firstname`, `name`, `adresse`, `cp`, `ville`, `email`, `tel`, `message`, `newsletter`, `fromgoldbook`, `fromcontact`)
				VALUES (
				'". addslashes($value['firstname']) ."',
				'". addslashes($value['name']) ."',
				'". addslashes($value['adresse']) ."',
				'". addslashes($value['cp']) ."',
				'". addslashes($value['ville']) ."',
				'". addslashes($value['email']) ."',
				'". addslashes($value['tel']) ."',
				'". addslashes($value['message']) ."',
				". $newsletter .",
				". $fromgoldbook .",
				". $fromcontact ."
			);";
			//error_log(date("Y-m-d H:i:s") ." : ".$sql."\n", 3, "../log/spy.log");
			
			if ( $debug ) echo $sql . "<br>";
			else {
				$result = mysqli_query($this->mysqli,$sql);
	
				if (!$result) {
					throw new Exception($sql);
				}
				$id_record = mysqli_insert_id($this->mysqli);
			}
			$this->commit();
	
		} catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql contactAdd ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
		$this->dbDisConnect();
		return $id_record;
	}
	
	public function contactModify( $value, $debug=false ){
		//print_r($value);
		//exit();
	
		$this->dbConnect();
		$this->begin();
		try {
			//(!empty($value['newsletter']) && $value['newsletter']=='on') ? $newsletter = 1 : $newsletter = 0;
            //(!empty($value['fromgoldbook']) && $value['fromgoldbook']=='on') ? $fromgoldbook = 1 : $fromgoldbook = 0;
            //(!empty($value['fromcontact']) && $value['fromcontact']=='on') ? $fromcontact = 1 : $fromcontact = 0;
	
			$sql = "UPDATE  .`contact` SET";
			$sql .= " `firstname`='" . addslashes($value['firstname']) . "',";
			$sql .= " `name`='" . addslashes($value['name']) . "',";
			$sql .= " `adresse`='" . addslashes($value['adresse']) . "',";
			$sql .= " `cp`='" . addslashes($value['cp']) . "',";
			$sql .= " `ville`='" . addslashes($value['ville']) . "',";
			$sql .= " `email`='" . addslashes($value['email']) . "',";
			$sql .= " `tel`='" . addslashes($value['tel']) . "'";
			
			if (!empty($value['newsletter']) && $value['newsletter']=='on') $sql .= ", `newsletter` = 1";
			if (!empty($value['fromgoldbook']) && $value['fromgoldbook']=='on') $sql .= ", `fromgoldbook` = 1";
			if (!empty($value['fromcontact']) && $value['fromcontact']=='on') $sql .= ", `fromcontact`= 1";
			$sql .= " WHERE `id`=" . $value['id'] . ";";
			
			if ( $debug ) echo $sql . "<br>";
			else {
				$result = mysqli_query($this->mysqli,$sql);
		
				if (!$result) {
					throw new Exception($sql);
				}
			}
	
			$this->commit();
	
		} catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
	
	
		$this->dbDisConnect();
	}	
	
	public function contactDelete($value){
		//print_r($value);exit();
	
		 $this->dbConnect();
		$this->begin();
		try {
			$sql = "DELETE FROM  .`contact` WHERE `id`=". $value .";";
			$result = mysqli_query($this->mysqli,$sql);
	
			if (!$result) {
				throw new Exception($sql);
			}
	
			$this->commit();
	
		} catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
	
	
		$this->dbDisConnect();
	}
	
	public function contactExportCSV(){
		//print_r($value);
		//exit();
		$date = date("Ymd-H:i:s");      
		$value = $_SERVER["DOCUMENT_ROOT"] ."/admin/FileUpload/server/php/files/export-". $date .".csv";
		 $this->dbConnect();
		$this->begin();
		try {
			// Ne pas oublier d'ajouter les prilèges FILE sur le users de la DB
			$sql = "SELECT firstname,name,email,newsletter INTO OUTFILE '". $value ."'
				FIELDS
					TERMINATED BY ';'
					ENCLOSED BY '\\\"'
					ESCAPED BY '\\\\'
				LINES
					STARTING BY ''
					TERMINATED BY '\\r'
				FROM contact;";
			//echo $sql;
				
			$result = mysqli_query($this->mysqli,$sql) or die(mysql_error());
			if (!$result) {
				throw new Exception("Erreur Mysql contactExportCSV". $sql);
			}
			$this->commit();
			return $result;
	
		} catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql contactExportCSV". $e->getMessage());
			return "errrrrrrooooOOor";
		}
	
		$this->dbDisConnect();
	}
	
	public function contactImportCSV($value){
		//print_r($value);
		//exit();
		 $this->dbConnect();
		$this->begin();
		try {
			$this->contactDeleteALL();
			// Ne pas oublier d'ajouter les prilèges FILE sur le users de la DB
			$sql = "LOAD DATA INFILE '". $value ."'
	          INTO TABLE contact
			FIELDS
				TERMINATED BY ';'
				ENCLOSED BY '\\\"'
				ESCAPED BY '\\\\'
			LINES
				STARTING BY ''
				TERMINATED BY '\\r'
				(`firstname`,`name`,`email`,`newsletter`) ;";
			//echo $sql;
			
			$result = mysqli_query($this->mysqli,$sql) or die(mysql_error());
			if (!$result) {
				throw new Exception($sql);
			}
			$this->commit();
			return $result;
		
		} catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql contactImportCSV". $e->getMessage());
			return "errrrrrrooooOOor";
		}
	
		$this->dbDisConnect();
	}
	
	protected function contactDeleteALL(){
		try {
			$sql = "DELETE FROM  .`contact` WHERE fromcontact=0 AND fromgoldbook=0 ;";
			$result = mysqli_query($this->mysqli,$sql);
	
			if (!$result) {
				throw new Exception($sql);
			}
	
		} catch (Exception $e) {
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
	}
	
	public function contactGetForNewsletter()
	{
	    $this->dbConnect();
	    try {
	        $sql = "SELECT DISTINCT email FROM contact WHERE newsletter=1;";
	        // print_r($sql);exit();
	        $new_array = null;
	        $result = mysqli_query($this->mysqli, $sql);
	        while (($row = mysqli_fetch_assoc($result)) != false) {
	            $new_array[] = $row;
	        }
	        $this->dbDisConnect();
	        return $new_array;
	    } catch (Exception $e) {
	        throw new Exception("Erreur Mysql contactGet " . $e->getMessage());
	        return "errrrrrrooooOOor";
	    }
	}
	
	public function contactUnsubscribeNewsletter($email, $message)
	{
	    // print_r($value);
	    // exit();
	    $this->dbConnect();
	    $this->begin();
	    try {
	        $sql = "UPDATE  contact SET
					`newsletter`= 0,
					`message`='" . addslashes($message) . "'
					WHERE `email`='" . $email . "';";
	        $result = mysqli_query($this->mysqli, $sql);
	
	        if (! $result) {
	            throw new Exception($sql);
	        }
	
	        $this->commit();
	    } catch (Exception $e) {
	        $this->rollback();
	        throw new Exception("Erreur Mysql " . $e->getMessage());
	        return "errrrrrrooooOOor";
	    }
	
	    $this->dbDisConnect();
	}
	
	
	
	
}