<?php

include_once 'C:\xampp\htdocs\tcc\model\usuario.php';
include_once 'C:\xampp\htdocs\tcc\model\prontuario.php';
include_once 'C:\xampp\htdocs\tcc\dao\daousuario.php';
include_once 'C:\xampp\htdocs\tcc\database\conexao.php';
include_once 'C:\xampp\htdocs\tcc\controller\usuariocontroller.php';
include_once 'C:\xampp\htdocs\tcc\controller\prontuariocontroller.php';
include_once 'C:\xampp\htdocs\tcc\dao\daoprontuario.php';
/*
include_once 'C:\xampp\htdocs\tcc\model\usuario.php';
include_once 'C:\xampp\htdocs\tcc\model\prontuario.php';
include_once 'C:\xampp\htdocs\tcc\dao\daousuario.php';
include_once 'C:\xampp\htdocs\tcc\dao\daoprontuario.php';
include_once 'C:\xampp\htdocs\tcc\controller\usuariocontroller.php';
include_once 'C:\xampp\htdocs\tcc\controller\prontuariocontroller.php';
include_once 'C:\xampp\htdocs\tcc\database\conexao.php';
*/
session_start();

// Checa se tá logado e como admin
if((!isset($_SESSION['login'])) or (!isset($_SESSION['cd_usuario'])) or (!isset($_SESSION['permissao'])) or ($_SESSION["permissao"] != "1"))
{
	header('location:home.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="./css/home.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<title>Admin</title>
<style>
.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}

.active, .accordion:hover {
  background-color: #ccc; 
}

.panel {
  padding: 0 18px;
  display: none;
  background-color: white;
  overflow: hidden;
}
</style>
	</head>
	<body>
		<form class="main-container" method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
		<div class="button-container">
		<button class="btn btn-success" style="margin-top: 0px; margin-left: 900px; margin-right: 15px; " type="submit" name="btnLogout">Sair</button>
		</div>
		</form>
		<?php
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
				if(isset($_POST['btnCadastrar'])){
					$usuario = new Usuario();
					$usuario->setCd_usuario($_POST["cd_usuario"]);
					$usuario->setCd_funcionario($_POST["cd_funcionario"]);
					$usuario->setLogin($_POST["login"]);
					$usuario->setSenha($_POST["senha"]);
					$usuario->setTipo_usuario($_POST["tipo_usuario"]);
					if(!$usuario->getCd_Usuario() || !$usuario->getCd_funcionario() || !$usuario->getLogin() || !$usuario->getSenha() || !$usuario->getTipo_usuario())
				{
					echo "<script>
					window.alert('Você deve preencher todos os campos!');
					window.location.href = 'http://localhost/tcc/admin.php';
					</script>";
					exit;
				}
					$usuariocontroller = new UsuarioController();
					$usuariocontroller->inserirUsuario($usuario);
				}
				else if(isset($_POST['btnDeletar'])){
					$usuario = new Usuario();
					$usuario->setCd_usuario($_POST["cd_usuario"]);

					$usuariocontroller = new UsuarioController();
					$usuariocontroller->deletarUsuario($usuario);
				}
				else if(isset($_POST['btnListar'])){
					$usuariocontroller = new UsuarioController();
					$usuariocontroller->listarTodosUsuarios();
				}

				else if(isset($_POST['btnBuscar'])){
					$usuario = new Usuario();
					$usuario->setCd_usuario($_POST["cd_usuario"]);

					$usuariocontroller = new UsuarioController();
					$usuariocontroller->BuscarUsuarioPorID($usuario);
				}
				else if(isset($_POST['btnEditar'])){
					$usuario = new Usuario();
					$usuario->setCd_usuario($_POST["cd_usuario"]);
					$usuario->setCd_funcionario($_POST["cd_funcionario"]);
					$usuario->setLogin($_POST["login"]);
					$usuario->setSenha($_POST["senha"]);
					$usuario->setTipo_usuario($_POST["tipo_usuario"]);

					if(!$usuario->getCd_Usuario() || !$usuario->getCd_funcionario() || !$usuario->getLogin() || !$usuario->getSenha() || !$usuario->getTipo_usuario())
				{
					echo "<script>
					window.alert('Você deve preencher todos os campos!');
					window.location.href = 'http://localhost/tcc/admin.php';
					</script>";
					exit;
				}
					if($usuario->getTipo_usuario() != '1' && $usuario->getTipo_usuario() != '2'){
						echo "<script>
						window.alert('Tipo de usuário inválido');
						window.location.href = 'http://localhost/tcc/admin.php';
						</script>";
						exit;
					}
					
					$usuariocontroller = new UsuarioController();
					$usuariocontroller->editarUsuario($usuario); 
				}
				
				else if(isset($_POST['btnCadastrarProntuario'])){
					$prontuario = new Prontuario();
					$prontuario->setCd_prontuario($_POST["cd_prontuario"]);
					$prontuario->setCd_gaveta($_POST["cd_gaveta"]);
					$prontuario->setNr_cpf($_POST["nr_cpf"]);
					$prontuario->setNm_paciente($_POST["nm_paciente"]);
					$prontuario->setPaciente_sexo($_POST["paciente_sexo"]);
					$prontuario->setNm_pai($_POST["nm_pai"]);
					$prontuario->setNm_mae($_POST["nm_mae"]);
					$prontuario->setDt_nascimento($_POST["dt_nascimento"]);
					$prontuario->setDt_cadastro($_POST["dt_cadastro"]);
					$prontuario->setUltima_att($_POST["ultima_att"]);
					$prontuario->setSituacao($_POST["situacao"]);
					if(!$prontuario->getCd_prontuario() || !$prontuario->getCd_gaveta() || !$prontuario->getNr_cpf() || !$prontuario->getNm_paciente() || !$prontuario->getPaciente_sexo() || !$prontuario->getNm_pai() || !$prontuario->getNm_mae() || !$prontuario->getDt_nascimento() || !$prontuario->getDt_cadastro() || !$prontuario->getUltima_att() || !$prontuario->getSituacao()){
						echo "<script>
						window.alert('Você deve preencher todos os campos!');
						window.location.href = 'http://localhost/tcc/admin.php';
						</script>";
						exit;
					}
					else{
						$prontuariocontroller = new ProntuarioController();
						$prontuariocontroller->inserirProntuario($prontuario);
					}
				}
				else if(isset($_POST['btnDeletarProntuario'])){
					$prontuario = new Prontuario();
					$prontuario->setCd_prontuario($_POST["cd_prontuario"]);
					$prontuariocontroller = new ProntuarioController();
					$prontuariocontroller->deletarProntuario($prontuario);
				}

				else if(isset($_POST['btnEditarProntuario'])){
					$prontuario = new Prontuario();

					if(!$_POST["cd_prontuario"]){
						echo "<script>
						window.alert('Para editar as informações do prontuário você deve informar o código do prontuário!');
						window.location.href = 'http://localhost/tcc/admin.php';
						</script>";
						exit;
					}
					else{
					$prontuario->setCd_prontuario($_POST["cd_prontuario"]);
					$prontuario->setCd_gaveta($_POST["cd_gaveta"]);
					$prontuario->setNr_cpf($_POST["nr_cpf"]);
					$prontuario->setNm_paciente($_POST["nm_paciente"]);
					$prontuario->setPaciente_sexo($_POST["paciente_sexo"]);
					$prontuario->setNm_pai($_POST["nm_pai"]);
					$prontuario->setNm_mae($_POST["nm_mae"]);
					$prontuario->setDt_nascimento($_POST["dt_nascimento"]);
					$prontuario->setDt_cadastro($_POST["dt_cadastro"]);
					$prontuario->setUltima_att($_POST["ultima_att"]);
					$prontuario->setSituacao($_POST["situacao"]);
					
					$prontuariocontroller = new ProntuarioController();
					$prontuariocontroller->editarProntuario($prontuario);
					}
				}
				else if(isset($_POST['btnLogout'])){
					echo "<script>
					window.location.href = 'http://localhost/tcc/login.php';
					</script>";
					$_SESSION["cd_usuario"]= NULL;
		            $_SESSION["cd_funcionario"] = NULL;
		            $_SESSION["login"]= NULL;
                    $_SESSION["senha"] = NULL;
                    $_SESSION["permissao"] = NULL;
				}
				}
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			if(isset($_SESSION['msgcad'])){
				echo $_SESSION['msgcad'];
				unset($_SESSION['msgcad']);
			}

		?>
