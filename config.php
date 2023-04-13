<?php  // estabelece a conexão com um banco de dados MySQL. As informações de conexão 
//(nome do servidor, usuário, senha e nome do banco de dados) são definidas como variáveis no início do código. 
//Em seguida, a função mysqli_connect é chamada para estabelecer a conexão com o banco de dados usando essas informações.

//Se a conexão for bem-sucedida, a variável $conn armazenará o objeto de conexão retornado pela função mysqli_connect. 
//Caso contrário, o código morre (encerra a execução) e exibe uma mensagem de erro indicando a falha na conexão com o banco de dados.

$host = "localhost"; // nome do servidor MySQL
$user = "id19855106_hespanholo"; // usuário do MySQL
$pass = "&>EFYS)Sus9mayP)"; // senha do MySQL
$dbname = "id19855106_pontos_fatec"; // nome do banco de dados

// Conexão com o banco de dados MySQL
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Verifica se houve erro na conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
