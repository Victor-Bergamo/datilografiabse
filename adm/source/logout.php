<?php
session_start();

$_SESSION["adm"] = false;
header("Location: ../../index.php?pg=exercicios");