<div class="container">
	<h1 class="heading-primary">Área do Administrador </h1>
	<h4 style="text-align:center;">Usuário</h4>
    	<div class="accordion">
        	<dl>
        	<!-- description list -->

        	<dt>
         	<!-- accordion 1 Cadastrar -->
          	<a href="#accordion1" aria-expanded="false" aria-controls="accordion1" class="accordion-title accordionTitle js-accordionTrigger">Cadastrar usuário</a>
        	</dt>
        	<dd class="accordion-content accordionItem is-collapsed" id="accordion2" aria-hidden="true">
       		<div class="container-fluid" style="padding-top: 20px;">
            <form class="main-container" method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
                    <div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Código do usuário:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="cd_usuario" placeholder="Digite o código do usuário">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Código do usuário</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Código do funcionário:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="cd_funcionario" placeholder="Digite o código do funcionário">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Código do funcionário</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Login:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="login" placeholder="Digite o email do usuario">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Email do usuário</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Senha:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="password" id="fullname" class="form-control" name="senha" placeholder="Digite a senha do usuário">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Digite a senha do usuário</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Tipo de Usuário:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="password" id="fullname" class="form-control" name="tipo_usuario" placeholder="(1-admin | 2-comum)">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Digite o tipo de usuário</p>
                    </div>
                    </div>
					<div class="button-container">
              		<button class="btn btn-success" type="submit" name="btnCadastrar">Cadastrar</button>
            		</div>
					</form>

					<dt>
          			<!-- accordion 2 Deletar -->
          			<a href="#accordion2" aria-expanded="false" aria-controls="accordion2" class="accordion-title accordionTitle js-accordionTrigger">Deletar Usuário</a>
        			</dt>
      				<dd class="accordion-content accordionItem is-collapsed" id="accordion2" aria-hidden="true">
        			<div class="container-fluid" style="padding-top: 20px;">
          			<p class="headings">Dados do Usuário</p>
          			<form class="main-container"  method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>>
            		<div class="row">
              		<div class="col-xs-4">
                	<label for="fullname" class="label-style">Código do Usuário:</label>
              		</div>
              		<div class="form-group col-lg-4">
                	<input type="text" id="fullname" class="form-control" name="cd_usuario" placeholder="Digite o código do usuário:">
              		</div>
              		<div class="hint">
                	<i class="hint-icon">i</i>
                	<p class="hint-description">Digite o código do usuário</p>
              		</div>
            		</div>
       				</div>
        			<div class="button-container">
              			<button class="btn btn-success" type="submit" name="btnDeletar">Deletar</button>
            		</div>
      				</dd>
 					</form>

					 <dt>
         	<!-- accordion 3 Editar-->
          			<a href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="accordion-title accordionTitle js-accordionTrigger">Editar usuário</a>
        			</dt>
        			<dd class="accordion-content accordionItem is-collapsed" id="accordion3" aria-hidden="true">
       				<div class="container-fluid" style="padding-top: 20px;">
            		<form class="main-container" method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
                    <div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Código do usuário:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="cd_usuario" placeholder="Digite o código do usuário">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Código do usuário</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Código do funcionário:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="cd_funcionario" placeholder="Digite o código do funcionário">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Código do funcionário</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Login:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="login" placeholder="Digite o email do usuario">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Email do usuário</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Senha:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="password" id="fullname" class="form-control" name="senha" placeholder="Digite a senha do usuário">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Digite a senha do usuário</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Tipo de Usuário:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="tipo_usuario" placeholder="(1-admin | 2-comum)">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Digite o tipo de usuário</p>
                    </div>
                    </div>
					<div class="button-container">
              		<button class="btn btn-success" type="submit" name="btnEditar">Editar</button>
            		</div>
					</form>

					<dt>
         			<!-- accordion 4 Listar Users-->
          			<a href="#accordion4" aria-expanded="false" aria-controls="accordion4" class="accordion-title accordionTitle js-accordionTrigger">Listar usuários</a>
        			</dt>
        			<dd class="accordion-content accordionItem is-collapsed" id="accordion3" aria-hidden="true">
       				<div class="container-fluid" style="padding-top: 20px;">
					<?php 
					include 'tabela_usuario.php';
					?>
					</div>

