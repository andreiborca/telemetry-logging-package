<?php


namespace App\LogDrivers;


use App\Interfaces\LogEntryInterface;
use App\Interfaces\LoggerDriverInterface;
use Exception;
use PDOException;

class SqlLoggerDriver implements LoggerDriverInterface
{
	private \PDO $pdo;
	private string $logTableName;

	/**
	 * SqlLoggerDriver constructor.
	 *
	 * @param array $config
	 *
	 * @throws Exception
	 */
	public function __construct(
		array $config,
	) {
		$this->logTableName = $config['table'];
		$this->connectToDatabase($config);
		$this->createLogTableIfNotExists();
	}

	/**
	 * @param array $config
	 *
	 * @throws Exception
	 */
	private function connectToDatabase(
		array $config,
	) {
		$dsn = sprintf(
			'%s:host=%s;dbname=%s;charset=%s',
			$config['driver'],
			$config['host'],
			$config['dbname'],
			$config['charset'],
		);
		$username = $config['username'];
		$password = $config['password'];

		try {
			$this->pdo = new PDO($dsn, $username, $password);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			throw new Exception("Database connection failed: " . $e->getMessage());
		}
	}

	/**
	 * @throws Exception
	 */
	private function createLogTableIfNotExists()
	{
		$sql = "
            CREATE TABLE IF NOT EXISTS {$this->logTableName} (
                id INT AUTO_INCREMENT PRIMARY KEY,
                level VARCHAR(255) NOT NULL,
                message TEXT NOT NULL,
                metadata TEXT,                
                timestamp TIMESTAMP,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ";

		try {
			$this->pdo->exec($sql);
		} catch (PDOException $e) {
			throw new Exception("Failed to create table: " . $e->getMessage());
		}
	}

	public function log(LogEntryInterface $logEntry)
	{
		$sql = "
			INSERT INTO {$this->table} 
			    (level, message, metadata, timestamp) 
			    VALUES (:level, :message, :metadata, :timestamp)
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			':level' => $logEntry->getLevel(),
			':message' => $logEntry->getMessage(),
			':metadata' => json_encode($logEntry->getMetadata()),
			':timestamp' => $logEntry->getTimestamp() ?? date('Y-m-d H:i:s'),
		]);
	}
}