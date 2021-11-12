<div class="main">

    <div class="header">
        <div class="inputs">
            Código: <input type="text" maxlength="4" size="2" id="cod">
        </div>
        <div class="inputs">
            Nome: <input type="text" maxlength="60" size="26" readonly="true" id="nome">
        </div>
        <div class="inputs">
            Frases Válidas: <input type="text" maxlength="1" readonly="true" id="frases">
        </div>
    </div>
    <div class=desc>
        <h2>Exercício <span id=exercicio></span></h2>
        <p>
            Escreva a frase descrita abaixo 5 vezes<br>
            <span class=obs>Obs: se houverem erros na digitação, a linha deverá ser digitada novamente.</span>
        </p>
    </div>
    <div class="campos">
        <div class="exercicio">
            <div id="frase" style="-webkit-user-select: none;   
  -moz-user-select: none;      
  -ms-user-select: none;       
  user-select: none;"></div>

            <input type="text" id="input">
        </div>

        <div class=historico style="-webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;">
            <span id=erros></span>
        </div>
    </div>
</div>

<?php startHtml("js"); ?>
<script src="assets/js/main.js" type="text/javascript"></script>
<script>
    $(function() {
        $(document).keyup(function(e) {
            if (e.key === "Escape") {
                $("#cod").val("")
                $("#cod").focus();
                return;
            }
        });
        $("#cod").focus();
        var $cod = $("#cod");
        var $input = $("#input");
        var exercicio;
        var frase;
        var frases;

        $cod.keyup(function() {
            getCod();
        })
        getCod();

        function getCod() {
            if (($cod.val().length) != 4) {
                return;
            }
            var config = {
                "cod": $cod.val()
            };
            $.post("source/aluno.php", config, function(data) {
                data = JSON.parse(data);
                if (data.erro) {
                    $("#cod").addClass("codErrado");
                    return;
                } else {
                    setTimeout(function() {
                        $("#cod").removeClass("codErrado");
                    }, 1000);
                }

                var nome = data.nome;
                exercicio = data.exercicio;
                frases = data.frases;
                $("#nome").val(nome);
                $("#exercicio").text(exercicio);
                $("#frases").val(frases);
                $("#input").focus();

                var width = $("#nome").val().length * 12
                $("#nome").css({
                    'width': width + 40 + 'px'
                })
                config = {
                    "exercicio": exercicio,
                    "cod": $("#cod").val()
                };
                $.post("source/exercicio.php", config, function(data) {
                    data = JSON.parse(data);
                    frase = data.frase;
                    $("#frase").text(frase);
                    var newWidth = $("#frase").outerWidth();
                    //alert(newWidth)
                    $("#input").css({
                        'width': newWidth + 'px'
                    })
                    $(".historico").css({
                        'width': newWidth + 'px'
                    })
                });




            });
        }

        $input.bind("input", function(e) {
            prevent();
            input = e.currentTarget.value;
            console.log(input);
            var config = {
                "input": input,
                "exercicio": exercicio,
                "frases": frases,
                "cod": $cod.val()
            }
            $.post("source/verify.php", config, function(data) {
                data = JSON.parse(data);
                situacao = data.situacao;
                if (situacao == "errado") {
                    $("#erros").prepend($input.val() + "<br>");
                    $input.val("");
                    $input.addClass("errado");
                    setTimeout(function() {
                        $input.removeClass("errado");
                    }, 500);
                }
                if (situacao == "fim") {
                    $input.val("");
                    getCod();

                }

            });
        });
    });
</script>
<?php endHtml(); ?>