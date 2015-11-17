<?php
require_once("StorageManager.php");
class Categorie extends StorageManager {

	public function __construct( $id='', $debug=false ){
		if ( $id != '' ) return $this->load( $id, $debug );
	}
	
	public function load( $id, $debug=false ){
		$this->dbConnect();
		
		if ( intval( $id ) <= 0 ) return array();
		$new_array = null;
		
		$requete = "SELECT * FROM `catproduct` WHERE id = " . $id ;
		if ( $debug ) echo $requete . "<br>";
		$result = mysqli_query( $this->mysqli, $requete );
		
		while( $row = mysqli_fetch_assoc( $result ) ) {
			$new_array[] = $row;
		}
		$this->dbDisConnect();
		return $new_array;
	}
	
	public function gererDonnees( $post, $debug=false ) {
		$datas = $this->load( $post[ "id" ], $debug );
		$modification = ( !empty( $datas ) ) ? true : false;
		
		$val[ "id" ] = intval( $post[ "id" ] );
		$val[ "id_parent" ] = intval( $post[ "id_parent" ] );
		$val[ "nom" ] = addslashes( $post[ "nom" ] );
		$val[ "image" ] = addslashes( $post[ "image" ] );
		
		// ---- Modification -------- //
		if ( $modification ) {
			$id = $this->modifier( $val, $debug );
		}
		
		// ---- Ajout --------------- //
		else {
			$val[ "ordre_affichage" ] = $this->getOrdreMaxi( $post[ "id_parent" ], $debug ) + 1;
			$id = $this->ajouter( $val, $debug );
		}
		
		return $id;
	}
	
	private function getOrdreMaxi( $id_parent=0, $debug=false ) {
		$this->dbConnect();
		
		if ( intval( $id_parent ) <= 0 ) return 0;
		
		$requete = "SELECT * FROM `catproduct` WHERE id_parent = " . $id_parent ;
		$requete .= " ORDER BY ordre_affichage DESC";
		if ( $debug ) echo $requete . "<br>";
		
		$result = mysqli_query( $this->mysqli, $requete );
		$data = mysqli_fetch_assoc( $result );
		$this->dbDisConnect();
		
		return $data[ "ordre_affichage" ];
	}
	
	public function ajouter( $value, $debug=false ) {
		$this->dbConnect();
		$this->begin();
		
		try {
			$sql = "INSERT INTO  `catproduct`
				( `id_parent`, `nom`, `image`, `ordre_affichage` )
				VALUES (
				'" . $value[ "id_parent" ] . "',
				'" . $value[ "nom" ] ."',
				'" . $value[ "image" ] ."',
				'" . $value[ "ordre_affichage" ] . "'
			);";
			
			if ( $debug ) echo $sql . "<br>";
			else {
				$result = mysqli_query( $this->mysqli, $sql );
				
				if ( !$result ) {
					throw new Exception( $sql );
				}
				
				$id_record = mysqli_insert_id( $this->mysqli );
				$this->commit();
			}
		
		} 
		catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
		$this->dbDisConnect();
		return $id_record;
	}
	
	public function modifier( $value, $debug=false ) {
		$this->dbConnect();
		$this->begin();
		
		try {
			$sql = "UPDATE  .`catproduct` SET";
			$sql .= " `id_parent` = '" . $value[ "id_parent" ] ."',";
			$sql .= " `nom` = '" . $value[ "nom" ] . "'";
			if ( $value[ "image" ] != '' ) $sql .= ", `image` = '" . $value[ "image" ] . "'";
			$sql .= " WHERE `id` = " . $value[ "id" ] . ";";
			
			if ( $debug ) echo $sql . "<br>";
			else {
				$result = mysqli_query( $this->mysqli, $sql );
				
				if ( !$result ) {
					throw new Exception( $sql );
				}
			
				$this->commit();
			}
		
		} catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
		
		$this->dbDisConnect();
		return $value[ "id" ];
	}
	
	public function supprimer( $id, $debug=false ) {
		$this->dbConnect();
		$this->begin();
	
		try {
			
			// ---- Chargement de la catégorie ----- //
			$data = $this->load( $id, $debug );
			//print_pre( $data );
			
			// ---- Diminution automatique de l'ordre d'affichage des catégories suivantes
			$this->dbConnect();
			$sql = "UPDATE `catproduct` SET";
			$sql .= " ordre_affichage = ordre_affichage - 1";
			$sql .= " WHERE id_parent = " . $data[ 0 ][ "id_parent" ];
			$sql .= " AND ordre_affichage > " . $data[ 0 ][ "ordre_affichage" ];
			if ( $debug ) echo $sql . "<br>";
			else $result = mysqli_query( $this->mysqli, $sql );
			
			// ---- Suppression de la catégorie ---- //
			$sql = "DELETE FROM `catproduct`";
			$sql .= " WHERE `id`=" . $id . ";";
			
			if ( $debug ) echo $sql . "<br>";
			else {
				$result = mysqli_query( $this->mysqli, $sql );
				if (!$result) {
					throw new Exception($sql);
				}
				
				$this->commit();
			}
	
		} catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
	
	
		$this->dbDisConnect();
	}
	
	public function getListe( $tab=array(), $debug=false ) {
		$this->dbConnect();
		
		$champ_souhaite = ( $tab[ "champ" ] != '' ) ? $tab[ "champ" ] : "*";
		$requete = "SELECT " . $champ_souhaite . " FROM `catproduct`";
		
		if ( $tab[ "where" ] == '' ) {
			$requete .= " WHERE id > 0";
			
			if ( !empty( $tab ) ) {
				foreach( $tab as $champ => $val ) {
					if ( $champ != "champ" && $champ != "order_by" && $champ != "sens" )
						$requete .= " AND " . $champ . " = '" . addslashes( $val ) . "'";
				}
			}
			
			$order_by = ( $tab[ "order_by" ] != "" ) ? $tab[ "order_by" ] : "ordre_affichage";
			$sens = ( $tab[ "sens" ] != "" ) ? $tab[ "sens" ] : "ASC";
			$requete .= " ORDER BY " . $order_by . " " . $sens;
		}
		else $requete .= $tab[ "where" ];
		
		if ( $debug ) echo $requete . "<br>";
		$result = mysqli_query( $this->mysqli, $requete );
		
		while( $row = mysqli_fetch_assoc( $result ) ) {
			$new_array[] = $row;
		}
		$this->dbDisConnect();
		return $new_array;
	}
	
}