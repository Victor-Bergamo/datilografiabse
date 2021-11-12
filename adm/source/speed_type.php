<?php

require __DIR__ . "/banco.php";

if (!empty($_POST)) {
    $difficulty = $_POST["difficulty"];
    $text = $_POST["speedText"];

    if (!$difficulty) {
        $difficulty = "easy";
    }

    $text = trim($text);

    if ($text) {
        $newText = $mysqli->query("INSERT INTO test_texts (text, difficult) VALUES ('{$text}', '{$difficulty}')");

        if ($newText) {
            echo json_encode(["mensagem" => "Texto cadastrado com sucesso!"]);
            return;
        }

        echo json_encode(["mensagem" => "Houve um erro ao tentar cadastrar. Tente novamente mais tarde!"]);
        return;
    }

    echo json_encode(["mensagem" => "Houve um erro ao tentar cadastrar. Adicione um texto para completar o cadastro!"]);
    return;
}
