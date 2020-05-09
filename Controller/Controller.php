<?php

require_once "../../Models/Books.php";
require_once "../../Models/User.php";
require_once "../../Models/Loan.php";

class Controller
{
	/**
	 * Direciona para o model e metodo certo com base na url
	 */
	public static function direct()
	{
		//pega arquivo a ser executado
		$file = $_SERVER['SCRIPT_NAME'];
		$file = str_replace(["/library/routes/", ".php"], ["", ""], $file);
		// pega o nome da classe e do metodo
		$parts = explode("/", $file);
		$className = ucwords($parts[0]);
		$classnick = ($parts[0]);
		$method = $parts[1];

		//verifica se o metodo chamado é valido, caso nao response error 405
		if (!self::checkRequestMethod($method)){
			http_response_code(405);
			die();
		}
		// verifica se o model existe
		if (class_exists($className)){
			$c = new $className();
			//verifica se o metodo existe
			if (method_exists($c, $method)){
				// pega dados da requisicao e envia
				$post = array_merge(filter_input_array(INPUT_GET)??[], filter_input_array(INPUT_POST)??[]);
				// var_dump($post);
				// chama a classe e o metodo passando os dados do request
				$response = $c->{$method}($post);
				// envia o retorno
				self::makeJsonResponse($classnick, $response);
			}else{
				// caso nao encontre o method
				http_response_code(404);
				die();
			}
		}else{
			// caso nao encontre o model
			http_response_code(404);
			die();
		}
	}

	/**
	 * Verifica se o metodo requisitado é valido para a chamada
	 * @param  string  $method
	 * @return bool
	 */
	private static function checkRequestMethod(string $method)
	{
		$type = $_SERVER['REQUEST_METHOD'];
		$allow = [
			"create" => "POST",
			"delete" => "GET",
			"index" => "GET",
			"read" => "GET",
			"update" => "POST"
		];

		return isset($allow[$method]) ? ($allow[$method] == $type) : false;
	}

	/**
	 * Monta a resposta REST FULL API
	 * @param $classnick
	 * @param $response
	 */
	private static function makeJsonResponse($classnick, $response)
	{
		header('Content-Type: application/json');
		echo json_encode([
			"header" => [
				"version" => "0.1",
				"time" => time()
			],
			$classnick => $response
		]);
	}
}