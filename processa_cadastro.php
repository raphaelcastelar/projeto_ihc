<?php
// Conexão com o banco de dados
$host = "seemly-nifty-elasmobranch.data-1.use1.tembo.io";
$user = "postgres";
$pass = "nCQgZW0qldckTOFF";
$dbname = "postgres";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebendo os dados do formulário
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$cnpj = !empty($_POST['cnpj']) ? $_POST['cnpj'] : NULL;
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografia da senha
$crm = $_POST['crm'];

// Inserindo no banco de dados
$sql = "INSERT INTO Usuario (nome, tipo_usuario, cpf, cnpj, email, senha, crm) 
        VALUES (?, 'Médico', ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $nome, $cpf, $cnpj, $email, $senha, $crm);

if ($stmt->execute()) {
    echo "<h2>Cadastro realizado com sucesso!</h2>";
    echo "<p><a href='index.html'>Voltar ao início</a></p>";
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

$stmt->close();
$conn->close();
?>