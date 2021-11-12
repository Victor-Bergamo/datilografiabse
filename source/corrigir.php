<?php

require __DIR__ . "/banco.php";


if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select
    $cod = $_POST['cod'];
    $input = $_POST['input'];
    $query = $mysqli->query("SELECT texto FROM alunos_textos WHERE cod = '{$cod}'");
    $row = $query->fetch_assoc();
    $textoN = $row['texto'];
    $query = $mysqli->query("SELECT texto FROM textos WHERE id = '{$textoN}'");
    $row = $query->fetch_assoc();
    $texto = $row["texto"];
    $texto = trim($texto);
    $texto = str_replace('"', '', $texto); //tira as aspas do texto pois é removida do texto também por segurança
    $entersTexto = substr_count($texto, "\n");
    $entersInput = substr_count($input, "\n");
    $enters = $entersTexto - ($entersTexto - $entersInput);
    $chrIguais = similar_text($texto, $input);
    $total = strlen($texto);

    $diferenca = $total - ($chrIguais + $enters);


    if ($diferenca > 5) {
        $situacao = "errado";
    } else {
        $situacao = "correto";
        $textoN++;
        $query = $mysqli->query("UPDATE alunos_textos SET texto='{$textoN}', digitado='' WHERE cod='{$cod}'");
    }
    $response = [
        "situacao" => $situacao,
        "diferenca" => $diferenca
    ];
    echo json_encode($response);
    return;
}
