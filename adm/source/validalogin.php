<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require "../source/banco.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    session_start();
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    $senha = $_POST['senha'];
    $query = $mysqli->query("SELECT senha FROM adm WHERE id = 1");
    $row = $query->fetch_assoc();

    if ($senha == $row["senha"]) {
        $_SESSION["adm"] = true;
        header("Location: ../adm.php?pg=exercicios");
    } else {

        header("Location: ../index.php");
    }
}
