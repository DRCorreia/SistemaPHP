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


$cd_prontuario = $_GET["cd_prontuario"];
$trocadata= $_GET["trocadata"];
$prontuario=new Prontuario();
$prontuario->setCd_prontuario($cd_prontuario);
$prontuariocontroller = new ProntuarioController();
$prontuariocontroller->atualizarProntuario($prontuario,$trocadata);
?>