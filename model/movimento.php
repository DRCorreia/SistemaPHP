<?php

class Movimento{
    private $cd_movimento;
    private $cd_prontuario;
    private $cd_funcionario_origem;
    private $cd_funcionario_destino;
    private $dt_saida;
    private $dt_volta;
    private $motivo;
    private $situacao;

    public function getCd_movimento(){
        return $this->cd_movimento;
    }
    public function setCd_movimento($cd_movimento){
        $this->cd_movimento = $cd_movimento;
    }

    public function getCd_prontuario(){
        return $this->cd_prontuario;
    }
    public function setCd_prontuario($cd_prontuario){
        $this->cd_prontuario = $cd_prontuario;
    }

    public function getCd_funcionario_origem(){
        return $this->cd_funcionario_origem;
    }
    public function setCd_funcionario_origem($cd_funcionario_origem){
        $this->cd_funcionario_origem = $cd_funcionario_origem;
    }

    public function getCd_funcionario_destino(){
        return $this->cd_funcionario_destino;
    }
    public function setCd_funcionario_destino($cd_funcionario_destino){
        $this->cd_funcionario_destino = $cd_funcionario_destino;
    }

    public function getDt_saida(){
        return $this->dt_saida;
    }
    public function setDt_saida($dt_saida){
        $this->dt_saida = $dt_saida;
    }

    public function getDt_volta(){
        return $this->dt_volta;
    }
    public function setDt_volta($dt_volta){
        $this->dt_volta = $dt_volta;
    }

    public function getMotivo(){
        return $this->motivo;
    }
    public function setMotivo($motivo){
        $this->motivo = $motivo;
    }

    public function getSituacao(){
        return $this->situacao;
    }
    public function setSituacao($situacao){
        $this->situacao = $situacao;
    }
}