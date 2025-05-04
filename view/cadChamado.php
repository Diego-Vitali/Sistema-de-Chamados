<?php
    session_start();
    $userId = $_SESSION['id'];

    include_once '../factory/Conex.php';

    $conex = new Conex();
    $conn = $conex->getConn();

    $queryCliente = "SELECT nome FROM tbUsu WHERE id = :id";
    $busca = $conn->prepare($queryCliente);
    $busca->bindParam(':id', $userId, PDO::PARAM_INT);
    $busca->execute();

    $clienteNome = '';
    if ($busca->rowCount() > 0) {
        $rowCliente = $busca->fetch(PDO::FETCH_ASSOC);
        $clienteNome = $rowCliente['nome'];
    }

    $isCliente = false;
    $isTecnico = false;
    if (isset($_SESSION['funcao'])) {
        if ($_SESSION['funcao'] == 'cliente') {
            $isCliente = true;
        } elseif ($_SESSION['funcao'] == 'tecnico') {
            $isTecnico = true;
        }
    }
    if ($isCliente) {
        $queryCliente = "SELECT nome FROM tbUsu WHERE id = :id";
        $busca = $conn->prepare($queryCliente);
        $busca->bindParam(':id', $userId, PDO::PARAM_INT);
        $busca->execute();

        if ($busca->rowCount() > 0) {
            $rowCliente = $busca->fetch(PDO::FETCH_ASSOC);
            $clienteNome = $rowCliente['nome'];
        }
    }
    if ($isCliente) {
        $queryChamados = "SELECT * FROM tbchamado WHERE idCliente = :idCliente";
        $buscaChamados = $conn->prepare($queryChamados);
        $buscaChamados->bindParam(':idCliente', $userId, PDO::PARAM_INT);
    } elseif ($isTecnico) {
        $queryChamados = "SELECT * FROM tbchamado";
        $buscaChamados = $conn->prepare($queryChamados);
    }
    $buscaChamados->execute();
    $chamados = $buscaChamados->fetchAll(PDO::FETCH_ASSOC);
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
        <h1>Chamados Anteriores</h1>

        <table class="tabelaChamados">
            <thead>
            <tr>
                <th>ID Chamado</th>
                <th>ID Cliente</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Categoria</th>
                <th>Data de Criação</th>
                <?php if(!$isCliente){
                    echo "<th>Modificar</th><th>Deletar</th>";
                    }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($chamados)) {
                foreach ($chamados as $chamado) {
                echo "<tr>";
                echo "<td>" . $chamado['cod'] . "</td>";
                echo "<td>" . $chamado['idCliente'] . "</td>";
                echo "<td>" . $chamado['descricao'] . "</td>";
                echo "<td>" . $chamado['statusChamado'] . "</td>";
                echo "<td>" . $chamado['categoria'] . "</td>";
                echo "<td>" . $chamado['dataCriacao'] . "</td>";
                if(!$isCliente){
                    echo "<td><a href='../view/updChamado.php?cod=" . $chamado['cod'] . "&idCliente=" . $chamado['idCliente'] . "'>Modificar</a></td>";
                    echo "<td><a href='../controller/deleteChamado.php?cod=" . $chamado['cod'] . "' onclick=\"return confirm('Tem certeza que deseja deletar este chamado?');\">Deletar</a></td>";
                    echo "</tr>";
                    }
                }
            } else {
                echo "<tr>
                <td colspan='8'>Nenhum chamado encontrado.</td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
        </table>
    </div>
    <div class="container">
        <h1>Criar Chamado</h1>
        <form action="../controller/createChamado.php" method="POST">
            
            <?php
                // Corrigido: Removido bindParam desnecessário
                $buscaCOD = $conn->prepare("SELECT MAX(cod) AS cod FROM tbchamado");
                $buscaCOD->execute();
                $resultado = $buscaCOD->fetch(PDO::FETCH_ASSOC);
                $ultimoCodigo = isset($resultado['cod']) ? $resultado['cod'] + 1 : 1;
            ?>

            <label for="cxCod">Código:</label><br>
            <input type="text" id="cxCod" name="cxCod" value="<?php echo $ultimoCodigo; ?>" readonly><br><br>
            
            <label for="cxCliente">Cliente:</label><br>
            <input type="text" id="cxCliente" name="cxCliente" value="<?php echo htmlspecialchars($clienteNome); ?>" <?php echo $isCliente ? 'readonly' : ''; ?> required><br><br>

            <label for="cxDescricao">Descrição:</label><br>
            <textarea id="cxDescricao" name="cxDescricao" required></textarea><br><br>

            <label for="cxStatus">Status:</label><br>
            <select id="cxStatus" name="cxStatus" <?php echo !$isTecnico ? 'disabled' : ''; ?>>
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
            <input type="tel" id="cxTelefonePrincipal" name="cxTelefonePrincipal" required><br><br>
            
            <label for="cxDataCriacao">Data de Criação:</label><br>
            <input type="date" id="cxDataCriacao" name="cxDataCriacao" value="<?php echo date('Y-m-d'); ?>" readonly><br><br>

            <input type="submit" value="Criar Chamado">
            <input type="reset" value="Limpar"><br><br>
        </form>
    </div>
    <div class="container">
        <a href="../index.php">Sair</a>
    </div>
</body>
</html>