</div><br>
<h4 style="text-align:center;">Prontuário</h4>
    	<div class="accordion">
        	<dl>
        	<!-- description list -->

        			<dt>
         			<!-- accordion 5 Cadastrar Prontuário -->
          			<a href="#accordion5" aria-expanded="false" aria-controls="accordion5" class="accordion-title accordionTitle js-accordionTrigger">Cadastrar prontuário</a>
        			</dt>
        			<dd class="accordion-content accordionItem is-collapsed" id="accordion5" aria-hidden="true">
       				<div class="container-fluid" style="padding-top: 20px;">
			   		<form class="main-container" method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
                    <div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Código do prontuário:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="cd_prontuario" placeholder="Digite o código do prontuário">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Código do prontuário</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Código da gaveta:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="cd_gaveta" placeholder="Digite o código da gaveta">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Código da gaveta</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Número do CPF:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="nr_cpf" placeholder="Digite o número do CPF">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Número CPF</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Nome do paciente:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="nm_paciente" placeholder="Digite o nome do paciente">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Nome do paciente</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Sexo do paciente:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="paciente_sexo" placeholder="M , F ou O">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Sexo do paciente</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Nome do pai:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="nm_pai" placeholder="Nome do pai">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Nome do pai</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Nome da mãe:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="nm_mae" placeholder="Nome da mãe">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Nome da mãe</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Data de nascimento:</label>
                    </div>
                    <div class="form-group col-lg-4">

                    <input type="text" id="fullname" class="form-control" name="dt_nascimento" placeholder="YYYY/mm/dd">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Ano / mês / dia</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Data de cadastro:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="dt_cadastro" placeholder="YYYY/mm/dd">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Ano / mês / dia</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Última Atualização:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="ultima_att" placeholder="YYYY/mm/dd">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Ano / mês / dia</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Situação:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="situacao" placeholder="D ou I">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Disponível <br> ou <br>Indisponível</p>
                    </div>					
                    </div>

					<div class="button-container">
              		<button class="btn btn-success" type="submit" name="btnCadastrarProntuario">Cadastrar</button>
            		</div>
					</form>

					<dt>
         			<!-- accordion 6 Deletar Prontuário -->
          			<a href="#accordion6" aria-expanded="false" aria-controls="accordion6" class="accordion-title accordionTitle js-accordionTrigger">Deletar prontuário</a>
        			</dt>
        			<dd class="accordion-content accordionItem is-collapsed" id="accordion6" aria-hidden="true">
					<div class="container-fluid" style="padding-top: 20px;">
          			<p class="headings">Dados do Prontuário</p>
          			<form class="main-container"  method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>>
            		<div class="row">
              		<div class="col-xs-4">
                	<label for="fullname" class="label-style">Código do Prontuário:</label>
              		</div>
              		<div class="form-group col-lg-4">
                	<input type="text" id="fullname" class="form-control" name="cd_prontuario" placeholder="Digite o código do prontuário:">
              		</div>
              		<div class="hint">
                	<i class="hint-icon">i</i>
                	<p class="hint-description">Digite o código do prontuário</p>
              		</div>
            		</div>
       				</div>
        			<div class="button-container">
              			<button class="btn btn-success" type="submit" name="btnDeletarProntuario">Deletar</button>
            		</div>
      				</dd>
 					</form>

					<dt>
         			<!-- accordion 7 Editar Prontuário -->
          			<a href="#accordion5" aria-expanded="false" aria-controls="accordion7" class="accordion-title accordionTitle js-accordionTrigger">Editar prontuário</a>
        			</dt>
        			<dd class="accordion-content accordionItem is-collapsed" id="accordion7" aria-hidden="true">
       				<div class="container-fluid" style="padding-top: 20px;">
					<h5><center>Obs:. Apenas os dados informados serão atualizados</center></h5>
					<h7><center>O único dado obrigatório é o código do prontuário</center></h7>
			   		<form class="main-container" method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
                    <div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Código do prontuário:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="cd_prontuario" placeholder="Digite o código do prontuário">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Código do prontuário</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Código da gaveta:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="cd_gaveta" placeholder="Digite o código da gaveta">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Código da gaveta</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Número do CPF:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="nr_cpf" placeholder="Digite o número do CPF">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Número CPF</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Nome do paciente:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="nm_paciente" placeholder="Digite o nome do paciente">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Nome do paciente</p>
                    </div>
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Sexo do paciente:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="paciente_sexo" placeholder="M , F ou O">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Sexo do paciente</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Nome do pai:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="nm_pai" placeholder="Nome do pai">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Nome do pai</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Nome da mãe:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="nm_mae" placeholder="Nome da mãe">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Nome da mãe</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Data de nascimento:</label>
                    </div>
                    <div class="form-group col-lg-4">

                    <input type="text" id="fullname" class="form-control" name="dt_nascimento" placeholder="YYYY/mm/dd">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Ano / mês / dia</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Data de cadastro:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="dt_cadastro" placeholder="YYYY/mm/dd">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Ano / mês / dia</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Última Atualização:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="ultima_att" placeholder="YYYY/mm/dd">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Ano / mês / dia</p>
                    </div>					
                    </div>

					<div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Situação:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="situacao" placeholder="D ou I">
                    </div>
                    <div class="hint">
                    <i class="hint-icon">i</i>
                    <p class="hint-description">Disponível <br> ou <br>Indisponível</p>
                    </div>					
                    </div>

					<div class="button-container">
              		<button class="btn btn-success" type="submit" name="btnEditarProntuario">Editar</button>
            		</div>
					</form>


					<dt>
         			<!-- accordion 8 Listar Movimentos do Prontuário -->
          			<a href="#accordion8" aria-expanded="false" aria-controls="accordion8" class="accordion-title accordionTitle js-accordionTrigger">Listar movimentos do prontuário</a>
        			</dt>
        			<dd class="accordion-content accordionItem is-collapsed" id="accordion8" aria-hidden="true">
       				<div class="container-fluid" style="padding-top: 20px;">
					<form class="main-container" method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
                    <div class="row">
                    <div class="col-xs-4">
                    <label for="fullname" class="label-style">Código do prontuário:</label>
                    </div>
                    <div class="form-group col-lg-4">
                    <input type="text" id="fullname" class="form-control" name="cd_prontuario" placeholder="Digite o código do prontuário">
                    </div>

					<div class="button-container">
              		<button class="btn btn-success" type="submit" name="btnBuscarProntuario">Buscar</button>
            		</div>

					<?php 
					if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
						if(isset($_POST['btnBuscarProntuario'])){
							$cd_prontuario = $_POST["cd_prontuario"];
							$dadosbd = new Usuario();
							$bd = new BD();
							$conn = $bd->getConnection();
							try{
								$sql = 'SELECT * from movimentos WHERE cd_prontuario = :cd_prontuario';
								$query = $conn->prepare($sql);
								$query->bindParam(":cd_prontuario" , $cd_prontuario);
								$query->execute();
								echo"<table>
								<tr>
								<th>cd_movimento:</th>
								<th>cd_prontuario:</th> 
								<th>cd_funcionario_origem:</th>
								<th>cd_funcionario_destino:</th>
								<th>dt_saida:</th> 
								<th>dt_volta:</th> 
								<th>motivo:</th> 
								<th>situacao:</th> 
								</tr>";
								while($dados = $query->fetch(PDO::FETCH_ASSOC)){
									$cd_movimento = $dados["cd_movimentos"];
									$cd_prontuario = $dados["cd_prontuario"];
									$cd_funcionario_origem = $dados["cd_funcionario_origem"];
									$cd_funcionario_destino = $dados["cd_funcionario_destino"];
									$dt_saida = $dados["dt_saida"];
									$dt_volta = $dados["dt_volta"];
									$motivo = $dados["motivo"];
									$situacao = $dados["situacao"];
									echo "<tr><td>$cd_movimento</td><td>$cd_prontuario</td><td>$cd_funcionario_origem</td><td>$cd_funcionario_destino</td><td>$dt_saida</td><td>$dt_volta</td><td>$motivo</td><td>$situacao</td></tr>";
								}
								echo"</table>";
							}catch(PDOException $ex){
								echo 'Erro: ' .$ex->getMessage();
							}
						}
					}
					?>
                    </div>
                    </div>
					</form>
					<dt>
         			<!-- accordion 9 Listar Todos Prontuários do Sistema -->
          			<a href="#accordion9" aria-expanded="false" aria-controls="accordion9" class="accordion-title accordionTitle js-accordionTrigger">Listar prontuários</a>
        			</dt>
        			<dd class="accordion-content accordionItem is-collapsed" id="accordion9" aria-hidden="true">
       				<div class="container-fluid" style="padding-top: 20px;">
					<?php 
					$bd = new BD();
					$conn = $bd->getConnection();
					try{
					$sql = 'SELECT * from prontuario';
					$query = $conn->prepare($sql);
					$query->execute();
					echo"<table>
					<tr>
					<th>cd_prontuario:</th>
					<th>cd_gaveta:</th> 
					<th>nr_cpf:</th>
					<th>nm_paciente:</th>
					<th>nm_pai:</th> 
					<th>nm_mae:</th> 
					<th>dt_nascimento:</th> 
					<th>dt_cadastro:</th> 
					<th>ultima_att:</th>
					<th>situacao:</th>
					</tr>";
					while($dados = $query->fetch(PDO::FETCH_ASSOC)){
						$cd_prontuario = $dados["cd_prontuario"];
						$cd_gaveta = $dados["cd_gaveta"];
						$nr_cpf = $dados["nr_cpf"];
						$nm_paciente = $dados["nm_paciente"];
						$nm_pai = $dados["nm_pai"];
						$nm_mae = $dados["nm_mae"];
						$dt_nascimento = $dados["dt_nascimento"];
						$dt_cadastro = $dados["dt_cadastro"];
						$ultima_att =  $dados["ultima_att"];
						$situacao = $dados["situacao"];
						echo "<tr><td>$cd_prontuario</td><td>$cd_gaveta</td><td>$nr_cpf</td><td>$nm_paciente</td><td>$nm_pai</td><td>$nm_mae</td><td>$dt_nascimento</td><td>$dt_cadastro</td><td>$ultima_att</td><td>$situacao</td></tr>";
					}
					echo"</table>";
					}catch(PDOException $ex){
						echo 'Erro: ' .$ex->getMessage();
					}
					?>
					</div>
  
