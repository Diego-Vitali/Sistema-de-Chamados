<?php
// Aqui é feita as requisições para conexão com banco e criação da Classe Usu
require_once('../factory/Conex.php');
require_once('../model/Usu.php');

// Inicia sessão
if (!isset($_SESSION)) {
    session_start();
}

// conn -> cria conexão com banco de dados
$conn = new Conex();
$conn = $conn->getConn();

// Prepara o insert do usuário no banco
$query = "INSERT INTO tbusu (nome, telefone, email, senha, funcao) VALUES (:nome, :telefone, :email, :senha, :funcao)";
$cadastrar = $conn->prepare($query);

// Cria uma classe Usu que vai receber como parâmetros os POSTs do Formulário.
$usuario = new Usu(
    $_POST['cxNome'],
    $_POST['cxTelefone'],
    $_POST['cxEmail'],
    $_POST['cxSenha'],
    $_POST['cxFuncao']
);

// Substitui os parâmetros da query Insert pelos Gets da classe Usu criada em cima.
$cadastrar->bindParam(':nome', $usuario->getNome(), PDO::PARAM_STR);
$cadastrar->bindParam(':telefone', $usuario->getTelefone(), PDO::PARAM_STR);
$cadastrar->bindParam(':email', $usuario->getEmail(), PDO::PARAM_STR);
$cadastrar->bindParam(':senha', $usuario->getSenha(), PDO::PARAM_STR);
$cadastrar->bindParam(':funcao', $usuario->getFuncao(), PDO::PARAM_STR);

// Executa a query
try {
    $cadastrar->execute();

    if ($cadastrar->rowCount()) {
        echo "<script>
            alert('Usuário Criado com Sucesso!');
            window.location.href = '../index.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao criar usuário!');
            window.location.href = '../index.   php';
        </script>";
    }
// O Try Catch serve para tratar erros de integridade tipo inserir e-mail duplicado (O campo está como UNIQUE no banco.)
} catch (PDOException $e) {
    echo "<script>
        alert('Erro no Cadastro: Usuário já cadastrado.');
        window.location.href = '../index.php';
    </script>";
}
?>
