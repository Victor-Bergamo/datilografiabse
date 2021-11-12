<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["adm"]) || $_SESSION["adm"] == false) {
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<script src="../assets/js/jquery.min.js" type=text/javascript> </script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/adm.css">
    <title>Adm</title>
</head>

<style>
    body {
        margin: 0px;
    }

    .menu {
        background-color: #ebebeb;
        overflow: hidden;
        position: absolute;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .menu a {
        display: inline-block;
        text-align: center;
        background-color: #dbdbdb;
        margin: 0px;
        padding: 20px;
        font-size: 16px;
        color: #414141;
        font-family: Ubuntu;
        font-weight: bold;
        float: left;
        text-decoration: none;
    }

    .menu a:hover {
        background-color: #d1d1d1;
    }

    .center {
        margin: auto;
    }

    button:disabled {
        background-color: #4379c9 !important;
    }

    textarea:focus {
        border-color: #3f7bd6;
    }

    textarea {
        border: none;
        outline: none;
        border: solid #e3e3e3 3px;
        border-radius: 6px;
        box-sizing: border-box;
        width: 100%;
        /*background-color: #e3e3e3;*/
        padding: 10px;
        transition: border-color .3s;
        font-size: .8em;
        font-family: Montserrat;
        resize: none;
    }

    .difficult-options {
        display: flex;
        justify-content: space-between;
    }

    .difficult-options label {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: row-reverse;
        position: relative;
        margin-bottom: 12px;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .difficult-options label input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {

        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 5px;
        height: 15px;
        width: 15px;
        background-color: #eee;
        border-radius: 50%;
    }

    .difficult-options label:hover input~.checkmark {
        background-color: #ccc;
    }

    .difficult-options label input:checked~.checkmark {
        background-color: #3f7bd6;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .difficult-options label input:checked~.checkmark:after {
        display: block;
    }

    .difficult-options label .checkmark:after {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: white;
    }
</style>

<body>
    <div class=menu>
        <div class=center>
            <a href="?pg=exercicios">Exercicios</a>
            <a href="?pg=textos">Textos</a>
            <a href="?pg=ranking">Ranking</a>
            <a href="?pg=speed_type">Teste de Digitação</a>
            <a href="source/logout.php" id=sair style="background-color:#414141;color:#ebebeb;">Sair</a>
        </div>
    </div>
    <?php
    if (!empty($_GET["pg"])) {
        require __DIR__ . "/{$_GET["pg"]}.php";
    }
    ?>
    <script>
        $(function() {
            /*$(window).bind("beforeunload", function(e) {
                e.preventDefault();
                $.post("source/logout.php", {}, function(data) {

                });
                window.close();
            })*/
        })
    </script>
</body>

</html>