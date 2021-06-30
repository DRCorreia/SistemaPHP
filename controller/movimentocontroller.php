<?php

include_once 'C:\xampp\htdocs\tcc\model\movimento.php';
include_once 'C:\xampp\htdocs\tcc\model\prontuario.php';
include_once 'C:\xampp\htdocs\tcc\model\funcionario.php';
include_once 'C:\xampp\htdocs\tcc\dao\daomovimento.php';


class MovimentoController{
    public function inserirMovimento(Movimento $movimento, Prontuario $prontuario){
        try {
          $dao = new DaoMovimento();
          return $dao->inserirMovimento($movimento, $prontuario);
        } catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
     }
    }

    public function inativarMovimento(Movimento $movimento){
        try {
          $dao = new DaoMovimento();
          return $dao->inativarMovimento($movimento);
        } catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
     }
    }

    public function listarTodosMovimentos(Funcionario $funcionario){
        try{
            $dao = new DaoMovimento();
            return $dao->listarTodosMovimentos($funcionario);
            echo $funcionario->getEmail();
        }   catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
        }
    }

public function trocarMovimentoEmail(int $cd_prontuario, string $emailorigem, string $emaildestino){
    try {
      $dao = new DaoMovimento();
      return $dao->trocarMovimentoEmail($cd_prontuario,$emailorigem,$emaildestino);
    } catch(PDOException $ex){
        echo 'Erro: ' .$ex->getMessage();
  }
 }
 public function recusaTroca(int $cd_prontuario, string $emailorigem, string $emaildestino){
    try {
      $dao = new DaoMovimento();
      return $dao->recusaTroca($cd_prontuario,$emailorigem,$emaildestino);
    } catch(PDOException $ex){
        echo 'Erro: ' .$ex->getMessage();
  }
 }
}

    