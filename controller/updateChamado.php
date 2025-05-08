<?php

require_once('../factory/Conex.php');
require_once('../model/Chamado.php');

$conn = new Conex();

$query = "UPDATE tbchamado SET idCliente = :idCliente, descricao = :descricao, statusChamado = :statusChamado, categoria = :categoria, telefoneContato = :telefoneContato WHERE cod = :cod";

$clienteQuery = "SELECT id FROM tbUsu WHERE nome = :nomeCliente";
$buscaCliente = $conn->getConn()->prepare($clienteQuery);
$buscaCliente->bindParam(':nomeCliente', $_POST['cxCliente'], PDO::PARAM_STR);
$buscaCliente->execute();

$idCliente = $buscaCliente->fetchColumn();

if ($idCliente) {
    $update = $conn->getConn()->prepare($query);
    $update->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
    $update->bindParam(':descricao', $_POST['cxDescricao'], PDO::PARAM_STR);
    $update->bindParam(':statusChamado', $_POST['cxStatus'], PDO::PARAM_STR);
    $update->bindParam(':categoria', $_POST['cxCategoria'], PDO::PARAM_STR);
    $update->bindParam(':telefoneContato', $_POST['cxTelefonePontato'], PDO::PARAM_STR);
    $update->bindParam(':cod', $_POST['cxCod'], PDO::PARAM_INT);
    $update->execute();

} else {
    echo "<script>
        alert('Cliente não encontrado!');
        window.location.href = '../view/cadChamado.php';
    </script>";
    exit;
}

if ($update->rowCount()) {
    echo "<script>
        alert('Chamado Atualizado com Sucesso!');
        window.location.href = '../view/cadChamado.php';
    </script>";
} else {
    echo "<script>
        alert('Erro Ao Atualizar Chamado!');
        window.location.href = '../view/cadChamado.php';
    </script>";
}
?>