<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="../css/cssCadastro.css">
</head>
<body>
    <div class="form-container">
        <form action="../controller/createUsu.php" method="POST" class="form-box">
            <h1>Cadastro de Usuário</h1>

            <label for="cxNome">Nome de Usuário:</label>
            <input type="text" id="cxNome" name="cxNome" required>

            <label for="cxTelefone">Telefone:</label>
            <input type="text" id="cxTelefone" name="cxTelefone" required>

            <label for="cxEmail">Email:</label>
            <input type="email" id="cxEmail" name="cxEmail" required>

            <label for="cxSenha">Senha:</label>
            <input type="password" id="cxSenha" name="cxSenha" required>

            <label for="cxFuncao">Função:</label>
            <select id="cxFuncao" name="cxFuncao" required>
                <option value="cliente">Cliente</option>
                <option value="tecnico">Técnico</option>
            </select>
            
            <br>
            <br>
            
            <input type="submit" value="Cadastrar">
            <input type="reset" value="Limpar">
            
            <div class="register-link">
                <h4>Já tem uma conta? <a href="../index.php">Fazer Login</a></h4>
            </div>
        </form>
    </div>
</body>
</html>
