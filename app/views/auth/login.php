<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>MyTasks</title>
    <link rel="stylesheet" href="<?= $this->asset('css/auth.css') ?>">
</head>
<body>
    <form action="" method="post">
        <h2>Entrar no MyTasks</h2>
        <?php if (!empty($message)): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>

        <input type="email" name="email" placeholder="E-mail">
        <input type="password" name="password" placeholder="Senha">

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>