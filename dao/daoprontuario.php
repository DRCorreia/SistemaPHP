<?php

include_once 'C:\xampp\htdocs\tcc\database\conexao.php';
include_once 'C:\xampp\htdocs\tcc\model\movimento.php';
include_once 'C:\xampp\htdocs\tcc\model\prontuario.php';
include_once 'C:\xampp\htdocs\tcc\envia_mail.php';
include_once 'C:\xampp\htdocs\tcc\controller\prontuariocontroller.php';
include_once 'C:\xampp\htdocs\tcc\controller\movimentocontroller.php';

class DaoProntuario{
    public function baixarProntuario(Prontuario $prontuario,$trocadata){
    $bd= new BD();
    $conn = $bd->getConnection();
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i');
    
    //puxar dados para verificar autenticidade do funcionario
    $email = $_SESSION['login'];
    $sql = 'SELECT * from funcionario where email= :email';
    $query = $conn->prepare($sql);
    $query->bindParam(":email" , $email);
    $query->execute();
    $funcionario= $query->fetch(PDO::FETCH_ASSOC);
    //puxar dados do prontuário
    $cd_prontuario = $prontuario->getCd_prontuario();
    $sql = 'SELECT * from movimentos where cd_prontuario= :cd_prontuario and situacao = "A"';
    $query = $conn->prepare($sql);
    $query->bindParam(":cd_prontuario" , $cd_prontuario);
    $query->execute();
    $movimentos= $query->fetch(PDO::FETCH_ASSOC);
    //autenticação
    if($funcionario["cd_funcionario"] == $movimentos["cd_funcionario_origem"]){
        $sql = 'SELECT * from movimentos where cd_prontuario= :cd_prontuario and situacao = "P" order by dt_saida';
        $query = $conn->prepare($sql);
        $query->bindParam(":cd_prontuario" , $cd_prontuario);
        $query->execute();
        $dados= $query->fetch(PDO::FETCH_ASSOC);
        if($dados == NULL){
            $envia_email = new Email();
            $envia_email->enviarEmail($prontuario,$trocadata);
        }
        else{
            $sql = 'UPDATE movimentos SET situacao = "I" , dt_volta = :dt_volta WHERE cd_prontuario = :cd_prontuario and situacao = "A"';
            $query = $conn->prepare($sql);
            $query->bindParam(":cd_prontuario" , $cd_prontuario);
            $query->bindParam(":dt_volta" , $date);
            $query->execute();
            if($trocadata == 1){
                $sql = 'UPDATE prontuario SET ultima_att = :ultima_att WHERE cd_prontuario = :cd_prontuario';
                $query = $conn->prepare($sql);
                $query->bindParam(":ultima_att" , $date);
                $query->bindParam(":cd_prontuario" , $cd_prontuario);
                $query->execute();
            }
            $sql = 'INSERT into movimentos (cd_prontuario,cd_funcionario_origem, cd_funcionario_destino, dt_saida, dt_volta,motivo, situacao) values (? , ? , ? , ?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1,$cd_prontuario);
            $stmt->bindValue(2,$dados["cd_funcionario_destino"]);
            $stmt->bindValue(3,NULL);
            $stmt->bindValue(4,$date);
            $stmt->bindValue(5,NULL);
            $stmt->bindValue(6,$dados["motivo"]);
            $stmt->bindValue(7,"A");
            if($stmt->execute()){
                $sql = 'SELECT * from funcionario where cd_funcionario= :cd_funcionario';
                $query = $conn->prepare($sql);
                $query->bindParam(":cd_funcionario" , $dados["cd_funcionario_destino"]);
                $query->execute();
                $dadosfunc = $query->fetch(PDO::FETCH_ASSOC);
                $emaildestino = $dadosfunc["email"];
                $transfere_email = new Email();
                $transfere_email->transfereEmail($funcionario["email"],$emaildestino , $cd_prontuario);
                $sql = 'UPDATE movimentos SET dt_volta = :dt_volta , situacao = "T" WHERE cd_prontuario = :cd_prontuario and cd_funcionario_origem = :cd_funcionario_origem and cd_funcionario_destino = :cd_funcionario_destino and situacao = "P"';
                $query = $conn->prepare($sql);
                $query->bindParam(":dt_volta" , $date);
                $query->bindParam(":cd_prontuario" , $cd_prontuario);
                $query->bindParam(":cd_funcionario_origem" , $funcionario["cd_funcionario"]);
                $query->bindParam(":cd_funcionario_destino", $dados["cd_funcionario_destino"]);
                $query->execute();
                echo "<script>
                window.alert('Este prontuário foi solicitado pelo usuário $emaildestino e deve ser entregue à ele. Entre em contato com esse usuário para organizar a entrega. ');
                window.location.href = 'http://localhost/tcc/home.php';
                </script>";
        }
        }
    }
    else{ 
        echo "<script>
        window.alert('Esse prontuário não existe ou não está sob sua responsabilidade!');
        window.location.href = 'http://localhost/tcc/home.php';
        </script>";
        exit;
    }
    }
    public function atualizarProntuario(Prontuario $prontuario,$trocadata){
    $cd_prontuario = $prontuario->getCd_prontuario();
    $bd= new BD();
    $conn = $bd->getConnection();   
    if($trocadata = 0){
    $sql = 'UPDATE prontuario SET situacao = "D" WHERE cd_prontuario = :cd_prontuario';
    $query = $conn->prepare($sql);
    $query->bindParam(":cd_prontuario", $cd_prontuario);
    if($query->execute()){
        $movimento = new Movimento();
        $movimento->setCd_prontuario($cd_prontuario);
        $movimentocontroller = new MovimentoController();
        if($movimentocontroller->inativarMovimento($movimento)){
            echo "<script>
                window.alert('O status do prontuário foi atualizado com sucesso!');
                window.location.href = 'http://localhost/tcc/home.php';
                </script>";
                exit;
        }else{
            echo "<script>
                window.alert('Erro ao atualizar status do prontuário!');
                window.location.href = 'http://localhost/tcc/home.php';
                </script>";
                exit;
        }
    }else{
        echo"Erro de SQL!";
    }
    }
    if($trocadata = 1){
        date_default_timezone_set('America/Sao_Paulo');
        $date = date("Y-m-d H:i:s"); 
        $sql = 'UPDATE prontuario SET situacao = "D" , ultima_att = :ultima_att WHERE cd_prontuario = :cd_prontuario';
        $query = $conn->prepare($sql);
        $query->bindParam(":ultima_att", $date);
        $query->bindParam(":cd_prontuario", $cd_prontuario);
        if($query->execute()){
            $movimento = new Movimento();
            $movimento->setCd_prontuario($cd_prontuario);
            $movimentocontroller = new MovimentoController();
            if($movimentocontroller->inativarMovimento($movimento)){
                echo "<script>
                window.alert('O status do prontuário foi atualizado com sucesso!');
                window.location.href = 'http://localhost/tcc/home.php';
                </script>";
                exit;
            }else{
                echo "<script>
                window.alert('Erro ao atualizar status do prontuário!');
                window.location.href = 'http://localhost/tcc/home.php';
                </script>";
                exit;
            }
        }else{
            echo"Erro de SQL!";
        }
        }
    }
    public function inserirProntuario(Prontuario $prontuario){
        $bd = new BD();
        $conn = $bd->getConnection();
        $sql = 'INSERT into prontuario(cd_prontuario , cd_gaveta, nr_cpf, nm_paciente, paciente_sexo , nm_pai , nm_mae , dt_nascimento , dt_cadastro , ultima_att, situacao) values (? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $prontuario->getCd_prontuario());
        $stmt->bindValue(2, $prontuario->getCd_gaveta());
        $stmt->bindValue(3, $prontuario->getNr_cpf());
        $stmt->bindValue(4, $prontuario->getNm_paciente());
        $stmt->bindValue(5, $prontuario->getPaciente_sexo());
        $stmt->bindValue(6, $prontuario->getNm_pai());
        $stmt->bindValue(7, $prontuario->getNm_mae());
        $stmt->bindValue(8, $prontuario->getDt_nascimento());
        $stmt->bindValue(9, $prontuario->getDt_cadastro());
        $stmt->bindValue(10, $prontuario->getUltima_att());
        $stmt->bindValue(11, $prontuario->getSituacao());
        if($stmt->execute()){
            echo "<script>
            window.alert('Prontuário inserido com sucesso!');
            window.location.href = 'http://localhost/tcc/admin.php';
            </script>";
            exit;
        }else{
            echo "<script>
            window.alert('Erro ao inserir o prontuário!');
            window.location.href = 'http://localhost/tcc/admin.php';
            </script>";
            exit;
        }
    }

