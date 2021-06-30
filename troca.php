<?php
include_once 'C:\xampp\htdocs\tcc\model\usuario.php';
include_once 'C:\xampp\htdocs\tcc\model\movimento.php';
include_once 'C:\xampp\htdocs\tcc\model\prontuario.php';
include_once 'C:\xampp\htdocs\tcc\dao\daousuario.php';
include_once 'C:\xampp\htdocs\tcc\dao\daomovimento.php';
include_once 'C:\xampp\htdocs\tcc\dao\daoprontuario.php';
include_once 'C:\xampp\htdocs\tcc\database\conexao.php';
include_once 'C:\xampp\htdocs\tcc\controller\usuariocontroller.php';
include_once 'C:\xampp\htdocs\tcc\controller\movimentocontroller.php';
include_once 'C:\xampp\htdocs\tcc\controller\prontuariocontroller.php';
include_once 'C:\xampp\htdocs\tcc\envia_mail.php';


$troca = $_GET["troca"];
$cd_prontuario = $_GET["cd_prontuario"];
$emailorigem = $_GET["emailorigem"];
$emaildestino = $_GET["emaildestino"];

if($troca == 0){
    $email = new Email();
    $email->recusaEmail($emailorigem, $emaildestino);
    $movimentocontroller = new MovimentoController();
    $movimentocontroller->recusaTroca($cd_prontuario,$emailorigem,$emaildestino);
    exit;
}
else if($troca == 1){
$movimentocontroller = new MovimentoController();
$movimentocontroller->trocarMovimentoEmail($cd_prontuario,$emailorigem,$emaildestino);
}
?>