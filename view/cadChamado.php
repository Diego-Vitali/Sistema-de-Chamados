<?php

// Cria sessão e verifica se o id foi passado na session
    if (!isset($_SESSION)) {
        session_start();
    }

    if (!isset($_SESSION['id'])) {
        header('Location: ../index.php'); 
        exit;
    }

// Armazena o ID e Funçaõ da SESSION em variáveis
    $userId = $_SESSION['id'];
    $userFuncao = $_SESSION['funcao'] ?? 'cliente';

// Conexão com banco
    include_once '../factory/Conex.php';

    $conex = new Conex();
    $conn = $conex->getConn();

// Função para obter o nome do cliente de acordo com o ID
    $clienteNome = '';
    if ($userId) { 
        $queryClienteNome = "SELECT nome FROM tbUsu WHERE id = :id";
        $buscaNome = $conn->prepare($queryClienteNome);
        $buscaNome->bindParam(':id', $userId, PDO::PARAM_INT);
        $buscaNome->execute();
        if ($rowNome = $buscaNome->fetch(PDO::FETCH_ASSOC)) {
            $clienteNome = $rowNome['nome'];
        }
    }

// As variáveis são iniciadas com NULL. Se ele for cliente, a variável IsCliente recebe valor, se não permanece Nula
    $isCliente = ($userFuncao == 'cliente');
    $isTecnico = ($userFuncao == 'tecnico');

// Em resumo, busca os chamados do cliente e ordena por data de criação se o usuário for cliente.
// Se o usuário for técnico, ele busca todos os chamados.
    $chamados = [];
    if ($isCliente) {
        $queryChamados = "SELECT c.*, u.nome as nomeCliente FROM tbchamado c JOIN tbusu u ON c.idCliente = u.id WHERE c.idCliente = :idCliente ORDER BY c.dataCriacao DESC";
        $buscaChamados = $conn->prepare($queryChamados);
        $buscaChamados->bindParam(':idCliente', $userId, PDO::PARAM_INT);
    } elseif ($isTecnico) {
        $queryChamados = "SELECT c.*, u.nome as nomeCliente FROM tbchamado c JOIN tbusu u ON c.idCliente = u.id ORDER BY c.dataCriacao DESC";
        $buscaChamados = $conn->prepare($queryChamados);
    } else {

        $buscaChamados = null;
    }

    if ($buscaChamados) {
        $buscaChamados->execute();
        $chamados = $buscaChamados->fetchAll(PDO::FETCH_ASSOC);
    }

