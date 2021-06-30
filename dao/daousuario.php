<?php
include_once 'C:\xampp\htdocs\tcc\database\conexao.php';
include_once 'C:\xampp\htdocs\tcc\model\usuario.php';
include_once 'C:\xampp\htdocs\tcc\controller\usuariocontroller.php';

class DaoUsuario{
    public function inserirUsuario(Usuario $usuario){
        $bd= new BD();
        $conn = $bd->getConnection();
        $sql = 'INSERT into usuario (cd_usuario, cd_funcionario, login, senha, tipo_usuario) values (? , ? , ? , ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1,$usuario->getCd_usuario());
        $stmt->bindValue(2,$usuario->getCd_funcionario());
        $stmt->bindValue(3,$usuario->getLogin());
        $stmt->bindValue(4,md5($usuario->getSenha()));
        $stmt->bindValue(5,$usuario->getTipo_usuario());

        if($stmt->execute()){
            echo "<script>
            window.alert('Cadastrado com sucesso!');
            window.location.href = 'http://localhost/tcc/admin.php';
            </script>";
            exit;
        }else{
            echo "<script>
            window.alert('Erro ao salvar!');
            window.location.href = 'http://localhost/tcc/admin.php';
            </script>";
            exit;
        }
    }

    public function validarUsuario(Usuario $usuario){
        $dadosbd = new Usuario();
        $bd = new BD();
        $conn = $bd->getConnection();
        try{
            $login = $usuario->getLogin();
            $senha = $usuario->getSenha();
            $sql = "SELECT * from usuario where login=:login";
            $query = $conn->prepare($sql);
            $query->bindParam(":login", $login);
            $query->execute();
            $dados= $query->fetch(PDO::FETCH_ASSOC);
            $total = $query->rowCount();
            // Caso o usuário tenha digitado um login válido o número de linhas será 1..
            if($total)
                {
	                // Agora verifica a senha
	                if(!strcmp(md5($senha),$dados["senha"]))
	                {
		                // TUDO OK! Agora, passa os dados para a sessão e redireciona o usuário
		                $_SESSION["cd_usuario"]= $dados["cd_usuario"];
		                $_SESSION["cd_funcionario"] = $dados["cd_funcionario"];
		                $_SESSION["login"]= $dados["login"];
                        $_SESSION["senha"] = $dados["senha"];
                        $_SESSION["permissao"] = $dados["tipo_usuario"];

                        if($dados["tipo_usuario"] == 1){     
		                   header("Location:admin.php");
		                   exit;
                        }
                        if($dados["tipo_usuario"] == 2){
                            header("Location:home.php");
                            exit;
                        }
                        else{
                           echo "Erro ao logar";
                           exit;
                        }
                    }
	                // Senha inválida
	                else
	                {
                        echo "<script>
                        window.alert('Senha inválida!');
                        window.location.href = 'http://localhost/tcc/login.php';
                        </script>";
                        exit;
	                }
            }       
	         // Login inválido
            else
            {
	            echo "<script>
					window.alert('O login fornecido é inexistente!');
                    window.location.href = 'http://localhost/tcc/login.php';
					</script>";
					exit;
            }
        } catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
        }
    }
    public function listarTodosUsuarios(){
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
            echo"</tr></table>";
            }catch(PDOException $ex){
                echo 'Erro: ' .$ex->getMessage();
            }
}

/*echo "<script>
window.alert('cd_usuario: $cd_usuario , cd_funcionario: $cd_funcionario , login: $login , tipo_usuario: $tipo_usuario');
</script>";*/

    public function deletarUsuario(Usuario $usuario){
        $bd = new BD();
        $conn = $bd->getConnection();
        $cd_usuario = $usuario->getCd_usuario();
        try{
            //verifica se existe
            $sql = "SELECT * FROM usuario where cd_usuario=:cd_usuario";
            $query = $conn->prepare($sql);
            $query->bindParam(":cd_usuario", $cd_usuario);
            $query->execute();
            if(!$query->fetch(PDO::FETCH_ASSOC)){
                echo "<script>
                window.alert('O usuário não existe!');
                window.location.href = 'http://localhost/tcc/admin.php';
                </script>";
                exit;
            }else{
            $sql = "DELETE FROM usuario WHERE cd_usuario=:cd_usuario";
            $query = $conn->prepare($sql);
            $query->bindParam(":cd_usuario", $cd_usuario);
            $query->execute();
            if($query->execute()){
                echo "<script>
                window.alert('Usuário deletado com sucesso!');
                window.location.href = 'http://localhost/tcc/admin.php';
                </script>";
                exit;
            }else{
                echo "<script>
                window.alert('Erro ao deletar o usuário!');
                window.location.href = 'http://localhost/tcc/admin.php';
                </script>";
                exit;              
            }
        }
        } catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
        }
    }

    public function BuscarUsuarioPorID(Usuario $usuario){
        $bd = new BD();
        $conn = $bd->getConnection();
        try{
            $cd_usuario = $usuario->getCd_usuario();
            $sql = "SELECT * FROM usuario WHERE cd_usuario=:cd_usuario";
            $query = $conn->prepare($sql);
            $query->bindParam(":cd_usuario", $cd_usuario);
            $query->execute();
            $dados= $query->fetch(PDO::FETCH_ASSOC);
            $cd_usuario = $dados["cd_usuario"];
            $cd_funcionario = $dados["cd_funcionario"];
            $login = $dados["login"];
            $tipo_usuario = $dados["tipo_usuario"];
            echo "cd_usuario: $cd_usuario , cd_funcionario: $cd_funcionario , login: $login , tipo_usuario: $tipo_usuario";
        }catch(PDOException $ex){
        echo "Erro: " .$ex->getMessage();
        }
    }

    public function editarUsuario(Usuario $usuario){
        $cd_usuario = $usuario->getCd_usuario();
        $bd = new BD();
        $conn = $bd->getConnection();
        try{
            $sql = "Select * from usuario where cd_usuario=:cd_usuario";
            $query = $conn->prepare($sql);
            $query->bindParam(":cd_usuario", $cd_usuario);
            $query->execute();
            $dados= $query->fetch(PDO::FETCH_ASSOC);
            if($dados){
                $sql = "UPDATE usuario SET cd_funcionario = ?, login = ?, senha = ? , tipo_usuario = ? WHERE cd_usuario=?";    
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1,$usuario->getCd_funcionario());
                $stmt->bindValue(2,$usuario->getLogin());
                $stmt->bindValue(3,md5($usuario->getSenha()));
                $stmt->bindValue(4,$usuario->getTipo_usuario());
                $stmt->bindValue(5,$usuario->getCd_usuario());
                if($stmt->execute()){
                    echo "<script>
                    window.alert('Salvo com sucesso');
                    window.location.href = 'http://localhost/tcc/admin.php';
                    </script>";
                    exit;
                }else{
                    echo "<script>
                    window.alert('Erro ao salvar');
                    window.location.href = 'http://localhost/tcc/admin.php';
                    </script>";
                    exit;
                }
            }else{
                echo "<script>
                window.alert('Insira um código de usuário válido');
                window.location.href = 'http://localhost/tcc/admin.php';
                </script>";
                exit;
            }
        }catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
            }
    }
}    
?>