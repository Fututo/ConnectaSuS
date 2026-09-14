
<?php
include __DIR__ . '/_conn/_conexao.php';
/** @var PDO $pdo */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cpf = trim($_POST['cpf'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE cpf = ? LIMIT 1");
    $stmt->execute([$cpf]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && (password_verify($senha, $usuario['senha']) || hash_equals($usuario['senha'], $senha))) {

        // Salvar dados na sessão
        $_SESSION['usuario_id']   = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
        $_SESSION['ubs_id']        = $usuario['ubs_id'];
        $_SESSION['usuario_email'] = $usuario['email'];

        $tipos_usuario = [
            'cidadao' => 'cidadão',
            'ubs' => 'UBS',
            'admin' => 'administrador'
        ];
        $tipo_usuario = $tipos_usuario[$usuario['tipo']] ?? 'usuário';
        $_SESSION['mensagem_login'] = "Bem-vindo, {$usuario['nome']}! Você está logado como {$tipo_usuario}.";

        // Redirecionar conforme o tipo de usuário
        if ($usuario['tipo'] == 'cidadao') {
            header("Location: cidadao_inicio.php");
        } elseif ($usuario['tipo'] == 'ubs') {
            header("Location: ubs_painel.php");
        } elseif ($usuario['tipo'] == 'admin') {
            header("Location: admin.php");
        }
        exit;
    } else {
        $erro = "CPF ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ORALIX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center container-estilo min-vh-100">
        <div class="card cartao-personalizado p-4 col-md-5">
            <h2 class="text-center text-primary fw-bold mb-4">ORALIX - Acesso</h2>

            <?php if (!empty($erro)): ?>
                <div class="alert alert-danger"><?php echo $erro; ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label class="form-label">CPF (somente números):</label>
                    <input type="text" name="cpf" class="form-control" placeholder="Ex: 11111111111" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha:</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>

            <div class="mt-4 text-center">
                <small class="text-muted">Usuários de teste:<br>
                Cidadão: CPF <b>11111111111</b> | Senha: <b>123456</b><br>
                UBS: CPF <b>22222222222</b> | Senha: <b>123456</b><br>
                Admin: CPF <b>00000000000</b> | Senha: <b>123456</b>
                </small>
            </div>

            <div class="mt-3 text-center">
                <a href="index.php" class="text-decoration-none">← Voltar ao início</a>
            </div>
        </div>
    </div>

</body>
</html>
