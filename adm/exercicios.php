<?php
if (!isset($_SESSION["adm"]) || $_SESSION["adm"] == false) {
    header("Location: index.php");
    return;
}
?>

<div class="content">
    <form>
        <div class="form">

            <div class="form-header">
                <h2>Exercícios</h2>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <div class="col col-small">
                        <div class="label">
                            <label for="cod">Código:</label>
                        </div>
                        <input class="input-small" type="text" id="cod">
                    </div>
                    <div class="col">
                        <div class="label">
                            <label for="nome">Nome:</label>
                        </div>
                        <input type="text" id="nome">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-small">
                        <div class="label">
                            <label for="exercicio">Exercício:</label>
                        </div>
                        <input class="input-small" type="text" id="exercicio" value="1">
                    </div>
                    <div class="col">
                        <div class="label" style="width: 150px;">
                            <label for="frases">Frases Válidas:</label>
                        </div>
                        <input type="text" id="frases" value="0">
                    </div>
                </div>
            </div>
            <div class="form-footer">
                <div class="form-button-group">
                    <button id="cadastrar">Cadastrar</button>
                    <button id="alt">Alterar</button>
                    <button id="exc">Excluir</button>
                    <button type="reset">Limpar</button>
                </div>
            </div>

        </div>
    </form>
</div>
<!--<center>
        <form>
            <h1 style=font-family:Ubuntu;color:dimgray>Exercícios</h1>
            <table cellpadding=7px; style="border:1px solid black;font-family:Ubuntu;">
                <tr>
                    <td colspan=2>Código: <input type=text id=cod size=4> &nbsp;&nbsp;&nbsp;Nome: <input type=text id=nome size=37></td>
                </tr>
                <tr>
                    <td>Exercicio: <input type=text id=exercicio size=4 value=1></td>
                    <td rowspan=2 style=text-align:center;><img src=../assets/images/logo.png width=200px height=100px> </td>
                </tr>
                <tr>
                    <td>Frases Válidas: <input type=text id=frases size=3 value=0></td>
                </tr>
            </table><br>
            <input type=button id=cadastrar value=Cadastrar>
            <input type=button id=alt value=Alterar>
            <input type=button id=exc value=Excluir>
            <input type=reset value=Limpar>
        </form>
    </center> -->
<script>
    $(function() {
        $("form").submit(function(e) {
            e.preventDefault();
        });

        $("input").each(function(i, e) {
            if ($(this).val()) {
                $(this).siblings().addClass("up");
            }
        });

        $("input").on("focus blur", function() {
            var $input = $(this);

            if (!$input.val()) {
                $input.siblings().toggleClass("up");
            }
        });

        $("#cod").focus();
        var cod;
        var nome;
        var exercicio;
        var frases;
        var config;
        $("#cadastrar").click(function() {
            cadastrar();
        })
        $("#alt").click(function() {
            alterar();
        })
        $("#exc").click(function() {
            excluir();
        })
        $("#cod").keyup(function() {
            aluno();
        })

        function aluno() {
            if (($("#cod").val().length) != 4) {
                return;
            }
            var config = {
                "cod": $("#cod").val()
            };
            $.post("source/aluno.php", config, function(data) {
                data = JSON.parse(data);
                if (!data.erro) {
                    var nome = data.nome;
                    exercicio = data.exercicio;
                    frases = data.frases;
                    $("#nome").val(nome);
                    $("#exercicio").val(exercicio);
                    $("#frases").val(frases);
                } else {
                    $("#nome").val("");
                    $("#exercicio").val("1");
                    $("#frases").val("0");
                    $("#nome").focus();
                }

                $("input").each(function(i, e) {
                    if ($(this).val()) {
                        $(this).siblings().addClass("up");
                    }
                });

            });
        }

        function cadastrar() {
            cod = $("#cod").val();
            nome = $("#nome").val();
            exercicio = $("#exercicio").val();
            frases = $("#frases").val();
            config = {
                "cod": cod,
                "nome": nome,
                "exercicio": exercicio,
                "frases": frases
            }
            $.post("source/cadExercicios.php", config, function(data) {
                data = JSON.parse(data);
                if (data.situacao == "sucesso") {
                    alert("Aluno cadastrado com sucesso!");
                } else if (data.situacao == "erro") {
                    alert("Erro ao cadastrar aluno.");
                } else if (data.situacao == "existe") {
                    alert("Aluno já existe.");
                } else {
                    alert("Erro desconhecido.");
                }

            });
        }

        function excluir() {
            cod = $("#cod").val();
            config = {
                "cod": cod
            }
            $.post("source/excluir.php", config, function(data) {
                data = JSON.parse(data);
                if (data.situacao == "sucesso") {
                    alert("Aluno excluído com sucesso!");
                    $("#cod").val("");
                    $("#nome").val("");
                    $("#exercicio").val("1");
                    $("#frases").val("0");
                    $("#cod").focus();
                } else {
                    alert("Erro ao excluir aluno.");
                }
            })
        }

        function alterar() {
            cod = $("#cod").val();
            nome = $("#nome").val();
            exercicio = $("#exercicio").val();
            frases = $("#frases").val();
            config = {
                "cod": cod,
                "nome": nome,
                "exercicio": exercicio,
                "frases": frases
            }
            $.post("source/alterar.php", config, function(data) {
                data = JSON.parse(data);
                if (data.situacao == "sucesso") {
                    alert("Aluno alterado com sucesso!");
                } else if (data.situacao == "erro") {
                    alert("Erro ao alterar aluno.");
                } else if (data.situacao == "n_existe") {
                    alert("Aluno não existe.");
                } else {
                    alert("Erro desconhecido.");
                }

            });
        }
    });
</script>