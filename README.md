Sistema de Chamados
Este sistema permite o gerenciamento de chamados de forma simples. Ele foi desenvolvido em PHP e utiliza MySQL como banco de dados.

Conex.php
Este arquivo é responsável por estabelecer a conexão com o banco de dados MySQL, utilizando a classe PDO para garantir maior segurança na manipulação dos dados.

Usu.php e Chamado.php
Aqui são definidas as classes Usu e Chamado, que representa o usuário do sistema e o chamado. Ela recebe os dados do formulário via POST e os armazena como atributos para serem inseridos no banco.

Cadastro de Usuários
O sistema permite cadastrar novos usuários através de um formulário. Ao enviar os dados, uma instância da classe é criada e seus atributos são enviados para o banco de dados. Antes de inserir, os dados são protegidos contra SQL Injection utilizando prepared statements.

Autenticação
O sistema inicia a sessão do usuário assim que ele faz login. 

Exibição e Manipulação de Chamados
Chamados podem ser criados e visualizados através da interface do sistema. Cada chamado contém informações como título, descrição, status e responsável.

Redirecionamento e Feedback
Mensagens de alerta são exibidas conforme o sucesso ou erro das operações. Caso o cadastro falhe por e-mail duplicado, o sistema retorna ao formulário com uma mensagem explicativa.

Segurança
O código inclui tratamento de exceções para evitar erros inesperados e garantir uma experiência mais segura ao usuário.
