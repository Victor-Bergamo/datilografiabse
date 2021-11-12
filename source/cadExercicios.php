<?php
require __DIR__ . "/banco.php";


if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select
    $cod = $_POST["cod"];
    $nome = $_POST["nome"];
    $exercicio = $_POST["exercicio"];
    $frases = $_POST["frases"];
    $query = $mysqli->query("SELECT nome FROM alunos WHERE cod='{$cod}'");
    $row = $query->fetch_assoc();
    $existe = mysqli_num_rows($row);
    if ($existe > 0) {
        $response = [
            "situacao" => "existe"
        ];
        echo json_encode($response);
        return;
    }

    $query = $mysqli->query("INSERT INTO alunos(id, cod, nome, exercicio, frases) VALUES (0, '{$cod}','{$nome}','{$exercicio}','{$frases}')");
    $row = $query->fetch_assoc();
    if ($row) {
        $response = [
            "situacao" => "sucesso"
        ];
    } else {
        $response = [
            "situacao" => "erro"
        ];
    }
    echo json_encode($response);
    return;
}
