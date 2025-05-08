<?php

class Usu {

    private $id;
    private $nome;
    private $telefone;
    private $email;
    private $senha;
    private $funcao;

    public function __construct($nome = null, $telefone = null, $email = null, $senha = null, $funcao = null) {
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->senha = $senha;
        $this->funcao = $funcao;
    }

        public function setId($id){
            $this->id = $id;
        }
        public function setNome($nome){
            $this->nome = $nome;
        }
        public function setTelefone($telefone){
            $this->telefone = $telefone;
        }
        public function setEmail($email){
            $this->email = $email;
        }
        public function setSenha($senha){
            $this->senha = $senha;
        }
        public function setFuncao($funcao){
            $this->funcao = $funcao;
        }
        
        public function getId(){
            return $this->id;
        }
        
        public function getNome(){
            return $this->nome;
        }
        
        public function getTelefone(){
            return $this->telefone;
        }
        
        public function getEmail(){
            return $this->email;
        }
        
        public function getSenha(){
            return $this->senha;
        }
        
        public function getFuncao(){
            return $this->funcao;
        }

      }

?>
