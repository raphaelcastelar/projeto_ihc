<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$pass = ""; // Senha vazia por padrão no XAMPP
$dbname = "contabilidade_medicos";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $cnpj = !empty($_POST['cnpj']) ? $_POST['cnpj'] : NULL;
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $crm = $_POST['crm'];

    $sql = "INSERT INTO Usuario (nome, tipo_usuario, cpf, cnpj, email, senha, crm) 
            VALUES (?, 'Médico', ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erro na preparação da query: " . $conn->error);
    }

    // Ajustado para 6 parâmetros, pois tipo_usuario é fixo
    $stmt->bind_param("ssssss", $nome, $cpf, $cnpj, $email, $senha, $crm);

    if ($stmt->execute()) {
        echo "<h2>Cadastro realizado com sucesso!</h2>";
        echo "<p><a href='index.html'>Voltar ao início</a></p>";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Método não permitido. Use POST.";
}

$conn->close();
?>
