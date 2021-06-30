<?php 
$dadosbd = new Usuario();
$bd = new BD();
$conn = $bd->getConnection();
try{
	$sql = "SELECT * from usuario";
	$query = $conn->prepare($sql);
	$query->execute();
	echo"<table>
	<tr>
	<th>cd_usuario:</th>
	<th>cd_funcionario:</th> 
	<th>login:</th>
	<th>tipo_usuario:</th>
	</tr>";
	while($dados= $query->fetch(PDO::FETCH_ASSOC)){
		$cd_usuario = $dados["cd_usuario"];
		$cd_funcionario = $dados["cd_funcionario"];
		$login = $dados["login"];
		$tipo_usuario = $dados["tipo_usuario"];
		echo "<tr><td>$cd_usuario</td><td>$cd_funcionario</td><td>$login</td><td>$tipo_usuario</td></tr>";
	}
	echo"</table>";
	}catch(PDOException $ex){
		echo 'Erro: ' .$ex->getMessage();
	}
?>