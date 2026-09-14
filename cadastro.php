<?php

include __DIR__ . '/_conn/_conexao.php';
/** @var PDO $pdo */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$nome = trim($_POST['nome'] ?? '');
	$CPF = $_POST['cpf'] ?? '';
	$email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!empty($nome) && !empty($CPF) && !empty($email) && !empty($senha)) {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        try {

            $stmt = $pdo->prepare(
				"INSERT INTO usuarios (nome, cpf, email, senha) VALUES (?, ?, ?, ?)"
            );

            $stmt->execute([$nome, $CPF ,$email, $senhaHash]);

            $novoIdUsuario = $pdo->lastInsertId();

            $_SESSION['idUsuario'] = $novoIdUsuario;

            header("Location: index.php");
            exit();

        } catch (PDOException $e) {

            $erro = "Erro ao cadastrar: " . htmlspecialchars($e->getMessage());
        }

    } else {

        $erro = "Preencha todos os campos!";
    }
}
?>
<!doctype html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Cadastro - ORALIX</title>
		<link rel="icon" type="image/png" href="oralix/img/Logob.png" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/cadastro.css" />
	</head>
	<body>
		<nav class="menu">
			<a href="index.php" class="link-logo">
				<img src="img/Logob.png" alt="Logo do ORALIX" class="imagem-logo" />
			</a>

			<ul class="menu-navegacao">
				<li><a href="index.php">Início</a></li>
				<li><a href="#">Serviços</a></li>
				<li><a href="#">Contato</a></li>
				<li><a href="#">Sobre</a></li>
			</ul>

			<ul class="menu-acoes">
				<li><a href="login.php">Fazer Login</a></li>
				<li><a href="cadastro.php">Comece agora</a></li>
			</ul>
		</nav>

		<main class="cadastro-pagina">
			<section class="cadastro-a">
				<div class="cadastro-destaque">
					<span class="cadastro-etiqueta">Portal da saúde</span>
					<h1>Crie sua conta no ORALIX</h1>
					<p>
						Acesse serviços públicos de forma simples, rápida e segura para
						agendar atendimentos e acompanhar sua saúde.
					</p>

					<ul class="cadastro-beneficios">
						<li>Agendamentos em poucos passos</li>
						<li>Consulta de unidades próximas</li>
						<li>Atendimento com mais praticidade</li>
					</ul>
				</div>

				<div class="cadastro-cartao">
					<div class="cadastro-cabecalho">
						<h2>Cadastro</h2>
						<p>Preencha seus dados para continuar</p>
					</div>

					<?php if ($erro): ?>
						<div class="alert alert-danger cadastro-alerta"><?php echo htmlspecialchars($erro); ?></div>
					<?php endif; ?>

					<form method="POST" action="cadastro.php" class="cadastro-formulario">
						<div class="mb-3">
							<label class="form-label">Nome completo</label>
							<input type="text" name="nome" class="form-control cadastro-entrada" required>
						</div>

						<div class="mb-3">
							<label class="form-label">CPF</label>
							<input type="text" name="cpf" class="form-control cadastro-entrada" placeholder="11111111111" minlength = "11" maxlength = "11" required>
						</div>

						<div class="mb-3">
							<label class="form-label">E-mail</label>
							<input type="email" name="email" class="form-control cadastro-entrada" placeholder="seuemail@exemplo.com">
						</div>

						<div class="mb-3">
							<label class="form-label">Senha</label>
							<input type="password" name="senha" class="form-control cadastro-entrada" placeholder= "123456" required>
						</div>

						<button type="submit" class="btn btn-primary w-100 cadastro-botao">Cadastrar</button>
					</form>

					<div>
						<p class="cadastro-rodape">Já possui conta?</p>
						<a href="login.php" class="cadastro-rodape-login">Fazer login</a>
					</div>
				</div>
			</section>
		</main>
	</body>
</html>
