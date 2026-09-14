<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$mensagem = '';
$mensagem_login = $_SESSION['mensagem_login'] ?? '';
unset($_SESSION['mensagem_login']);
$usuario = [
    'nome' => $_SESSION['usuario_nome'] ?? 'Cidadão Exemplo',
    'cpf' => '123.456.789-00',
    'cns' => '700000000000000',
    'data_nascimento' => '2000-05-15',
    'telefone' => '(11) 98765-4321',
    'email' => $_SESSION['usuario_email'] ?? 'cidadao@email.com',
    'endereco' => 'Rua das Flores, 123',
    'ubs_referencia' => 'UBS Central'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario['nome'] = htmlspecialchars($_POST['nome']);
    $usuario['telefone'] = htmlspecialchars($_POST['telefone']);
    $usuario['endereco'] = htmlspecialchars($_POST['endereco']);
    $mensagem = "Dados atualizados com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ORALIX - Meu Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">ORALIX</a>
            <div>
                <a href="index.php" class="btn btn-outline-light btn-sm">Voltar ao Início</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">Meu Perfil</h2>

        <?php if ($mensagem_login): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($mensagem_login, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <?php if ($mensagem): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="perfil.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome Completo</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $usuario['nome']; ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">CPF</label>
                            <input type="text" class="form-control" value="<?php echo $usuario['cpf']; ?>" disabled>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">CNS (Cartão SUS)</label>
                            <input type="text" class="form-control" value="<?php echo $usuario['cns']; ?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" value="<?php echo $usuario['data_nascimento']; ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="<?php echo $usuario['telefone']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="email" class="form-control" value="<?php echo $usuario['email']; ?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Endereço</label>
                            <input type="text" name="endereco" class="form-control" value="<?php echo $usuario['endereco']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">UBS de Referência</label>
                            <input type="text" class="form-control" value="<?php echo $usuario['ubs_referencia']; ?>" disabled>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>