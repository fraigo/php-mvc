<?php
namespace lib;

class Database {

  private $connection;

	static function connect($config,$error=true){
    $db=new Database();
		$conn=0;
		try{
			$conn = new \PDO("mysql:host={$config["host"]};dbname={$config["database"]};charset={$config["charset"]}", "{$config["user"]}","{$config["password"]}",$config["commands"]);
		}catch(Exception $e){
			if ($error){
				header("HTTP/1.0 500 Server Error");
				die();
			}
    }
    $db->connection=$conn;
		return $db;
	}


	function query($sql,$params=[]){

		$prep=$this->connection->prepare($sql);
		$prep->execute($params);

		return $prep;

	}



	function rows($sql,$params=[],$limit=-1){

		$cmd=DB::query($conn,$sql,$params);

		$cmd->setFetchMode(PDO::FETCH_ASSOC);

		$rows=[];

		$pos=0;

		if ($cmd)

		foreach ($cmd as $row) {

			$pos++;

			if ($limit>0 && $limit<$pos){

				break;

			}

			$rows[]=$row;

		}

		return $rows;

	}

	function row($sql,$params=[]){
		$rows=DB::rows($conn,$sql,$params);
		return $rows[0];
	}


	function col($sql,$params=[],$col=0){

		$cmd=DB::query($conn,$sql,$params);
		$cmd->setFetchMode(PDO::FETCH_NUM);
		$rows=[];

		if ($cmd){
			foreach ($cmd as $row) {
				$rows[]=$row[$col];
			}
		}
		return $rows;
	}

	function escape($value,$type=PDO::PARAM_STR){
		return $this->connection->quote($value,$type);
	}


	function tables($database=null){
		if (is_null($database)){
			$database="database()";
		}
		$rows=DB::col($conn,"SELECT TABLE_NAME as tables from INFORMATION_SCHEMA.TABLES WHERE table_schema=$database");
		return $rows;
	}

	function primaryKey($table){

		$pkeys=array();
		$sql="SHOW INDEXES FROM $table";
		$indexes=DB::rows($conn,$sql);

		foreach($indexes as $index){
			if ($index["Key_name"]=="PRIMARY"){
				$pkeys[]=$index["Column_name"];
			}
		}

		return $pkeys;
	}
}