<!--
<button class="accordion">Deletar Usuario</button>
	<div class="panel">
		<form method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
  			<label>Insira o cd_usuario</label>
			<input type="text" class="form-control" name="cd_usuario" placeholder="cd_usuario">
			<input type="submit" name="btnDeletar" value="Deletar">
		</form><br>
	</div>
<button class="accordion">Editar Usuario</button>
	<div class="panel">
		<form method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
					<label>cd_usuario</label>
					<input type="text" name="cd_usuario" placeholder="Digite o cd_usuario"><br><br>
			
					<label>cd_funcionario</label>
					<input type="text" name="cd_funcionario" placeholder="Digite o cd_funcionario"><br><br>
			
					<label>login</label>
					<input type="text" name="login" placeholder="Digite o email do usuario"><br><br>

					<label>senha</label>
					<input type="password" name="senha" placeholder="Digite a senha do usuário"><br><br>

					<label>tipo usuario</label>
					<input type="text" name="tipo_usuario" placeholder="(1-admin | 2-comum)"><br><br>
			<input type="submit" name="btnEditar" value="Editar">
		</form><br>
	</div>
<button class="accordion">Buscar por cd_funcionário</button>
	<div class="panel">
		<form method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
  			<label>Insira o cd_usuario</label>
			<input type="text" class="form-control" name="cd_usuario" placeholder="cd_usuario">
			<input type="submit" name="btnBuscar" value="Buscar">
		</form><br>
	</div>

