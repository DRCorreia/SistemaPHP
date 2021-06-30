<?php

class Funcionario{
    private $cd_funcionario;
    private $nm_funcionario;
    private $email;

    public function getCd_funcionario(){
        return $this->cd_funcionario;
    }

    public function setCd_funcionario($cd_funcionario){
        $this->cd_funcionario = $cd_funcionario;
    }

    public function getNm_funcionario(){
        return $this->nm_funcionario;
    }

    public function setLogin($nm_funcionario){
        $this->nm_funcionario = $nm_funcionario;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
}