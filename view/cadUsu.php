<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auxílio Técnico</title>
</head>
<body>
    <form action="../controller/createUsu.php" method="POST">
        <h1>Cadastro de Usuário</h1>
        <label for="cxNome">Nome de Usuário:</label><br>
        <input type="text" id="cxNome" name="cxNome" required><br><br>

        <label for="cxTelefone">Telefone:</label><br>
        <input type="text" id="cxTelefone" name="cxTelefone" required><br><br>

        <label for="cxEmail">Email:</label><br>
        <input type="email" id="cxEmail" name="cxEmail" required><br><br>

        <label for="cxSenha">Senha:</label><br>
        <input type="password" id="cxSenha" name="cxSenha" required><br><br>

        <label for="cxFuncao">Função:</label><br>
        <select id="cxFuncao" name="cxFuncao">
            <option value="cliente">Cliente</option>
            <option value="tecnico">Técnico</option>
        </select><br><br>

        <input type="submit" value="Cadastrar">
        <input type="reset" value="Limpar"><br><br>
    </form>
    <h4>Já tem uma conta? <a href="../index.php">Fazer Login</a></h4>
</body>
</html>