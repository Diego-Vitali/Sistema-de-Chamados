<?php

    require_once('../factory/Conex.php');
    require_once('../model/Usu.php');

    if (!isset($_SESSION)) {
        session_start();
    }

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
            window.location.href = '../view/index.php';
        </script>";
    }


?>
