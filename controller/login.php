<?php

// Aqui é feita as requisições para conexão com banco e criação da Classe Usu
    require_once('../factory/Conex.php');
    require_once('../model/Usu.php');

// Inicia sessão
    if (!isset($_SESSION)) {
        session_start();
    }

// Em resumo, esse código da um select no banco buscando a senha de acordo com o e-mail e então verifica se a senha digitada bate
// com a senha do usuário.

// Ele também busca a função e o ID que serão passados para as outras guias via SESSION.
    $query = "SELECT id, senha, funcao FROM tbusu WHERE email = :email";
    $conn = new Conex();
    $conn = $conn->getConn()->prepare($query);

    $conn->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
    $conn->execute();
    $resultado = $conn->fetch(PDO::FETCH_ASSOC);
    $senha = $resultado['senha'];
    $funcao = $resultado['funcao'];
    if($senha == $_POST['senha']){
        $_SESSION['funcao'] = $funcao;
        $_SESSION['id'] = $resultado['id'];
        header('Location: ../view/cadChamado.php');
    } else {
        echo "<script>
            alert('Email ou Senha Inválidos!');
            window.location.href = '../index.php';
        </script>";
    }


?>
