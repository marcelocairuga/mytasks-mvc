<?php
namespace MyTasks\Database;

use PDO;
use PDOException;
use InvalidArgumentException;
use RuntimeException;

class Database {
    private ?PDO $connection = null;
    private array $config;

    // construtor exige um array com as configurações de conexão
    public function __construct(array $config) {
        // estas são as configurações obrigatórias
        $requiredKeys = ['host', 'db', 'user', 'pass', 'charset'];
        // verifica se todas as configurações obrigatórias estão presentes
        foreach ($requiredKeys as $key) {
            if (!isset($config[$key])) {
                // se alguma configuração estiver faltando, lança uma exceção
                throw new InvalidArgumentException("A configuração '$key' é obrigatória para a conexão com o banco de dados.");
            }
        }
        $this->config = $config;
    }

    // retorna uma conexão PDO
    // se a conexão já foi estabelecida, retorna-a
    // caso contrário, estabelece uma nova conexão
    // lazy loading
    public function getConnection(): PDO {
        if ($this->connection === null) {
            $this->connect();
        }
        return $this->connection;
    }

    // estabelece a conexão com o banco de dados
    private function connect(): void {
        $dsn = "mysql:host={$this->config['host']};dbname={$this->config['db']};charset={$this->config['charset']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->connection = new PDO(
                $dsn,
                $this->config['user'],
                $this->config['pass'],
                $options
            );
        } catch (PDOException $e) {
            throw new RuntimeException("Falha ao conectar ao banco de dados: " . $e->getMessage());
        }
    }
}