// Isso aqui serve para q o código do chamado apareça para o usuário, mas q ele não seja capaz de alterar.
    $ultimoCodigo = 1; 
    $buscaCOD = $conn->prepare("SELECT MAX(cod) AS max_cod FROM tbchamado");
    $buscaCOD->execute();
    $resultadoCod = $buscaCOD->fetch(PDO::FETCH_ASSOC);
    if ($resultadoCod && $resultadoCod['max_cod'] !== null) {
        $ultimoCodigo = $resultadoCod['max_cod'] + 1;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cssChamUso.css">
    <title>Gerenciamento de Chamados</title>
    
</head>
<body>
    <div class="container">
        <a href="../index.php" class="button-link sair" style="float: right;">Sair</a>
        <h1>Meus Chamados / Gerenciar Chamados</h1>
        <p>Bem-vindo(a), <?php echo htmlspecialchars($clienteNome); ?> (<?php echo htmlspecialchars($userFuncao); ?>)</p>

        <table class="tabelaChamados">
            <thead>
            <tr>
                <th>ID Chamado</th>
                <th>Cliente</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Categoria</th>
                <th>Telefone Contato</th>
                <th>Data de Criação</th>
                <!-- As funçõoes de Modificar e Excluir só podem existir se o usuário for técnico. -->
                <?php if($isTecnico): ?>
                    <th>Ações</th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($chamados)): ?>
                <!-- Esse PHP busca os chamados do usuário no banco de dados e os retorna como linhas td da TABLE. -->
                <?php foreach ($chamados as $chamado): ?>
                <tr>
                    <td><?php echo htmlspecialchars($chamado['cod']); ?></td>
                    <td><?php echo htmlspecialchars($chamado['nomeCliente']); ?> (ID: <?php echo htmlspecialchars($chamado['idCliente']); ?>)</td>
                    <td><?php echo nl2br(htmlspecialchars($chamado['descricao'])); ?></td>
                    <td><?php echo htmlspecialchars($chamado['statusChamado']); ?></td>
                    <td><?php echo htmlspecialchars($chamado['categoria']); ?></td>
                    <td><?php echo htmlspecialchars($chamado['telefoneContato']); ?></td>
                    <td><?php echo htmlspecialchars(date("d/m/Y H:i", strtotime($chamado['dataCriacao']))); ?></td>
                    <?php if($isTecnico): ?>
                    <td>
                        <a href="../view/updChamado.php?cod=<?php echo $chamado['cod']; ?>" class="button-link" style="background-color: #ffc107;">Modificar</a>
                        <a href="../controller/deleteChamado.php?cod=<?php echo $chamado['cod']; ?>" class="button-link" style="background-color: #dc3545;" onclick="return confirm('Tem certeza que deseja deletar este chamado?');">Deletar</a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?php echo $isTecnico ? '8' : '7'; ?>">Nenhum chamado encontrado.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <h1><?php echo $isCliente ? "Abrir Novo Chamado" : "Registrar Novo Chamado para Cliente"; ?></h1>
        <form action="../controller/createChamado.php" method="POST">

            <label for="cxCod">Código do Chamado:</label>
            <input type="text" id="cxCod" name="cxCod" value="<?php echo $ultimoCodigo; ?>" readonly class="readonly-field"><br>

            <label for="cxCliente">Cliente:</label>
            <input type="text" id="cxCliente" name="cxCliente"
                   value="<?php echo htmlspecialchars($clienteNome); ?>"
                   <?php echo $isCliente ? 'readonly class="readonly-field"' : ''; ?> required><br>
            <?php if ($isTecnico): ?>
                <small>Para técnicos: Insira o nome exato do cliente cadastrado.</small>
            <?php endif; ?>

            <label for="cxDescricao">Descrição:</label>
            <textarea id="cxDescricao" name="cxDescricao" rows="4" required></textarea><br>

            <label for="cxStatus">Status:</label>
            <!-- O campo STATUS só pode ser diferente de ABERTO se for um técnico criando um chamado (Não faz sentido um Cliente criar um chamado encerrado) -->
            <select id="cxStatus" name="cxStatus" <?php echo $isCliente ? 'disabled class="readonly-field"' : ''; ?>>
                <option value="aberto" <?php echo ($isCliente || !$isTecnico) ? 'selected' : '';?>>Aberto</option>
                <?php if ($isTecnico):?>
                <option value="em_andamento">Em Andamento</option>
                <option value="fechado">Fechado</option>
                <?php endif; ?>
            </select><br>
            <?php if($isCliente): ?>
                <input type="hidden" name="cxStatus" value="aberto"> <?php endif; ?>


            <label for="cxCategoria">Categoria:</label>
            <select id="cxCategoria" name="cxCategoria" required>
                <option value="app">Aplicação</option>
                <option value="site">Site</option>
                <option value="conexao">Conexão</option>
                <option value="conta">Conta</option>
                <option value="computador">Computador</option>
                <option value="outro">Outro</option>
            </select><br>

            <label for="cxTelefonePrincipal">Telefone Principal para Contato:</label>
            <input type="tel" id="cxTelefonePrincipal" name="cxTelefonePrincipal" placeholder="(XX) XXXXX-XXXX" required><br>

            <label for="cxDataCriacao">Data de Criação:</label>
            <input type="date" id="cxDataCriacao" name="cxDataCriacao" value="<?php echo date('Y-m-d'); ?>" readonly class="readonly-field"><br>

            <input type="submit" value="Criar Chamado">
            <input type="reset" value="Limpar Campos">
        </form>
    </div>

    <?php if ($isTecnico):?>
    <div class="container">
        <a href="../view/cadUsu.php" class="button-link" style="background-color: #28a745;">Cadastrar Novo Usuário</a>
    </div>
    <?php endif; ?>

</body>
</html>