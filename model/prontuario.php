<?php

class Prontuario{
    private $cd_prontuario;
    private $cd_gaveta;
    private $nr_cpf;
    private $nm_paciente;
    private $paciente_sexo;
    private $nm_pai;
    private $nm_mae;
    private $dt_nascimento;
    private $dt_cadastro;
    private $ultima_att;
    private $situacao;

    public function getCd_prontuario(){
        return $this->cd_prontuario;
    }
    public function setCd_prontuario($cd_prontuario){
        $this->cd_prontuario = $cd_prontuario;
    }

    public function getCd_gaveta(){
        return $this->cd_gaveta;
    }
    public function setCd_gaveta($cd_gaveta){
        $this->cd_gaveta = $cd_gaveta;
    }

    public function getNr_cpf(){
        return $this->nr_cpf;
    }
    public function setNr_cpf($nr_cpf){
        $this->nr_cpf = $nr_cpf;
    }

    public function getNm_paciente(){
        return $this->nm_paciente;
    }
    public function setNm_paciente($nm_paciente){
        $this->nm_paciente = $nm_paciente;
    }

    public function getPaciente_sexo(){
        return $this->paciente_sexo;
    }
    public function setPaciente_sexo($paciente_sexo){
        $this->paciente_sexo = $paciente_sexo;
    }

    public function getNm_pai(){
        return $this->nm_pai;
    }
    public function setNm_pai($nm_pai){
        $this->nm_pai = $nm_pai;
    }

    public function getNm_mae(){
        return $this->nm_mae;
    }
    public function setNm_mae($nm_mae){
        $this->nm_mae = $nm_mae;
    }

    public function getDt_nascimento(){
        return $this->dt_nascimento;
    }
    public function setDt_nascimento($dt_nascimento){
        $this->dt_nascimento = $dt_nascimento;
    }

    public function getDt_cadastro(){
        return $this->dt_cadastro;
    }
    public function setDt_cadastro($dt_cadastro){
        $this->dt_cadastro = $dt_cadastro;
    }

    public function getUltima_att(){
        return $this->ultima_att;
    }
    public function setUltima_att($ultima_att){
        $this->ultima_att = $ultima_att;
    }

    public function getSituacao(){
        return $this->situacao;
    }
    public function setSituacao($situacao){
        $this->situacao = $situacao;
    }
}