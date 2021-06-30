<?php

class Gaveta{
    private $cd_gaveta;
    private $cd_armario;
    private $ds_gaveta;

    public function getCd_gaveta(){
        return $this->cd_gaveta;
    }

    public function setCd_gaveta($cd_gaveta){
        $this->cd_gaveta = $cd_gaveta;
    }

    public function getCd_armario(){
        return $this->cd_armario;
    }

    public function setCd_armario($cd_armario){
        $this->cd_armario = $cd_armario;
    }


    public function getDs_prateleira(){
        return $this->ds_prateleira;
    }

    public function setDs_gaveta($ds_gaveta){
        $this->ds_gaveta = $ds_gaveta;
    }
}