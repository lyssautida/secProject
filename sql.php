<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'test';
$port = '3307';

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if($error = $conn->connect_error) {
    die('Erro de conexão: ' . $error);
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    //query vulnerável à injeção sql
    $sql = "SELECT * FROM usuarios WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        echo "Login realizado com sucesso";
    } else {   
        echo "Usuário ou senha incorretos";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="username">Usuário:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Senha:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
