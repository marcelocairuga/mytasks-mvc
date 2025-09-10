<?php
// Configurações de conexão
$host = "localhost";
$user = "root";
$pass = ""; 
$dbname = "mytasks";

// Usuários e tarefas de exemplo
$users = [
    ["Alvirinha Souza", "alvirinha@email.com", password_hash("alvirinha", PASSWORD_DEFAULT), 0],
    ["Elesbão Silva", "elesbao@email.com", password_hash("elesbao", PASSWORD_DEFAULT), 0],
    ["Dorotéia Virsh", "doroteia@email.com", password_hash("doroteia", PASSWORD_DEFAULT), 0],
    ["Genoveva da Rocha", "genoveva@email.com", password_hash("genoveva", PASSWORD_DEFAULT), 0],
    ["Bernardino Costa", "bernardino@email.com", password_hash("bernardino", PASSWORD_DEFAULT), 0],
];
$tasks = [
    ['Implementar autenticação JWT', 1, 0, 2],
    ['Revisar documentação do sistema', 0, 1, 2],
    ['Criar testes unitários', 1, 0, 2],
    ['Configurar banco de dados', 0, 0, 3],
    ['Otimizar consultas SQL', 1, 1, 3],
    ['Desenvolver tela de login', 1, 0, 4],
    ['Ajustar layout responsivo', 0, 1, 4],
    ['Corrigir bug no formulário', 1, 0, 4],
    ['Implementar cache com Redis', 1, 0, 5],
    ['Atualizar dependências do projeto', 0, 0, 5],
    ['Gerar relatório mensal', 0, 1, 5],
    ['Criar API de tarefas', 1, 0, 6],
    ['Testar integração com frontend', 0, 1, 6]
];

try {
    // 1. Conecta ao MySQL, no banco mytasks
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conectado ao servidor MySQL\n";
} catch (PDOException $e) {    
    die("❌ Erro ao conectar ao banco de dados:  " . $e->getMessage());
}

try {
    // 2. Inicia uma transação
    $pdo->beginTransaction();

    // 3. Insere um usuário administrador
    $hash = password_hash("admin", PASSWORD_DEFAULT);
    $pdo->query("
        INSERT INTO users (name, email, password, is_admin)
        VALUES (
            'Administrador do Sistema',
            'admin@email.com',
            '$hash',
            1
        )
    ");
    echo "✅ Usuário administrador criado\n";

    // 4. Insere cada um dos usuários de exemplo no banco
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin) 
                           VALUES (?, ?, ?, ?)");
    foreach ($users as $user) {
        $stmt->execute($user);
    }
    echo "✅ Usuários de exemplo criados\n";

    // 5. Insere cada uma das tarefas de exemplo no banco
    $stmt = $pdo->prepare("INSERT INTO tasks (title, is_urgent, is_completed, user_id) 
                           VALUES (?, ?, ?, ?)");
    foreach ($tasks as $task) {
        $stmt->execute($task);
    }
    echo "✅ Tarefas de exemplo criadas\n";

    // 6. Confirma a transação
    $pdo->commit();
    
    echo "🎉 Seed concluído com sucesso!";
} catch (PDOException $e) {
    $pdo->rollBack(); // desfaz alterações em caso de erro
    die("❌ Erro ao inserir os dados de exemplo:  " . $e->getMessage());
}