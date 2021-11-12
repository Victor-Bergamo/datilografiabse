<?php

require __DIR__ . "/banco.php";


if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    $cod = $_POST['cod'];

    if (!filter_var($cod, FILTER_VALIDATE_INT)) {
        $query = $mysqli->query("SELECT * FROM cadastro_tmp WHERE cod = '{$cod}'");
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
            "frases" => $row["frases"]
        ];
        echo json_encode($response);
        return;
    }

    $query = $mysqli->query("SELECT * FROM alunos WHERE cod = '{$cod}'");
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
        "frases" => $row["frases"]
    ];
    echo json_encode($response);
    return;
}
