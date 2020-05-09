<?php
require_once "AbstractModel.php";

class User extends AbstractModel
{
	/**
	 * Nome da tabela no banco de dados
	 * @var string
	 */
	public $table = "users";
	/**
	 * Chave primária
	 * @var string
	 */
	public $primaryKey = "id";
	/**
	 * Conjunto de regras para funções create e update
	 * @var array
	 */
	public 	$rules = [];
	/**
	 * Conjunto de mensagens de validação de regras
	 * @var array
	 */
	public $rulesMsg = [
	];

	public function __construct()
	{

	}

}