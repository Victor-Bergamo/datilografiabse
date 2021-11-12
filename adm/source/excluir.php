<?php

require __DIR__ . "/banco.php";


if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    $cod = $_POST['cod'];

    $query = $mysqli->query("DELETE FROM alunos WHERE cod = {$cod}");

    if ($query) {
        $response = [
            "situacao" => "sucesso"
        ];
    }
    echo json_encode($response);
    return;
}
