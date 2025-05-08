<?php

// Requisição para acesso no banco e inicio de sessão para armezar as variáveis dps
    session_start();
    require_once 'factory/Conex.php';
    $conn = new Conex();
    $conn = $conn->getConn();

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cssLogin.css">
    <title>Login</title>
</head>
<body>
    
    <form method="POST" action="controller/login.php">
        <h1>Login</h1>    

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br>
        <button type="submit">Entrar</button>
        
        <h4>Não tem uma conta? <a href="view/cadUsu.php">Cadastre-se aqui!</a></h4>
    </form>
    
</body>
</html>