<button class="accordion">Listar todos os usuário</button>
<div class="panel"><br>
<?php 
/*
include 'tabela_usuario.php';
?>
</div>
<h3>Prontuário</h3>
<button class="accordion">Cadastrar Prontuário</button>
<div class="panel">
 <form method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
					<label>cd_prontuario</label>
					<input type="text" name="cd_usuario" placeholder="Digite o código do prontuário"><br><br>
			
					<label>cd_gaveta</label>
					<input type="text" name="cd_gaveta" placeholder="Digite o código da gaveta"><br><br>
			
					<label>nr_cpf</label>
					<input type="text" name="nr_cpf" placeholder="Digite o número do CPF"><br><br>

					<label>nm_paciente</label>
					<input type="text" name="nm_paciente" placeholder="Nome do paciente"><br><br>

					<label>paciente_sexo</label>
					<input type="text" name="paciente_sexo" placeholder="Sexo do paciente"><br><br>

					<label>nm_pai</label>
					<input type="text" name="nm_pai" placeholder="Nome do Pai"><br><br>

					<label>nm_mae</label>
					<input type="text" name="nm_mae" placeholder="Nome da Mãe"><br><br>

					<label>dt_nascimento</label>
					<input type="text" name="dt_nascimento" placeholder="Data de Nascimento"><br><br>

					<label>dt_cadastro</label>
					<input type="text" name="dt_cadastro" placeholder="Data de cadastro"><br><br>

					<label>ultima_att</label>
					<input type="text" name="ultima_att" placeholder="Última atualização"><br><br>

					<label>situacao</label>
					<input type="text" name="situacao" placeholder="disponível ou indisponível"><br><br>

					<input type="submit" name="btnCadastrarProntuario" value="Cadastrar">
 </form>
</div><br>
<button class="accordion">Deletar Prontuário</button>
	<div class="panel">
		<form method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
  			<label>Insira o código do prontuário</label>
			<input type="text" class="form-control" name="cd_prontuario" placeholder="Código de Prontuário">
			<input type="submit" name="btnDeletarProntuario" value="Deletar">
		</form><br>
</div>
<button class="accordion">Editar Prontuário</button>
<div class="panel">
 <form method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
					<label>cd_prontuario</label>
					<input type="text" name="cd_prontuario" placeholder="Digite o código do prontuário"><br><br>
			
					<label>cd_gaveta</label>
					<input type="text" name="cd_gaveta" placeholder="Digite o código da gaveta"><br><br>
			
					<label>nr_cpf</label>
					<input type="text" name="nr_cpf" placeholder="Digite o número do CPF"><br><br>

					<label>nm_paciente</label>
					<input type="text" name="nm_paciente" placeholder="Nome do paciente"><br><br>

					<label>paciente_sexo</label>
					<input type="text" name="paciente_sexo" placeholder="Sexo do paciente"><br><br>

					<label>nm_pai</label>
					<input type="text" name="nm_pai" placeholder="Nome do Pai"><br><br>

					<label>nm_mae</label>
					<input type="text" name="nm_mae" placeholder="Nome da Mãe"><br><br>

					<label>dt_nascimento</label>
					<input type="text" name="dt_nascimento" placeholder="Data de Nascimento"><br><br>

					<label>dt_cadastro</label>
					<input type="text" name="dt_cadastro" placeholder="Data de cadastro"><br><br>

					<label>ultima_att</label>
					<input type="text" name="ultima_att" placeholder="Última atualização"><br><br>

					<label>situacao</label>
					<input type="text" name="situacao" placeholder="disponível ou indisponível"><br><br>

					<input type="submit" name="btnEditarProntuario" value="Editar">
 </form>
</div><br>
<button class="accordion">Buscar movimentação por cd_prontuario</button>
					<div class="panel">
					<form method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
  					<label>Insira o cd_prontuario</label>
					<input type="text" class="form-control" name="cd_prontuario" placeholder="Insira o cd_prontuario">
					<input type="submit" name="btnBuscarProntuario" value="Buscar">
					</form><br>
					<?php 
					if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
						if(isset($_POST['btnBuscarProntuario'])){
							$cd_prontuario = $_POST["cd_prontuario"];
							$dadosbd = new Usuario();
							$bd = new BD();
							$conn = $bd->getConnection();
							try{
								$sql = 'SELECT * from movimentos WHERE cd_prontuario = :cd_prontuario';
								$query = $conn->prepare($sql);
								$query->bindParam(":cd_prontuario" , $cd_prontuario);
								$query->execute();
								echo"<table>
								<tr>
								<th>cd_movimento:</th>
								<th>cd_prontuario:</th> 
								<th>cd_funcionario_origem:</th>
								<th>cd_funcionario_destino:</th>
								<th>dt_saida:</th> 
								<th>dt_volta:</th> 
								<th>motivo:</th> 
								<th>situacao:</th> 
								</tr>";
								while($dados = $query->fetch(PDO::FETCH_ASSOC)){
									$cd_movimento = $dados["cd_movimentos"];
									$cd_prontuario = $dados["cd_prontuario"];
									$cd_funcionario_origem = $dados["cd_funcionario_origem"];
									$cd_funcionario_destino = $dados["cd_funcionario_destino"];
									$dt_saida = $dados["dt_saida"];
									$dt_volta = $dados["dt_volta"];
									$motivo = $dados["motivo"];
									$situacao = $dados["situacao"];
									echo "<tr><td>$cd_movimento</td><td>$cd_prontuario</td><td>$cd_funcionario_origem</td><td>$cd_funcionario_destino</td><td>$dt_saida</td><td>$dt_volta</td><td>$motivo</td><td>$situacao</td></tr>";
								}
								echo"</table>";
							}catch(PDOException $ex){
								echo 'Erro: ' .$ex->getMessage();
							}
						}
					}
		*/?>
	-->
	</div>
