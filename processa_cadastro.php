<?php
// Conexão com o banco de dados (ajuste os parâmetros conforme seu ambiente)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "contabilidade_medicos";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebendo dados do formulário
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

// Consulta simples para verificar o cadastro
$sql_select = "SELECT nome, email, crm FROM Usuario WHERE email = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("s", $email);
$stmt_select->execute();
$result = $stmt_select->get_result();

if ($result->num_rows > 0) {
    echo "<h3>Dados cadastrados:</h3>";
    while ($row = $result->fetch_assoc()) {
        echo "Nome: " . $row['nome'] . "<br>";
        echo "E-mail: " . $row['email'] . "<br>";
        echo "CRM: " . $row['crm'] . "<br>";
    }
}

$stmt->close();
$stmt_select->close();
$conn->close();
?>