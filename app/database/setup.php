<?php
// Configurações de conexão
$host = "localhost";
$user = "root";
$pass = ""; 
$dbname = "mytasks";

try {
    // 1. Conecta ao MySQL sem banco definido
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conectado ao servidor MySQL\n";

    // 2. Apaga banco existente
    $pdo->exec("DROP DATABASE IF EXISTS `$dbname`");
    echo "⚠️ Banco `$dbname` removido\n";

    // 3. Cria banco novo
    $pdo->exec("CREATE DATABASE `$dbname`
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_general_ci");
    echo "✅ Banco `$dbname` criado\n";

    // 4. Seleciona o banco para uso
    $pdo->exec("USE `$dbname`");

    // 5. Cria tabela users
    $pdo->exec("
        CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            is_admin TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");
    echo "✅ Tabela `users` criada\n";

    // 6. Cria tabela tasks
    $pdo->exec("
        CREATE TABLE tasks (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            is_urgent TINYINT(1) DEFAULT 0,
            is_completed TINYINT(1) DEFAULT 0,
            user_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");
    echo "✅ Tabela `tasks` criada\n";

    echo "🎉 Setup concluído com sucesso!";
} catch (PDOException $e) {
    die("❌ Erro ao preparar o banco de dados: " . $e->getMessage());
}