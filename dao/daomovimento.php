<?php
include_once 'C:\xampp\htdocs\tcc\database\conexao.php';
include_once 'C:\xampp\htdocs\tcc\model\movimento.php';
include_once 'C:\xampp\htdocs\tcc\envia_mail.php';
include_once 'C:\xampp\htdocs\tcc\model\funcionario.php';
include_once 'C:\xampp\htdocs\tcc\model\prontuario.php';
include_once 'C:\xampp\htdocs\tcc\controller\movimentocontroller.php';



class DaoMovimento{
    public function inserirMovimento(Movimento $movimento, Prontuario $prontuario){
        try{
        $bd= new BD();
        $conn = $bd->getConnection();
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('Y-m-d H:i');
        //buscar prontuario
        $cpf = $prontuario->getNr_cpf();
        $sql = 'SELECT * from prontuario where nr_cpf= :nr_cpf';
        $query = $conn->prepare($sql);
        $query->bindParam(":nr_cpf" , $cpf);
        $query->execute();
        $prontuariobd= $query->fetch(PDO::FETCH_ASSOC);
        if(!$prontuariobd){
            echo "<script>
            window.alert('Nenhum prontuário encontrado com esse CPF!');
            window.location.href = 'http://localhost/tcc/home.php';
            </script>";
        }
        //buscar funcionario
        $sql = 'SELECT * from funcionario where email= :email';
        $query = $conn->prepare($sql);
        $query->bindParam(":email" , $_SESSION['login']);
        $query->execute();
        $funcionario= $query->fetch(PDO::FETCH_ASSOC);
        //Se estiver disponível
        if($prontuariobd['situacao'] == 'D'){
            $sql = 'INSERT into movimentos (cd_prontuario,cd_funcionario_origem, cd_funcionario_destino, dt_saida, dt_volta,motivo, situacao) values (? , ? , ? , ?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1,$prontuariobd['cd_prontuario']);
            $stmt->bindValue(2,$funcionario['cd_funcionario']);
            $stmt->bindValue(3,NULL);
            $stmt->bindValue(4,$date);
            $stmt->bindValue(5,NULL);
            $stmt->bindValue(6,$movimento->getMotivo());
            $stmt->bindValue(7,"A");
            if($stmt->execute()){
            $id_prontuario = $prontuariobd['cd_prontuario'];
            echo "<script>
            window.alert('Solicitado com sucesso! O prontuário de código $id_prontuario espera sua retirada');
            window.location.href = 'http://localhost/tcc/home.php';
            </script>";
            $sql = ' UPDATE prontuario SET situacao = "I" WHERE nr_cpf= :nr_cpf';
            $query = $conn->prepare($sql);
            $query->bindParam(":nr_cpf" , $cpf);
            $query->execute();
            }else{     
                echo"erro ao solicitar";
                /*      
                echo "<script>
            window.alert('Erro ao solicitar');
            window.location.href = 'http://localhost/tcc/home.php';
            </script>";*/
            }
            //Se já estiver em Uso
        }else if($prontuariobd['situacao'] == 'I'){
        $sql = 'SELECT * from movimentos where cd_prontuario= :cd_prontuario and situacao="A"';  
        $query = $conn->prepare($sql);
        $query->bindParam(":cd_prontuario" , $prontuariobd["cd_prontuario"]);
        $query->execute();
        $movimentodados = $query->fetch(PDO::FETCH_ASSOC);
        $sql = 'SELECT * from funcionario where cd_funcionario= :cd_funcionario';  
        $query = $conn->prepare($sql);
        $query->bindParam(":cd_funcionario" , $movimentodados["cd_funcionario_origem"]);
        $query->execute();
        $funcionariodados = $query->fetch(PDO::FETCH_ASSOC);
        if($funcionariodados["email"] == $_SESSION['login']){
            echo "<script>
            window.alert('Este prontuário já está sob sua responsabilidade!');
            window.location.href = 'http://localhost/tcc/home.php';
            </script>";
            exit;
        }
            //verifica se já solicitou
        $sql = 'SELECT * from movimentos where cd_prontuario= :cd_prontuario and cd_funcionario_destino = :cd_funcionario_destino and situacao = "P"';  
        $query = $conn->prepare($sql);
        $query->bindParam(":cd_prontuario" , $prontuariobd["cd_prontuario"]);
        $query->bindParam(":cd_funcionario_destino" , $funcionario["cd_funcionario"]);
        $query->execute();
        if($solicitacao =  $query->fetch(PDO::FETCH_ASSOC)){
                echo "<script>
                window.alert('Você já solicitou este prontuário!');
                window.location.href = 'http://localhost/tcc/home.php';
                </script>";
                exit;
            }
        $sql = 'INSERT into movimentos (cd_prontuario,cd_funcionario_origem, cd_funcionario_destino, dt_saida, dt_volta,motivo, situacao) values (? , ? , ? , ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1,$prontuariobd['cd_prontuario']);
        $stmt->bindValue(2,$movimentodados['cd_funcionario_origem']);
        $stmt->bindValue(3,$funcionario['cd_funcionario']);
        $stmt->bindValue(4,$date);
        $stmt->bindValue(5,NULL);
        $stmt->bindValue(6,$movimento->getMotivo());
        $stmt->bindValue(7,"P");
        if($stmt->execute()){
        $mail = new Email();
        $emailorigem = $funcionariodados["email"];
        $emaildestino = $_SESSION['login'];
        $mail->trocarMovimentoEmail($prontuariobd["cd_prontuario"],$emailorigem,$emaildestino);
        }
    }
    }catch(PDOException $ex){
        echo 'Erro: ' .$ex->getMessage();
    }
}
    public function inativarMovimento(Movimento $movimento){
        try{
        date_default_timezone_set('America/Sao_Paulo');
        $dt_volta = date('Y-m-d H:i');
        $bd= new BD();
        $conn = $bd->getConnection();
        $cd_prontuario = $movimento->getCd_prontuario();    
        $sql = ' UPDATE movimentos SET situacao = "I" , dt_volta = :dt_volta WHERE cd_prontuario= :cd_prontuario and situacao = "A"';
        $query = $conn->prepare($sql);
        $query->bindParam(":cd_prontuario" , $cd_prontuario);
        $query->bindParam(":dt_volta", $dt_volta);
        return $query->execute();
        }catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
        }
    }

    public function trocarMovimentoEmail(int $cd_prontuario, string $emailorigem, string $emaildestino){
        try{
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('Y-m-d H:i');
        $bd= new BD();
        $conn = $bd->getConnection();
        //Finalizando o movimento do funcionário origem
        $sql = 'SELECT cd_funcionario from funcionario where email= :email';  
        $query = $conn->prepare($sql);
        $query->bindParam(":email" , $emailorigem);
        $query->execute();
        $cd_funcionario_origem = $query->fetch(PDO::FETCH_ASSOC);
        $sql = ' UPDATE movimentos SET situacao = "I", dt_volta = :dt_volta where cd_prontuario = :cd_prontuario and cd_funcionario_origem = :cd_funcionario_origem and situacao = "A"';  
        $query = $conn->prepare($sql);
        $query->bindParam(":dt_volta" , $date);
        $query->bindParam(":cd_prontuario" , $cd_prontuario);
        $query->bindParam(":cd_funcionario_origem" , $cd_funcionario_origem["cd_funcionario"]);
        $query->execute();
        //Aceitar a troca
            //primeiro vamos buscar os dados do funcionario destino
            $sql = 'SELECT cd_funcionario from funcionario where email= :email';  
            $query = $conn->prepare($sql);
            $query->bindParam(":email" , $emaildestino);
            $query->execute();
            $cd_funcionario_destino = $query->fetch(PDO::FETCH_ASSOC);
            //recuperar os dados
            $sql = 'SELECT * from movimentos where cd_prontuario = :cd_prontuario and cd_funcionario_origem = :cd_funcionario_origem and cd_funcionario_destino = :cd_funcionario_destino and situacao = "P"';
            $query = $conn->prepare($sql);
            $query->bindParam(":cd_prontuario" , $cd_prontuario);
            $query->bindParam(":cd_funcionario_origem" , $cd_funcionario_origem["cd_funcionario"]);
            $query->bindParam(":cd_funcionario_destino" , $cd_funcionario_destino["cd_funcionario"]);
            $query->execute();
            $recuperarMotivo = $query->fetch(PDO::FETCH_ASSOC);
            //vamos aceitar a troca no banco de dados
        $sql = ' UPDATE movimentos SET situacao = "T", dt_volta = :dt_volta where cd_prontuario = :cd_prontuario and cd_funcionario_origem = :cd_funcionario_origem and cd_funcionario_destino = :cd_funcionario_destino and situacao = "P"';  
        $query = $conn->prepare($sql);
        $query->bindParam(":dt_volta", $date);
        $query->bindParam(":cd_prontuario" , $cd_prontuario);
        $query->bindParam(":cd_funcionario_origem" , $cd_funcionario_origem["cd_funcionario"]);
        $query->bindParam(":cd_funcionario_destino" , $cd_funcionario_destino["cd_funcionario"]);
        $query->execute();
        if($query->execute()){
            //cria o novo movimento
            $sql = 'INSERT into movimentos (cd_prontuario,cd_funcionario_origem, cd_funcionario_destino, dt_saida, dt_volta,motivo, situacao) values (? , ? , ? , ?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1,$cd_prontuario);
            $stmt->bindValue(2,$cd_funcionario_destino["cd_funcionario"]);
            $stmt->bindValue(3,NULL);
            $stmt->bindValue(4,$date);
            $stmt->bindValue(5,NULL);
            $stmt->bindValue(6,$recuperarMotivo["motivo"]); 
            $stmt->bindValue(7,"A");
            if($stmt->execute()){
                echo "<script>
                window.alert('A troca foi aceita um email foi enviado para o outro usuário!');
                window.location.href = 'http://localhost/tcc/home.php';
                </script>";
                $email = new Email();
                $email->trocaConfirmada($emailorigem,$emaildestino);  
            }
        }
        $email = new Email();
        $email->trocaConfirmada($emailorigem,$emaildestino);  
        }catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
        }
    }

    public function recusaTroca(int $cd_prontuario, string $emailorigem, string $emaildestino){
        try{
        $bd= new BD();
        $conn = $bd->getConnection();
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('Y-m-d H:i');
        $sql = 'SELECT cd_funcionario from funcionario where email= :email';  
        $query = $conn->prepare($sql);
        $query->bindParam(":email" , $emailorigem);
        $query->execute();
        $funcionario_origem = $query->fetch(PDO::FETCH_ASSOC);
        $cd_funcionario_origem = $funcionario_origem["cd_funcionario"];
        $sql = 'SELECT cd_funcionario from funcionario where email= :email';  
        $query = $conn->prepare($sql);
        $query->bindParam(":email" , $emaildestino);
        $query->execute();
        $funcionario_destino = $query->fetch(PDO::FETCH_ASSOC);
        $cd_funcionario_destino = $funcionario_destino["cd_funcionario"];
        $sql = ' UPDATE movimentos SET situacao = "N" , dt_volta = :dt_volta where cd_prontuario = :cd_prontuario and cd_funcionario_origem = :cd_funcionario_origem and cd_funcionario_destino = :cd_funcionario_destino and situacao="P"';
        $query = $conn->prepare($sql);
        $query->bindParam(":dt_volta", $date);
        $query->bindParam(":cd_prontuario" , $cd_prontuario);
        $query->bindParam(":cd_funcionario_origem" , $cd_funcionario_origem);
        $query->bindParam(":cd_funcionario_destino" , $cd_funcionario_destino);
        if($query->execute()){
            echo "<script>
                window.alert('A troca foi negada!');
                window.location.href = 'http://localhost/tcc/home.php';
                </script>";
                exit;
        };
        }catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
        }
    }
}