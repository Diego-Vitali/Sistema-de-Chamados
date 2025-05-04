<?php

require_once('../factory/Conex.php');
require_once('../model/Usu.php');

if (!isset($_SESSION)) {
    session_start();
}

$conn = new Conex();
$conn = $conn->getConn();

$query = "INSERT INTO tbusu (nome, telefone, email, senha, funcao) VALUES (:nome, :telefone, :email, :senha, :funcao)";
$cadastrar = $conn->prepare($query);

$usuario = new Usu(
    $_POST['cxNome'],
    $_POST['cxTelefone'],
    $_POST['cxEmail'],
    $_POST['cxSenha'],
    $_POST['cxFuncao']
);

$nome = $usuario->getNome();
$telefone = $usuario->getTelefone();
$email = $usuario->getEmail();
$senha = $usuario->getSenha();
$funcao = $usuario->getFuncao();

$cadastrar->bindParam(':nome', $nome, PDO::PARAM_STR);
$cadastrar->bindParam(':telefone', $telefone, PDO::PARAM_STR);
$cadastrar->bindParam(':email', $email, PDO::PARAM_STR);
$cadastrar->bindParam(':senha', $senha, PDO::PARAM_STR);
$cadastrar->bindParam(':funcao', $funcao, PDO::PARAM_STR);

$cadastrar->execute();

if ($cadastrar->rowCount()) {
    echo "<script>
        alert('Usuário Criado com Sucesso!');
        window.location.href = '../view/cadUsu.php';
    </script>";
} else {
    echo "<script>
        alert('Erro Ao Criar Usuário!');
        window.location.href = '../view/telaRegistroUsuario.php';
    </script>";
}

?>