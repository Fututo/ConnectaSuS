<?php
$mensagem = '';
$erro = '';
$nome = '';
$email = '';
$assunto = '';
$texto = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$nome = trim($_POST['nome'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$assunto = trim($_POST['assunto'] ?? '');
	$texto = trim($_POST['mensagem'] ?? '');

	if ($nome === '' || $email === '' || $assunto === '' || $texto === '') {
		$erro = 'Preencha todos os campos para enviar sua mensagem.';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$erro = 'Informe um e-mail válido.';
	} else {
		$mensagem = 'Mensagem enviada com sucesso! Em breve entraremos em contato.';
		$nome = '';
		$email = '';
		$assunto = '';
		$texto = '';
	}
}
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contato - ORALIX</title>
	<link rel="icon" type="image/png" href="img/Logob.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/contato.css">
</head>
<body>
	<nav class="menu">
		<a href="index.php" class="link-logo">
			<img src="img/Logob.png" alt="Logo do ORALIX" class="imagem-logo">
		</a>
		<ul class="menu-navegacao">
			<li><a href="index.php">Início</a></li>
			<li><a href="#">Serviços</a></li>
			<li><a href="contato.php">Contato</a></li>
			<li><a href="index.php#sobre">Sobre</a></li>
		</ul>
		<ul class="menu-acoes">
			<li><a href="login.php">Fazer Login</a></li>
			<li><a href="cadastro.php">Comece agora</a></li>
		</ul>
	</nav>

	<main class="contato-page">
		<section class="contato-shell">
			<div class="contato-intro">
				<span class="contato-badge">Fale conosco</span>
				<h1>Como podemos ajudar?</h1>
				<p>Envie sua dúvida, sugestão ou solicitação. Nossa equipe está pronta para orientar você sobre o ORALIX.</p>
				<div class="contato-info">
					<div>
						<strong>Atendimento</strong>
						<span>Segunda a sexta, das 8h às 17h</span>
					</div>
					<div>
						<strong>Portal de saúde</strong>
						<span>Informações sobre serviços públicos de saúde bucal</span>
					</div>
				</div>
			</div>

			<div class="contato-card">
				<h2>Envie uma mensagem</h2>
				<p class="contato-subtitulo">Preencha os campos abaixo para falar com a equipe.</p>
				<?php if ($mensagem): ?>
					<div class="alert alert-success contato-alert" role="alert"><?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></div>
				<?php endif; ?>
				<?php if ($erro): ?>
					<div class="alert alert-danger contato-alert" role="alert"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
				<?php endif; ?>

				<form method="POST" action="contato.php">
					<div class="mb-3">
						<label for="nome" class="form-label">Nome</label>
						<input type="text" id="nome" name="nome" class="form-control contato-input" value="<?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>" required>
					</div>
					<div class="mb-3">
						<label for="email" class="form-label">E-mail</label>
						<input type="email" id="email" name="email" class="form-control contato-input" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>
					</div>
					<div class="mb-3">
						<label for="assunto" class="form-label">Assunto</label>
						<input type="text" id="assunto" name="assunto" class="form-control contato-input" value="<?php echo htmlspecialchars($assunto, ENT_QUOTES, 'UTF-8'); ?>" required>
					</div>
					<div class="mb-3">
						<label for="mensagem" class="form-label">Mensagem</label>
						<textarea id="mensagem" name="mensagem" class="form-control contato-input" rows="5" required><?php echo htmlspecialchars($texto, ENT_QUOTES, 'UTF-8'); ?></textarea>
					</div>
					<button type="submit" class="btn btn-primary w-100 contato-btn">Enviar mensagem</button>
				</form>
			</div>
		</section>
	</main>

	<footer class="text-center contato-footer">
		<div class="container">
			<p class="mb-0">ORALIX - Sistema de Apoio ao Cidadão | Projeto Integrador 2° Ano</p>
		</div>
	</footer>
</body>
</html>
