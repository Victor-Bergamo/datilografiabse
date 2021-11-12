<?php

require __DIR__ . "/banco.php";


if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    $textoN = $_POST['textoN'];
    $query = $mysqli->query("SELECT texto FROM textos WHERE id = '{$textoN}'");
    $row = $query->fetch_assoc();
    $response = [
        "texto" => $row["texto"]
    ];
    echo json_encode($response);
    return;
}