<script>
//uses classList, setAttribute, and querySelectorAll
//if you want this to work in IE8/9 youll need to polyfill these
(function() {
  var d = document,
    accordionToggles = d.querySelectorAll('.js-accordionTrigger'),
    setAria,
    setAccordionAria,
    switchAccordion,
    touchSupported = ('ontouchstart' in window),
    pointerSupported = ('pointerdown' in window);

  skipClickDelay = function(e) {
    e.preventDefault();
    e.target.click();
  }

  setAriaAttr = function(el, ariaType, newProperty) {
    el.setAttribute(ariaType, newProperty);
  };
  setAccordionAria = function(el1, el2, expanded) {
    switch (expanded) {
      case "true":
        setAriaAttr(el1, 'aria-expanded', 'true');
        setAriaAttr(el2, 'aria-hidden', 'false');
        break;
      case "false":
        setAriaAttr(el1, 'aria-expanded', 'false');
        setAriaAttr(el2, 'aria-hidden', 'true');
        break;
      default:
        break;
    }
  };
  //function
  switchAccordion = function(e) {
    e.preventDefault();
    var thisAnswer = e.target.parentNode.nextElementSibling;
    var thisQuestion = e.target;
    if (thisAnswer.classList.contains('is-collapsed')) {
      setAccordionAria(thisQuestion, thisAnswer, 'true');
    } else {
      setAccordionAria(thisQuestion, thisAnswer, 'false');
    }
    thisQuestion.classList.toggle('is-collapsed');
    thisQuestion.classList.toggle('is-expanded');
    thisAnswer.classList.toggle('is-collapsed');
    thisAnswer.classList.toggle('is-expanded');

    thisAnswer.classList.toggle('animateIn');
  };
  for (var i = 0, len = accordionToggles.length; i < len; i++) {
    if (touchSupported) {
      accordionToggles[i].addEventListener('touchstart', skipClickDelay, false);
    }
    if (pointerSupported) {
      accordionToggles[i].addEventListener('pointerdown', skipClickDelay, false);
    }
    accordionToggles[i].addEventListener('click', switchAccordion, false);
  }
})();
</script>
</body>
</html>


