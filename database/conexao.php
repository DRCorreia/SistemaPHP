<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
/* 
@return \PDO
*/
class BD{
	public function getConnection(){
		$dsn = 'mysql:host=localhost;dbname=tcc';
		$user = 'root';
		$pass = '';

		try{
			$pdo = new PDO($dsn, $user, $pass);
			return $pdo;
		} catch (PDOException $ex){
			echo 'Erro: ' .$ex->getMessage();
		}
}
}
