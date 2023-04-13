<?php

header('Access-Control-Allow-Origin: *');
# cria uma conexão com o banco de dados MySQL 
$connect = new PDO("mysql:host=localhost;dbname=id19855106_pontos_fatec", "id19855106_hespanholo", "&>EFYS)Sus9mayP)");

$received_data = json_decode(file_get_contents("php://input"));

# cria um array vazio para armazenar os resultados da consulta
$data = array();

if($received_data->query != '') # verifica se a propriedade query do objeto 
								# $received_data é diferente de uma string vazia.
{
	#  constrói uma consulta SQL para buscar registros na tabela
	$query = "
	SELECT * FROM fatec_professores 
	WHERE salario LIKE '%".$received_data->query."%' 
	ORDER BY salario DESC
	";
}
else	# caso a propriedade query seja uma string vazia, executa uma
		# consulta SQL que retorna todos os registros da tabela fatec_professores.
{
	$query = "
	SELECT * FROM fatec_professores 
	ORDER BY salario DESC
	";
}

$statement = $connect->prepare($query);

$statement->execute();

# inicia um loop que percorre cada registro retornado pela consulta SQL
while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row; # adiciona cada regristo no array
}

# converte o array $data em formato JSON e envia como resposta para a requisição.
echo json_encode($data); 

?>