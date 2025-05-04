<?php

require_once('../factory/Conex.php');
require_once('../model/Chamado.php');

if (!isset($_SESSION)) {
    session_start();
}

$conn = new Conex();

$query = "SELECT * FROM tbchamado WHERE cod = :cod";
$chamadoAtual = $conn->getConn()->prepare($query);
$chamadoAtual->bindParam(':cod', $_GET['cod'], PDO::PARAM_INT);
$chamadoAtual->execute();
$chamadoAtual = $chamadoAtual->fetch(PDO::FETCH_ASSOC);
if (!$chamadoAtual) {
    die("Chamado não encontrado.");
}

$queryCliente = "SELECT nome FROM tbUsu WHERE id = :id";
    $busca = $conn->getConn()->prepare($queryCliente);
    $busca->bindParam(':id', $_GET['idCliente'], PDO::PARAM_INT);
    $busca->execute();

    $clienteNome = '';
    if ($busca->rowCount() > 0) {
        $rowCliente = $busca->fetch(PDO::FETCH_ASSOC);
        $clienteNome = $rowCliente['nome'];
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamados</title>
</head>
<body>
    <div class="container">
        <h1>Alterar Chamado</h1>
        <form action="../controller/updateChamado.php" method="POST">

            <label for="cxCod">Código:</label><br>
            <input type="text" id="cxCod" name="cxCod" value="<?php echo htmlspecialchars($chamadoAtual['cod']); ?>" readonly><br><br>
            
            <label for="cxCliente">Cliente:</label><br>
            <input type="text" id="cxCliente" name="cxCliente" value="<?php echo htmlspecialchars($clienteNome); ?>"><br><br>

            <label for="cxDescricao">Descrição:</label><br>
            <textarea id="cxDescricao" name="cxDescricao" required><?php echo htmlspecialchars($chamadoAtual['descricao']); ?></textarea><br><br>

            <label for="cxStatus">Status:</label><br>
            <select id="cxStatus" name="cxStatus">
                <option value="aberto">Aberto</option>
                <option value="em_andamento">Em Andamento</option>
                <option value="fechado">Fechado</option>
            </select><br><br>

            <label for="cxCategoria">Categoria:</label><br>
            <select id="cxCategoria" name="cxCategoria">
                <option value="app">Aplicação</option>
                <option value="site">Site</option>
                <option value="conexao">Conexão</option>
                <option value="conta">Conta</option>
                <option value="computador">Computador</option>
                <option value="outro">Outro</option>
            </select><br><br>
            <label for="cxTelefonePrincipal">Telefone Principal:</label><br>
            <input type="tel" id="cxTelefonePrincipal" name="cxTelefonePrincipal" value="<?php echo htmlspecialchars($chamadoAtual['telefoneContato']); ?>" required><br><br>
            <input type="submit" value="Alterar Chamado">
            <input type="reset" value="Limpar"><br><br>
        </form>
    </div>
</body>
</html>