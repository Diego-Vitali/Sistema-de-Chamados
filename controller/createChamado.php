<?php

require_once('../factory/Conex.php');
require_once('../model/Chamado.php');

if (!isset($_SESSION)) {
    session_start();
}

$conn = new Conex();

$query = "SELECT id FROM tbusu WHERE nome = :nome";
        $busca = $conn->getConn()->prepare($query);
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

$chamado = new Chamado(
    $idCliente,    
    $_POST['cxDescricao'],
    $_POST['cxStatus'],
    $_POST['cxCategoria'],
    $_POST['cxTelefonePrincipal'],
    $_POST['cxDataCriacao']
);

$idCliente = $chamado->getCliente();
$descricao = $chamado->getDescricao();
$status = $chamado->getStatus();
$categoria = $chamado->getCategoria();
$telefonePrincipal = $chamado->getTelefonePrincipal();
$dataCriacao = $chamado->getDataCriacao();

$query = "INSERT INTO tbchamado (idcliente, descricao, statusChamado, categoria, telefoneContato, dataCriacao) 
          VALUES (:cliente, :descricao, :status, :categoria, :telefonePrincipal, :dataCriacao)";

$cadastrar = $conn->getConn()->prepare($query);

$cadastrar->bindParam(':cliente', $idCliente, PDO::PARAM_STR);
$cadastrar->bindParam(':descricao', $descricao, PDO::PARAM_STR);
$cadastrar->bindParam(':status', $status, PDO::PARAM_STR);
$cadastrar->bindParam(':categoria', $categoria, PDO::PARAM_STR);
$cadastrar->bindParam(':telefonePrincipal', $telefonePrincipal, PDO::PARAM_STR);
$cadastrar->bindParam(':dataCriacao', $dataCriacao, PDO::PARAM_STR);

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