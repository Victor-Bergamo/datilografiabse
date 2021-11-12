<div class="content">
    <form>
        <div class="form">
            <div class="form-header"></div>
            <div class="form-body">
                <div class="form-group">
                    <div class="col" style="width: 100px; padding-right: 10px;">
                        <div class="label">
                            <label for="cod">Código:</label>
                        </div>
                        <input type=text id=cod>
                    </div>
                    <div class="col" style="padding-right: 10px;">
                        <div class="label">
                            <label for="nome">Nome:</label>
                        </div>
                        <input type=text id=nome>
                    </div>
                    <div class="col" style="width: 150px;">
                        <div class="label">
                            <label for="texto">Texto:</label>
                        </div>
                        <input type=text id=texto value=1>
                    </div>
                </div>
            </div>
            <div class="form-footer">
                <button id="cadastrar">Cadastrar</button>
                <button id="alt">Alterar</button>
                <button id="exc">Excluir</button>
                <button type="reset" id="limpar">Limpar</button>
            </div>
        </div>
    </form>
</div>
<!-- 

<h1 style=font-family:Ubuntu;color:dimgray>Textos</h1>
        <table cellpadding=7px; style="border:1px solid black;font-family:Ubuntu;">
            <tr>
                <td colspan=2>Código: <input type=text id=cod size=4> &nbsp;&nbsp;&nbsp;Nome: <input type=text id=nome size=37></td>
            </tr>
            <tr>
                <td>Texto: <input type=text id=texto size=4 value=1></td>
                <td rowspan=2 style=text-align:center;><img src=../assets/images/logo.png width=200px height=100px> </td>
            </tr>

        </table><br>
        <input type=button id=cadastrar value=Cadastrar>
        <input type=button id=alt value=Alterar>
        <input type=button id=exc value=Excluir>
        <input type=reset value=Limpar>

-->
<script>
    $(function() {
        $("form").submit(function(e) {
            e.preventDefault();
        });

        $("#limpar").on("click", function(e) {
            $("input#cod, input#nome").siblings().removeClass("up");
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
        var texto;
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
            $.post("source/alunoTextos.php", config, function(data) {
                data = JSON.parse(data);
                if (!data.erro) {
                    var nome = data.nome;
                    texto = data.texto;
                    $("#nome").val(nome);
                    $("#texto").val(texto);
                } else {
                    $("#nome").val("");
                    $("#texto").val("1");
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
            texto = $("#texto").val();
            config = {
                "cod": cod,
                "nome": nome,
                "texto": texto
            }
            $.post("source/cadTextos.php", config, function(data) {
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
            $.post("source/excluirTextos.php", config, function(data) {
                data = JSON.parse(data);
                if (data.situacao == "sucesso") {
                    alert("Aluno excluído com sucesso!");
                    $("#cod").val("");
                    $("#nome").val("");
                    $("#texto").val("1");
                    $("#cod").focus();
                } else {
                    alert("Erro ao excluir aluno.");
                }
            })
        }

        function alterar() {
            cod = $("#cod").val();
            nome = $("#nome").val();
            texto = $("#texto").val();
            config = {
                "cod": cod,
                "nome": nome,
                "texto": texto
            }
            $.post("source/alterarTextos.php", config, function(data) {
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