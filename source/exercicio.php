<?php

require __DIR__ . "/banco.php";


if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    if (!filter_var($_POST["cod"], FILTER_VALIDATE_INT)) {
        $cod = $_POST["cod"];

        $user = $mysqli->query("SELECT * FROM cadastro_tmp WHERE cod = '{$cod}'");
        $current = $user->fetch_assoc()["exercicio"];

        if ($current > 3) {
            $response = [
                "frase" => "Você está limitado à 5 exercícios, entre em contato com a Brasil Sul Educacional",
                "limite" => true
            ];
            echo json_encode($response);
            return;
        }
    }

    $exercicio = $_POST['exercicio'];
    $query = $mysqli->query("SELECT frases FROM exercicios WHERE exercicio = '{$exercicio}'");
    $row = $query->fetch_assoc();
    $response = [
        "frase" => $row["frases"]
    ];
    echo json_encode($response);
    return;
}
