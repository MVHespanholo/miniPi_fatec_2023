<?php
header('Access-Control-Allow-Origin: *');

$connect = new PDO("mysql:host=localhost;dbname=id19855106_pontos_fatec", "id19855106_hespanholo", "&>EFYS)Sus9mayP)");
# Converter dados JSON recebidos em formato de string em objetos PHP
$received_data = json_decode(file_get_contents("php://input"));
$data = array();

# inicia uma instrução  baseada na propriedade "action" do objeto JSON recebido. 
# Neste caso, se "action" for "fetchall", a consulta SQL selecionará todos os alunos na 
# tabela "fatec_alunos" e os ordenará por ID em ordem decrescente
if ($received_data->action == 'fetchall') {
    $query = "
 SELECT * FROM fatec_alunos 
 ORDER BY id DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}
# Neste caso, se "action" for "insert", um array de dados é criado com as informações do primeiro e último nome do aluno. 
# Em seguida, é criada uma consulta SQL de inserção, onde os valores dos dados são vinculados aos marcadores de posição na consulta.
# Depois, o objeto PDOStatement é preparado com a consulta SQL e a função execute() é chamada com o array de dados para inserir um novo registro na tabela "fatec_alunos".
# Em seguida, um array de saída é criado com uma mensagem de confirmação informando que o aluno foi adicionado com sucesso, e este array é convertido em formato JSON e exibido no navegador.
if ($received_data->action == 'insert') {
    $data = array(
        ':first_name' => $received_data->firstName,
        ':last_name' => $received_data->lastName
    );

    $query = "
 INSERT INTO fatec_alunos 
 (first_name, last_name) 
 VALUES (:first_name, :last_name)
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Aluno Adicionado'
    );

    echo json_encode($output);
}
if ($received_data->action == 'fetchSingle') {
    $query = "
 SELECT * FROM fatec_alunos 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['first_name'] = $row['first_name'];
        $data['last_name'] = $row['last_name'];
    }

    echo json_encode($data);
}
# O código recupera o primeiro nome, o sobrenome e o ID do aluno a ser atualizado do objeto JSON
# e executa uma consulta de atualização na tabela 'fatec_alunos'
if ($received_data->action == 'update') {
    $data = array(
        ':first_name' => $received_data->firstName,
        ':last_name' => $received_data->lastName,
        ':id' => $received_data->hiddenId
    );

    $query = "
 UPDATE fatec_alunos 
 SET first_name = :first_name, 
 last_name = :last_name 
 WHERE id = :id
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Aluno Atualizado'
    );

    echo json_encode($output);
}
# executa uma consulta de exclusão na tabela 'fatec_alunos' para excluir o registro com o ID fornecido.
if ($received_data->action == 'delete') {
    $query = "
 DELETE FROM fatec_alunos 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Aluno Deletado'
    );

    echo json_encode($output);
}

?>