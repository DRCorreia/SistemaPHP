<?php

include_once 'C:\xampp\htdocs\tcc\model\movimento.php';
include_once 'C:\xampp\htdocs\tcc\model\prontuario.php';
include_once 'C:\xampp\htdocs\tcc\dao\daoprontuario.php';

class ProntuarioController{
    public function baixarProntuario(Prontuario $prontuario, int $trocadata){
        try {
          $dao = new DaoProntuario();
          return $dao->baixarProntuario($prontuario,$trocadata);
        } catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
     }
    }

    public function atualizarProntuario(Prontuario $prontuario, $trocadata){
        try {
          $dao = new DaoProntuario();
          return $dao->atualizarProntuario($prontuario,$trocadata);
        } catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
     }
    }

    public function inserirProntuario($prontuario){
      try {
        $dao = new DaoProntuario();
        return $dao->inserirProntuario($prontuario);
      } catch(PDOException $ex){
          echo 'Erro: ' .$ex->getMessage();
   }
  }
      public function deletarProntuario(Prontuario $prontuario){
        try{
         $dao = new DaoProntuario();
         return $dao->deletarProntuario($prontuario);
      }catch(PDOException $ex){
        echo 'Erro: ' .$ex->getMessage();
      }
    }

    public function editarProntuario(Prontuario $prontuario){
      try{
       $dao = new DaoProntuario();
       return $dao->editarProntuario($prontuario);
    }catch(PDOException $ex){
      echo 'Erro: ' .$ex->getMessage();
    }
  }
}