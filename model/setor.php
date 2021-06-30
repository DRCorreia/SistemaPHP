<?php

class Setor{
    private $cd_funcionario;
    private $nm_funcionario;

    public function getCd_funcionario(){
        return $this->cd_funcionario;
    }

    public function setCd_funcionario($cd_funcionario){
        $this->cd_funcionario = $cd_funcionario;
    }

    public function getDt_ini(){
        return $this->dt_ini;
    }

    public function setDt_ini($dt_ini){
        $this->dt_ini = $dt_ini;
    }
    
}