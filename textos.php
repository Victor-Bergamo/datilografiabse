<div class=main>
    <div class=headerTextos>
        <label id=codigo>Código:<input type=text id=cod></label>
        <label>Nome:<input type=text id=nome></label>
    </div>

    <div class=textos>

        <div class=campos>
            <h2>Texto <span id=textoN></span></h2>
            <div class=texto>
                <textarea rows=25 cols=45 id=texto></textarea>
            </div>
            <div class=texto>
                <textarea rows=25 cols=45 id=input></textarea>
            </div>
            <div id=erro class=erro>Seu texto digitado está incompleto, ou possui mais de cinco erros!</div>
        </div>
        <div class=enviar>
            <input type=button id=enviar value="Próximo Texto ➤">
        </div>

    </div>
</div>

<?php startHtml("js"); ?>

<script src="assets/js/main.js" type=text/javascript> </script>
<script src="assets/js/jqueryRedirect.js"></script>
<script>
    $(function() {

        $("#cod").focus();
        $("#texto").prop("readonly", true);
        var $cod = $("#cod");
        $cod.keyup(function() {
            getCod();
        })
        getCod();
        $("#enviar").click(function() {
            corrigir();
        })
        var texto;
        var digitado;

        function getCod() {
            if (($cod.val().length) != 4) {
                return;
            }
            var config = {
                "cod": $cod.val()
            };
            $.post("source/aluno_textos.php", config, function(data) {
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
                textoN = data.textoN;
                digitado = data.digitado;

                $("#nome").val(nome);
                $("#textoN").text(textoN);
                config = {
                    "textoN": textoN
                };

                var width = $("#nome").val().length * 12
                $("#nome").css({
                    'width': width + 40 + 'px'
                })
                $.post("source/texto.php", config, function(data) {
                    data = JSON.parse(data);
                    texto = data.texto;

                    $("#texto").val(texto)
                    if (digitado != "") {
                        $("#input").val(digitado);
                    }
                    $("#input").focus();
                });




            });
        };

        function corrigir() {
            var input = $("#input").val();
            input = input.trim()
            config = {
                "input": input,
                "cod": $cod.val()
            };
            $.post("source/corrigir.php", config, function(data) {
                data = JSON.parse(data);
                console.log(data);
                var situacao = data.situacao;
                if (situacao == "errado") {
                    $("#erro").fadeIn(250)
                    setTimeout(function() {
                        $("#erro").fadeOut(250);
                    }, 2500);
                } else {
                    getCod();
                    $("#input").val("");
                }
            });
        }
        setInterval(function() {
            var input = $("#input").val();
            input = input.trim();
            config = {
                "input": input,
                "cod": $cod.val()
            };
            $.post("source/save.php", config);
        }, 30000)
        $(document).bind('keyup', function(e) {
            if (e.ctrlKey) {
                e.preventDefault();
                return false;
            }
        });
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
        $('textarea').on("cut copy paste", function(e) {
            e.preventDefault();
        });
    });
</script>
<?php endHtml(); ?>