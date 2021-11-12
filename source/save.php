<?php

require __DIR__ . "/banco.php";


if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select
    $cod = $_POST['cod'];
    $input = $_POST['input'];
    $query = $mysqli->query("UPDATE alunos_textos SET digitado='{$input}' WHERE cod = '{$cod}'");
    return;
}
