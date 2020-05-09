<?php
require_once "AbstractModel.php";

/**
 * Classe do livro
 */
class Books extends AbstractModel
{
	/**
	 * Nome da tabela no banco de dados
	 * @var string
	 */
	public $table = "books";
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
		"edition" => "Edição tem que ser um número e é obrigatório"
	];

	public function __construct()
	{
		/**
		 * Aqui no contrutor da classe definimos quais são as regras do model
		 * Para cada attr temos um callback que retornará se o valor é válido
		 * Podendo crescer facilmente ao longo do desenvolvimento do projeto
		 * de modo prático todas as regras de negócio ficam concentradas em apenas
		 * um local
		 */
		$this->rules = (object)[
			"title" => function ($value){
				return is_string($value);
			},
			"author" => function($value){
				return is_string($value);
			},
			"edition" => function($value){
				return is_numeric($value);
			},
			"qtd" => function($value){
				return is_numeric($value);
			}
		];
	}

}