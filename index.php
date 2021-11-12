<?php
require __DIR__ . "/source/functions.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<!-- ?ts=<?= time() ?> -->

<head>
    <link rel="stylesheet" href="assets/css/exercicios.css?ts=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/textos.css">
    <link rel="stylesheet" href="assets/css/ranking.css?ts=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/style.css?ts=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/cadastro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:site_name" content="Brasil Sul educacional - Datilografia">
    <meta property="og:title" content="Brasil Sul educacional - Datilografia" />
    <meta property="og:description" content="Realize exercícios de datilografia para aprimorar a posição e velocidade na hora da digitação" />
    <meta property="og:image" itemprop="image" content="./assets/images/type.svg">
    <meta property="og:type" content="website" />

    <title>Datilografia</title>
</head>

<body>
    <script src="assets/js/jquery.min.js"></script>
    <header>
        <nav class="navbar">
            <ul class="navbar-menu">
                <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "home" ? "active" : "") ?>" href="?pg=home"> <b>Datilografia </b> </a></li>
                <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "speedtype" ? "active" : "") ?>" href="?pg=speedtype">Teste de digitação</a></li>
                <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "ranking" ? "active" : "") ?>" href="?pg=ranking">Ranking <i class="fas fa-trophy"></i></a></li>
                <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "exercicios" ? "active" : "") ?>" href="?pg=exercicios">Exercícios <i class="fas fa-keyboard"></i></a></li>
                <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "textos" ? "active" : "") ?>" href="?pg=textos">Textos <i class="fas fa-text-height"></i> </a></li>
                <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "cadastro" ? "active" : "") ?>" href="?pg=cadastro">Faça seu cadastro <i class="fas fa-user-plus"></i> </a></li>
            </ul>
            <ul class="navbar-menu menu-right">
                <li><a href="adm/index.php">Adm <i class="fas fa-user-lock"></i></a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="container">
            <?php
            if (!empty($_GET["pg"])) {
                require __DIR__ . "/{$_GET["pg"]}.php";
            } else {
                require __DIR__ . "/home.php";
            }
            ?>

        </div>
    </main>
    <footer>
    </footer>
    <script>
        // $(function() {});
        const theme = localStorage.getItem("theme");

        if (theme) {
            document.documentElement.classList.add(theme);
        }

        function toggleTheme() {
            document.documentElement.classList.toggle("dark");

            var className = document.documentElement.className;

            localStorage.setItem("theme", className);
        }
    </script>
    <?= insert("js") ?>
</body>

</html>