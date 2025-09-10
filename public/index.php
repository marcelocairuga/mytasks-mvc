<?php

require_once __DIR__ . '/../app/config/autoload.php';

use MyTasks\Database\Database;

$db_config = require __DIR__ . '/../app/config/db_config.php';
echo "<h2>Testando a conexão...</h2>";
echo "<p>Nome do banco: " . $db_config['db'] . "</p>";

try {
    $database = new Database($db_config);
    $pdo = $database->getConnection();
    echo "<p>✅ Conexão estabelecida com sucesso!</p>";
} catch (Exception $e) {
    echo "<p>❌ Erro ao conectar ao banco de dados: " . $e->getMessage() . "</p>";
}