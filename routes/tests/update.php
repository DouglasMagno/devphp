<?php
// teste para atualizar um usuário
$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "http://localhost/library/routes/books/update.php",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => array('title' => 'Sapiens','author' => 'Yuval Noah Harari','edition' => '1','qtd' => '2','id' => '1'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
