<?php

class Alocacao{
    private $cd_funcionario;
    private $dt_ini;
    private $dt_fim;

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

    public function getDt_fim(){
        return $this->dt_fim;
    }

    public function setDt_fim($dt_fim){
        $this->dt_fim = $dt_fim;
    }
}