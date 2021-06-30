<?php

include_once 'C:\xampp\htdocs\tcc\model\usuario.php';
include_once 'C:\xampp\htdocs\tcc\dao\daousuario.php';

class UsuarioController{
    public function inserirUsuario(Usuario $usuario){
        try {
          $dao = new DaoUsuario();
          return $dao->inserirUsuario($usuario);
        } catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
     }
    }
     public function editarUsuario(Usuario $usuario){
         try{
             $dao = new DaoUsuario();
             return $dao->editarUsuario($usuario);
         } catch(PDOException $ex){
             echo 'Erro:' .$ex->getMessage();
         }
     }

     public function deletarUsuario(Usuario $usuario){
         try{
             $dao = new DaoUsuario();
             return $dao->deletarUsuario($usuario);
         } catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
     }
    }

     public function BuscarUsuarioPorID(Usuario $usuario){
         try{
             $dao = new DaoUsuario();
             return $dao->BuscarUsuarioPorID($usuario);
         }  catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
     }
    }

    public function validarUsuario(Usuario $usuario){
        try{
            $dao = new DaoUsuario();
            return $dao->validarUsuario($usuario);
        }   catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
        }
    }

    public function listarTodosUsuarios(){
        try{
            $dao = new DaoUsuario();
            return $dao->listarTodosUsuarios();
        }   catch(PDOException $ex){
            echo 'Erro: ' .$ex->getMessage();
        }
    }
}
?>
