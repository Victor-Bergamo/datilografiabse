<?php

require __DIR__ . "/banco.php";


if (!empty($_POST)) {
    //$_POST[$cod] = filter_var_array($_POST[$cod], FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    $table = (filter_var($_POST['cod'], FILTER_VALIDATE_INT) ? "alunos" : "cadastro_tmp");
    $cod = $_POST['cod'];
    $input = $_POST['input'];

    $query = $mysqli->query("SELECT exercicio, frases FROM {$table} WHERE cod = '{$cod}'");
    $row = $query->fetch_assoc();

    $exercicio = $row['exercicio'];
    $frases = $row['frases'];

    $query = $mysqli->query("SELECT frases FROM exercicios WHERE exercicio = '{$exercicio}'");
    $row = $query->fetch_assoc();

    $frase = $row["frases"];
    $cont = strlen($input);
    $comp = substr($frase, 0, $cont);

    if ($frase == $input && $frases == 4) {
        $frases = 0;
        $exercicio++;
        $query = $mysqli->query("UPDATE {$table} SET frases=$frases, exercicio=$exercicio WHERE cod='{$cod}'");
        $response = [
            "situacao" => "fim"
        ];
        echo json_encode($response);
        return;
    }
    if ($frase == $input) {
        $frases++;
        $query = $mysqli->query("UPDATE {$table} SET frases=$frases WHERE cod='{$cod}'");
        $response = [
            "situacao" => "fim"
        ];
        echo json_encode($response);
        return;
    }
    if ($comp != $input) {
        $situacao = "errado";
    } else {
        $situacao = "correto";
    }
    $response = [
        "situacao" => $situacao
    ];
    echo json_encode($response);
    return;
}
