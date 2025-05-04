<?php

require_once('../factory/Conex.php');
require_once('../model/Chamado.php');


$conn = new Conex();

$query = "DELETE FROM tbchamado WHERE cod = :cod";
$deletar = $conn->getConn()->prepare($query);
$deletar->bindParam(':cod', $_GET['cod'], PDO::PARAM_INT);
$deletar->execute();

if ($deletar->rowCount()) {
    echo "<script>
        alert('Chamado Deletado com Sucesso!');
        window.location.href = '../view/cadChamado.php';
    </script>";
} else {
    echo "<script>
        alert('Erro Ao Deletar Chamado!');
        window.location.href = '../view/cadChamado.php';
    </script>";
}
?>
