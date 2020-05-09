<?php


class DataBase
{
	// variavel para armazenar a conexao
	public $connection;

	/**
	 * Começa uma conexão com mysql
	 * @param  string  $database
	 */
	public function startConnection(string $database='library') : void
	{
		$this->connection = mysqli_connect('localhost', 'root', '', $database);
	}

	/**
	 * Retorna um array com dados de um select buscando uma lista
	 * @param  string  $query
	 * @return array
	 */
	public function get(string $query) : array
	{
		$list = [];
		$r = $this->execQuery($query);
		while ($l = mysqli_fetch_assoc($r)) {
			$list[] = $l;
		}
		return $list;
	}

	/**
	 * Consulta busca um registro
	 * @param  string  $query
	 * @return string[]|null
	 */
	public function first(string $query)
	{
		$r = $this->execQuery($query);
		$st = mysqli_fetch_assoc($r);
		return $st;
	}

	/**
	 * Executa uma query
	 * @param  string  $query
	 * @return bool|mysqli_result
	 */
	public function execQuery(string $query)
	{
		$r =  mysqli_query($this->connection, $query);
		if ($r == false){
			var_dump($query);
			echo ("Could not insert data : " . mysqli_error($this->connection) . " " . mysqli_errno($this->connection));
		}
		return $r;
	}

	/**
	 * Fecha a conexão com o banco
	 */
	public function closeConneciton() : void
	{
		mysqli_close($this->connection);
	}
}