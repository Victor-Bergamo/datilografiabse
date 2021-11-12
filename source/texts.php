<?php

require __DIR__ . "/banco.php";

if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    if (!empty($_POST["ranking"])) { //se finalizou o teste
        $codigo = $_POST["ranking"]["codigo"]; // acessa o código
        $validStudent = $mysqli->query("SELECT * FROM alunos WHERE cod = '{$codigo}'"); // busca pelo código

        if ($codigo == "0000") {
            return;
        }

        if ($validStudent->num_rows) {
            $data = date("Y-m-d H:i:s"); // data em que foi feito o record
            $month = date("m");

            $ranking = $_POST["ranking"];
            $ranking["precisao"] = str_replace("%", "", $ranking["precisao"]); // remover "%"

            $aluno = $validStudent->fetch_assoc(); // pega as informações do aluno

            $lastRank = $mysqli->query("SELECT * FROM ranking WHERE id_aluno = '{$aluno["id"]}' 
                                        AND dificuldade = '{$ranking["dificuldade"]}' AND MONTH(realizado_em) = '{$month}'"); // pega o ranking com base na dificuldade

            // se já esta no ranking
            if ($lastRank->num_rows) {
                $row = $lastRank->fetch_assoc();

                if ($row["ppm"] < $ranking["ppm"]) {
                    $sql = "UPDATE ranking SET 
                            ppm = {$ranking["ppm"]}, 
                            precisao = {$ranking["precisao"]}
                            WHERE id_aluno = {$aluno["id"]} 
                            AND dificuldade = '{$ranking["dificuldade"]}'
                            AND MONTH(realizado_em) = '{$month}'";
                    $updateRanking = $mysqli->query($sql);
                    echo json_encode(["message" => $updateRanking]);
                    return;
                }

                return;
            }

            $sql = "INSERT INTO ranking (id_aluno, ppm, precisao, dificuldade)
                    VALUES ({$aluno["id"]}, 
                    {$ranking["ppm"]}, 
                    {$ranking["precisao"]}, 
                    '{$ranking["dificuldade"]}')";
            $newRanking = $mysqli->query($sql);

            echo json_encode(["mensagem" => "Opa, você está no ranking agora!"]);

            return;
        }

        return;
    }

    if (!empty($_POST["codigo"])) { // se tiver o código no post
        $codigo = $_POST["codigo"];

        $validStudent = $mysqli->query("SELECT * FROM alunos WHERE cod = '{$codigo}'");

        if ($validStudent->num_rows) {
            echo json_encode(["message" => $_POST["codigo"]]);
            return;
        }

        echo json_encode([
            "message" => "codigo errado",
            "type" => "error"
        ]);
        return;
    }

    $difficult = $_POST['difficult'];

    $query = $mysqli->query("SELECT * FROM test_texts WHERE difficult = '{$difficult}' ORDER BY RAND() LIMIT 1");
    $row = $query->fetch_assoc();

    $response = [
        "text" => $row["text"],
    ];
    echo json_encode($response);
    return;
}
