<?php

class Usuario{
    private $cd_usuario;
    private $cd_funcionario;
    private $login;
    private $senha;
    private $tipo_usuario;

    public function getCd_Usuario(){
        return $this->cd_usuario;
    }

    public function setCd_usuario($cd_usuario){
        $this->cd_usuario = $cd_usuario;
    }

    public function getCd_funcionario(){
        return $this->cd_funcionario;
    }

    public function setCd_funcionario($cd_funcionario){
        $this->cd_funcionario = $cd_funcionario;
    }

    public function getLogin(){
        return $this->login;
    }

    public function setLogin($login){
        $this->login = $login;
    }
    
    public function getSenha(){
        return $this-> senha;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function getTipo_usuario(){
        return $this->tipo_usuario;
    }

    public function setTipo_usuario($tipo_usuario){
        $this->tipo_usuario = $tipo_usuario;
    }
}