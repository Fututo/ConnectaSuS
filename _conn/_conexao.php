
<?php
$base_url = 'http://localhost/oralix/';
if (!defined('BASE_URL')) define('BASE_URL', $base_url);

if (!defined('BASE_PATH')) {
    define('BASE_PATH', realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR);
}

// Configurações do banco de dados
$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "oralix";

try {
    $pdo = new PDO(
        "mysql:host={$servidor};dbname={$banco};charset=utf8mb4",
        $usuario,
        $senha,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Falha na conexão com o banco de dados.");
}


?>

