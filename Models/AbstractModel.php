<?php
require_once "DataBase.php";

/**
 * Classe abstrata dos models
 */
abstract class AbstractModel
{
	/**
	 * @var conexao com db
	 */
	private $connection;
	/**
	 * Nome da tabela
	 * @var string
	 */
	public $table;
	/**
	 * Nome da chave primaria
	 * @var string
	 */
	public $primaryKey;
	/**
	 * conjunto de regras
	 * @var array
	 */
	public $rules = [];
	/**
	 * conjunto de mensagens de erro
	 * @var array
	 */
	public $rulesMsg = [];
	/**
	 * Resposta de validações
	 * @var array
	 */
	public $validationMessage=[];

	public function __construct()
	{

	}

	/**
	 * Seta a classe data base em connection
	 */
	public function setConnection()
	{
		$this->connection = new DataBase();
	}

	/**
	 * Processa as validações que estão nos models e retorna se encontrar falhas
	 * @param  array  $data
	 * @return bool
	 */
	public function validation(array $data)
	{
		$fails = false;
		foreach ($this->rules as $field => $rule) {
			$value = isset($data[$field]) ? $data[$field] : null;
			$check = $rule($value);
			if ($check == false){
				$fails = true;
				$this->validationMessage[$field] = isset($this->rulesMsg[$field]) ? $this->rulesMsg[$field] : "Invalid value for {$field}";
			}
		}
		return $fails;
	}

	/**
	 * Função create
	 * @param  array  $data
	 * @return bool
	 */
	public function create(array $data)
	{
		$this->setConnection();
		$keys = array_keys($data);
		$keys = array_map(function ($v){
			return "`{$v}`";
		}, $keys);
		$keys = implode(",", $keys);

		$values = array_values($data);
		$values = array_map(function ($v){
			return "'{$v}'";
		}, $values);
		$values = implode(",", $values);

		$fails = $this->validation($data);
		if ($fails) {
			return $this->validationMessage;
		}
		return $this->runQuery("INSERT INTO {$this->table} ($keys) VALUES ($values)", "execQuery");
	}

	/**
	 * Função read/find
	 * @param  array  $data
	 * @return mixed
	 */
	public function read(array $data)
	{
		$this->setConnection();
		$id = isset($data[$this->primaryKey]) ? $data[$this->primaryKey] : 0;
		return $this->runQuery("select * from {$this->table} WHERE `{$this->primaryKey}`={$id}", "first");
	}

	/**
	 * Função list/getAll
	 * @return mixed
	 */
	public function index()
	{
		$this->setConnection();
		return $this->runQuery("select * from {$this->table}");
	}

	/**
	 * Função update
	 * @param  array  $data
	 * @return bool
	 */
	public function update(array $data)
	{
		$this->setConnection();
		$sets = [];
		foreach ($data as $index => $value) {
			$sets[] = "`{$index}`='$value'";
		}

		$sets = implode(",", $sets);

		$fails = $this->validation($data);
		if ($fails) {
			return $this->validationMessage;
		}
		$id = isset($data[$this->primaryKey]) ? $data[$this->primaryKey] : 0;
		return $this->runQuery("UPDATE {$this->table} SET {$sets} WHERE `{$this->primaryKey}`={$id}", "execQuery");
	}

	/**
	 * Função delete
	 * @param  array  $data
	 * @return bool
	 */
	public function delete(array $data)
	{
		$this->setConnection();
		$id = isset($data[$this->primaryKey]) ? $data[$this->primaryKey] : 0;
		return $this->runQuery("DELETE FROM {$this->table} WHERE `{$this->primaryKey}`={$id}", "execQuery");
	}

	/**
	 * Conecta, executa a query e fecha a conexao
	 * @param  string  $query
	 * @param  string  $mode
	 * @return mixed
	 */
	public function runQuery(string $query, $mode="get"){
		$this->connection->startConnection();
		$response = $this->connection->{$mode}($query);
		$this->connection->closeConneciton();
		return $response;
	}
}