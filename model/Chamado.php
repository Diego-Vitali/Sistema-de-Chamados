<?php

class Chamado {
    private $cod;
    private $cliente;
    private $descricao;
    private $status;
    private $categoria;
    private $telefonePrincipal;
    private $dataCriacao;

    public function __construct($cliente, $descricao, $status, $categoria, $telefonePrincipal, $dataCriacao) {
        $this->cliente = $cliente;
        $this->descricao = $descricao;
        $this->status = $status;
        $this->categoria = $categoria;
        $this->telefonePrincipal = $telefonePrincipal;
        $this->dataCriacao = $dataCriacao;
    }

    public function getCod() {
        return $this->cod;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getTelefonePrincipal() {
        return $this->telefonePrincipal;
    }

    public function getDataCriacao() {
        return $this->dataCriacao;
    }
    public function setCod($cod) {
        $this->cod = $cod;
    }

    public function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function setTelefonePrincipal($telefonePrincipal) {
        $this->telefonePrincipal = $telefonePrincipal;
    }

    public function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }
}

?>
