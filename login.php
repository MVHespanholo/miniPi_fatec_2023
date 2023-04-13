
<?php   #Esse é um código PHP que inicia uma sessão, verifica se o método de requisição é POST e se sim,
        # obtém o email e senha submetidos pelo formulário. Em seguida, executa uma consulta no banco de dados para verificar se o email e senha são válidos.

ob_start(); // inicio buffer de saída do PHP

session_start(); // Inicia a sessão

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email_login'];
    $senha = $_POST['senha_login'];

    // Verifica se o email e senha são válidos
    // Se a consulta retornar um resultado, ou seja, se o email e senha estiverem corretos, ele salva as informações do usuário na sessão e redireciona para a página de dashboard.
    // Se não, exibe um alerta e redireciona de volta para a página de login
    $query = "SELECT id, nome FROM fatec_admin WHERE email='$email' AND senha=md5('$senha')";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['nome'] = $row['nome'];
        header('Location: dashboard.html'); // Redireciona para a página de dashboard
    } else {
        echo '<script>alert("Email ou senha incorretos!")</script>'; 
        header("Location: index.html#paralogin");               
    }
}

ob_end_flush(); // final buffer de saída do PHP

?>