    public function deletarProntuario(Prontuario $prontuario){
        $bd = new BD();
        $conn = $bd->getConnection();
        $cd_prontuario = $prontuario->getCd_prontuario();
        try{
            //verifica se existe e se está em uso
            $sql = "SELECT * FROM prontuario where cd_prontuario=:cd_prontuario and situacao = 'D'";
            $query = $conn->prepare($sql);
            $query->bindParam(":cd_prontuario", $cd_prontuario);
            $query->execute();
            if(!$query->fetch(PDO::FETCH_ASSOC)){
                echo "<script>
                window.alert('O prontuário não existe ou está em uso');
                window.location.href = 'http://localhost/tcc/admin.php';
                </script>";
                exit;
            }else{
            //tudo certo pra excluir
            $sql = "DELETE FROM prontuario WHERE cd_prontuario=:cd_prontuario";
            $query = $conn->prepare($sql);
            $query->bindParam(":cd_prontuario", $cd_prontuario);
            if($query->execute()){
                echo "<script>
                window.alert('Prontuario deletado com sucesso!');
                window.location.href = 'http://localhost/tcc/admin.php';
                </script>";
                exit;
            
            }else{
                echo "<script>
                window.alert('Erro ao deletar o prontuario!');
                window.location.href = 'http://localhost/tcc/admin.php';
                </script>";
                exit;
            }
        }
        } catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
        }
    }

    public function editarProntuario(Prontuario $prontuario){
        $dadosbd = new Prontuario();
        $bd = new BD();
        $conn = $bd->getConnection();
        try{
            $cd_prontuario = $prontuario->getCd_prontuario();
            $sql = "Select * from prontuario where cd_prontuario=:cd_prontuario";
            $query = $conn->prepare($sql);
            $query->bindParam(":cd_prontuario", $cd_prontuario);
            $query->execute();
            $dados= $query->fetch(PDO::FETCH_ASSOC);


            if($dados){
                if($prontuario->getCd_gaveta()) $dados["cd_gaveta"] = $prontuario->getCd_gaveta();
                if($prontuario->getNr_cpf()) $dados["nr_cpf"] = $prontuario->getNr_cpf();
                if($prontuario->getNm_paciente()) $dados["nm_paciente"] = $prontuario->getNm_paciente();
                if($prontuario->getPaciente_sexo()) $dados["paciente_sexo"] = $prontuario->getPaciente_sexo();
                if($prontuario->getNm_pai()) $dados["nm_pai"] = $prontuario->getNm_pai();
                if($prontuario->getNm_mae()) $dados["nm_mae"] = $prontuario->getNm_mae();
                if($prontuario->getDt_nascimento()) $dados["dt_nascimento"] = $prontuario->getDt_nascimento();
                if($prontuario->getDt_cadastro()) $dados["dt_cadastro"] = $prontuario->getDt_cadastro();
                if($prontuario->getUltima_att()) $dados["ultima_att"] = $prontuario->getUltima_att();
                if($prontuario->getSituacao()) $dados["situacao"] = $prontuario->getSituacao();

                $sql = "UPDATE prontuario SET  cd_gaveta = ?, nr_cpf = ? , nm_paciente = ? , paciente_sexo = ? , nm_pai = ? , nm_mae = ? , dt_nascimento = ? , dt_cadastro = ? , ultima_att = ? , situacao = ? WHERE cd_prontuario = ?";    
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1, $dados["cd_gaveta"]);
                $stmt->bindValue(2, $dados["nr_cpf"]);
                $stmt->bindValue(3, $dados["nm_paciente"]);
                $stmt->bindValue(4, $dados["paciente_sexo"]);
                $stmt->bindValue(5, $dados["nm_pai"]);
                $stmt->bindValue(6, $dados["nm_mae"]);
                $stmt->bindValue(7, $dados["dt_nascimento"]);
                $stmt->bindValue(8, $dados["dt_cadastro"]);
                $stmt->bindValue(9, $dados["ultima_att"]);
                $stmt->bindValue(10, $dados["situacao"]);
                $stmt->bindValue(11, $cd_prontuario);
                if($stmt->execute()){
                    echo "<script>
                    window.alert('Salvo com sucesso!');
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
            }else{
                    echo "<script>
                    window.alert('Insira um número de prontuário válido!');
                    window.location.href = 'http://localhost/tcc/admin.php';
                    </script>";
                    exit;
            }
        }catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
            }
    }
}