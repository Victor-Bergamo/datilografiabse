<?php
require __DIR__ . "/source/banco.php";
$query = $mysqli->query("SELECT texto FROM textos WHERE id = '1'");
$row = $query->fetch_assoc();
$input = $_POST["input"];

echo similar_text($row["texto"], $var2);
echo " de";
echo strlen($row["texto"]);
