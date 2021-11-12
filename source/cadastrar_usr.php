<?php

require __DIR__ . "/gerar_codigo.php";
require __DIR__ . "/banco.php";

if (!empty($_POST) && empty($_COOKIE["register"])) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED);

    $regex = "/^[a-z ,.'-]+$/i"; // validar nome
    $erros = [];

    if (empty($_POST["nome"]) || !preg_match($regex, $_POST["nome"])) {
        $erros["mensagem"]["nome"] = "Digite um nome para continuar";
    }

    if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $erros["mensagem"]["email"] = "Digite um E-mail válido";
    }

    if (!empty($erros)) {
        echo json_encode($erros);
        return;
    }

    $emailExists = $mysqli->query("SELECT * FROM cadastro_tmp WHERE email = '{$_POST["email"]}'");

    if ($emailExists->num_rows) {
        $erros["mensagem"]["email"] = "E-mail já cadastrado.";

        echo json_encode($erros);
        return;
    }

    $codigo = generatePassword();
    $sql = "INSERT INTO cadastro_tmp (cod, email, nome, exercicio, frases) 
            VALUES ('{$codigo}', '{$_POST["email"]}', '{$_POST["nome"]}', 1, 1)";

    $newRegister = $mysqli->query($sql);


    $email = "contato@brasilsuleducacional.com.br";
    $para = $_POST["email"];
    $assunto = "Código de entrada para Datilografia";
    $mensagem = "
        <h1>
            Seu código é <br>
            <span style='color: rgb(149, 149, 149)'>{$codigo}</span>
        </h1>
        <p>Para acessar <a href='http://datilografia.brasilsuleducacional.com.br/?pg=exercicios'>Clique aqui</a>.</p>";
    $headers = "From:" . $email . "\n";
    $headers .= "Content-type: text/html; charset=utf-8\n";

    mail($para, $assunto, $mensagem, $headers);

    // criar cookie para nunca fazer mais de um cadastro dentro de 10 dias
    setcookie('register', true, (time() + (10 * 24 * 3600)));

    echo json_encode(["mensagem" => [
        "tipo" => "sucesso",
        "codigo" => $codigo
    ]]);
    return;
}

echo json_encode(["mensagem" => [
    "tipo" => "erro",
    "codigo" => "ERRO"
]]);
