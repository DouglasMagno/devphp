<?php
// chamada de teste para criação de usuário
$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "http://localhost/library/routes/books/create.php",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => array('title' => 'teste','author' => '222','edition' => '1','qtd' => '1'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
