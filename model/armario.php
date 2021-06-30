<?php

class Armario{
    private $cd_armario;
    private $ds_sala;
    private $ds_prateleira;

    public function getCd_armario(){
        return $this->cd_armario;
    }

    public function setCd_armario($cd_armario){
        $this->cd_armario = $cd_armario;
    }

    public function getDs_sala(){
        return $this->ds_sala;
    }

    public function setDs_sala($ds_sala){
        $this->ds_sala = $ds_sala;
    }

    public function getDs_prateleira(){
        return $this->ds_prateleira;
    }

    public function setDs_prateleira($ds_prateleira){
        $this->ds_prateleira = $ds_prateleira;
    }
}