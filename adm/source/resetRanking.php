<?php

require __DIR__ . "/banco.php";

if (!empty($_POST)) {
    if (!empty($_POST["type"]) && $_POST["type"] == "getPlayers") {
        $query = $mysqli->query("SELECT * FROM ranking");
        $result = $query->fetch_all(MYSQLI_ASSOC);

        echo json_encode(["alunos" => $result]);
        return;
    }

    if (!empty($_POST["type"]) && $_POST["type"] == "updateDate") {
        $query = $mysqli->query("SELECT * FROM ranking_resets ORDER BY feito_em DESC LIMIT 1");
        $date = $query->fetch_assoc();

        echo json_encode(["date" => $date]);
        return;
    }

    $query = $mysqli->query("SELECT * FROM ranking");
    foreach ($query->fetch_all(MYSQLI_ASSOC) as $fetch) {
        $insert = $mysqli->query("INSERT INTO ranking_antigo (id_aluno, ppm, precisao, dificuldade, realizado_em) 
    VALUES ({$fetch["id_aluno"]}, {$fetch["ppm"]}, {$fetch["precisao"]}, '{$fetch["dificuldade"]}', '{$fetch["realizado_em"]}')");
    }

    $log = $mysqli->query("INSERT INTO ranking_resets (realizado_por) VALUES ('{$_SERVER["HTTP_USER_AGENT"]}')");

    $delete = $mysqli->query("DELETE FROM ranking WHERE 1 = 1");
    echo json_encode(["mensagem" => $delete]);
}
