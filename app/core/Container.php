<?php
namespace MyTasks\Core;

use Exception;

class Container {
    private array $instances = [];

    public function set(string $key, callable $resolver) {
        $this->instances[$key] = $resolver;
    }

    public function get(string $key) {
        if (!isset($this->instances[$key])) {
            throw new Exception("Instância da classe {$key} não definida.");
        }
        return $this->instances[$key]($this);
    }
}