<?php
class MyPDO extends PDO{
		private $user;
		private $pword;
		private $dbase;
		private $host;

		public function __construct($dbase,$user="root",$pword="password",$host="127.0.0.1")
		{
			if(empty(trim($dbase)))
			{
				die("INVALID Database Name: ");
			}
			try {
				parent::__construct("mysql:host={$host};dbname={$dbase}",$user,$pword);
			} catch (PDOException $e) {
				die("CONNECTION ERROR:".$e->getMessage());
			}
			$this->user=$user;
			$this->pword=$pword;
			$this->dbase=$dbase;
			$this->host=$host;
		}
		public function getUser(){
			return $this->user;
		}
		public function getPword(){
			return $this->pword;
		}
		public function getDbase(){
			return $this->dbase;
		}
		public function getHost(){
			return $this->host;
		}
		public function myQuery($sqlStmt,$value=NULL)
		{
			try {
				$stmt=$this->prepare($sqlStmt);

				if($value==NULL)
				{
					if(!$stmt->execute($value)){

						throw new PDOException($stmt->errorInfo()[2], 1);
						//die("<hr/><b>There was an Error</b>");
					}
				}
				else
				{
					// var_dump($value);
					$value=array_map('trim',$value);
					if(!$stmt->execute($value)){

						throw new PDOException($stmt->errorInfo()[2], 1);
						//die("<hr/><b>There was an Error</b>");
					}
				}
				return $stmt;
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			
		}
	}

	
?>