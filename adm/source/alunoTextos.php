<?php

require __DIR__ . "/banco.php";


if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    $cod = $_POST['cod'];
    $query = $mysqli->query("SELECT * FROM alunos_textos WHERE cod = '{$cod}'");
    $row = $query->fetch_assoc();
    if ($query->num_rows === 0) {
        $response = [
            "erro" => true
        ];
        echo json_encode($response);
        return;
    }

    $response = [
        "nome" => $row["nome"],
        "exercicio" => $row["exercicio"],
        "texto" => $row["texto"]
    ];
    echo json_encode($response);
    return;
}
