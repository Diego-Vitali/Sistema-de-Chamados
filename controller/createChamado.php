<?php

// Aqui é feita as requisições para conexão com banco e criação da Classe Usu
require_once('../factory/Conex.php');
require_once('../model/Chamado.php');

// Inicia sessão
if (!isset($_SESSION)) {
    session_start();
}

// conn -> cria conexão com banco de dados
$conn = new Conex();

// Esse Select vai acontecer antes da criação do Chamado para ter CERTEZA que o usuário existe antes de tentar criar um chamado.
$query = "SELECT id FROM tbusu WHERE nome = :nome";
        $busca = $conn->getConn()->prepare($query);
        // Já substitui o :nome pelo nome no POST
        $busca->bindParam(':nome', $_POST['cxCliente'], PDO::PARAM_STR);
        $busca->execute();
        $result = $busca->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            echo "<script>
                alert('Cliente não encontrado!');
                window.location.href = '../view/cadChamado.php';
            </script>";
            exit;
        }
        $idCliente = $result['id'];

// Mesma lógica do usu
$chamado = new Chamado(
    $idCliente,    
    $_POST['cxDescricao'],
    $_POST['cxStatus'],
    $_POST['cxCategoria'],
    $_POST['cxTelefonePrincipal'],
    $_POST['cxDataCriacao']
);

$query = "INSERT INTO tbchamado (idcliente, descricao, statusChamado, categoria, telefoneContato, dataCriacao) 
          VALUES (:cliente, :descricao, :status, :categoria, :telefonePrincipal, :dataCriacao)";

$cadastrar = $conn->getConn()->prepare($query);

$cadastrar->bindParam(':cliente', $chamado->getCliente(), PDO::PARAM_STR);
$cadastrar->bindParam(':descricao', $chamado->getDescricao(), PDO::PARAM_STR);
$cadastrar->bindParam(':status', $chamado->getStatus(), PDO::PARAM_STR);
$cadastrar->bindParam(':categoria', $chamado->getCategoria(), PDO::PARAM_STR);
$cadastrar->bindParam(':telefonePrincipal', $chamado->getTelefonePrincipal(), PDO::PARAM_STR);
$cadastrar->bindParam(':dataCriacao', $chamado->getDataCriacao(), PDO::PARAM_STR);

$cadastrar->execute();

if ($cadastrar->rowCount()) {
    echo "<script>
        alert('Chamado Criado com Sucesso!');
        window.location.href = '../view/cadChamado.php';
    </script>";
} else {
    echo "<script>
        alert('Erro Ao Criar Chamado!');
        window.location.href = '../view/telaRegistroChamado.php';
    </script>";
}

?>