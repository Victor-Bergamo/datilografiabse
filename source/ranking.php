<?php

require __DIR__ . "/banco.php";

if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    if (!empty($_POST["type"])) {
        $query = $mysqli->query("SELECT * FROM alunos WHERE id = {$_POST["idAluno"]}");
        $row = $query->fetch_assoc();
        echo json_encode($row);
        return;
    }

    $month = (!empty($_POST["month"]) ? $_POST["month"] : date("m"));
    $year = date("Y");

    $query = $mysqli->query("SELECT * FROM ranking WHERE dificuldade = '{$_POST["difficult"]}' AND MONTH(realizado_em) = '{$month}' AND YEAR(realizado_em) = '{$year}' ORDER BY ppm DESC");
    $row = $query->fetch_all(MYSQLI_ASSOC);
    //var_dump($row);
    echo json_encode($row);
}
