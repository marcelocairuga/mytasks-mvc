<?php

function autoload($className) {
    $prefix = 'MyTasks\\';  // a sequência \\ é para escapar a barra invertida
    $baseDir = __DIR__ . '/../'; // sobe de config/ para app/


    // Verifica se a classe pertence ao namespace MyTasks
    if (strncmp($prefix, $className, strlen($prefix)) !== 0) {
        return;
    }

    // Remove o prefixo do namespace
    $relativeClass = substr($className, strlen($prefix));

    // Converte separadores de namespace para separadores de diretório
    $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register('autoload');
