<div class="content">
    <div class="box">
        <div class="text-config">
            <div class="group-config">
                <span>Código:</span>
                <input type="text" id="codigo" maxlength="4">
            </div>
            <div class="group-config arrow">
                <span>Dificuldade:</span>
                <select id="difficult">
                    <option value="hard">Difícil</option>
                    <option value="medium">Médio</option>
                    <option value="easy" selected>Fácil</option>
                </select>
            </div>
            <div class="new-text-button">
                <button> <i class="fa fa-redo"></i> </button>
            </div>
        </div>
        <div class="message message-alert">
            <span>Digite seu código antes de começar</span>
        </div>
        <div class="text">
            <input type="text" name="text" id="user-type" autocomplete="off">
            <div class="circle-loader" style="width: 300px; display: flex; justify-content: center;">
                <div class="load"></div>
            </div>
            <div class="text-test">

            </div>
            <div class="text-status">
                <div class="status-wpm">
                    <h1 id="wpm">0</h1>
                    <span>PPM (PALAVRAS POR MINUTO)</span>
                </div>
                <div class="status-precision">
                    <h1 id="accuracy">100%</h1>
                    <span>Precisão</span>
                </div>
            </div>
        </div>
        <div class="text-footer" style="display: none;">
            <button class="text-restart">Começar Novamente</button>
        </div>
    </div>
</div>
<?php startHtml("js"); ?>
<script>
    $(function() {
        var startDate;
        var startType = false;
        var correctDigits = [];
        var wrongDigits = [];
        var $difficult = $("#difficult");
        var $type = $("#user-type");
        var $formSend = $("#sendWpm");
        var $display = $(".text-test");
        var $info = $(".info-no-focus");
        var $codigo = $("#codigo");
        var $message = $(".message");
        var $refresh = $(".new-text-button button");
        var $circleLoader = $(".circle-loader");

        function getText() {
            $type.prop("disabled", false);
            $display.html("");
            $circleLoader.show();

            startType = false; // limpa a digitação

            var config = {
                "difficult": $difficult.val()
            };

            $.post("source/texts.php", config, function(data) {
                data = JSON.parse(data);

                var words = data.text.split(" ");

                var letters = data.text.split("");

                $.each(letters, function(i, e) {
                    $display.append(`<span>${e}</span>`);
                });

                // adiciona a classe .current ao primeiro span
                $display.children().first().addClass("current");

                // limpa os digitos errados e os digitos certos
                correctDigits = [];
                wrongDigits = [];

                // limpa a precisão e as palavras por minuto
                $("#accuracy").text("100%");
                $("#wpm").text("0");

                // toda vez que for carregado um texto, limpa o setInterval()
                if (typeof toCalculate != "undefined") {
                    clearInterval(toCalculate);
                }

                // limpa o campo e adiciona o foco
                $type.val("");
                $type.focus();
                $refresh.prop("disabled", false);
                $circleLoader.hide();
            });
        }

        // valida o código
        function validateCodigo(codigo) {
            $.post("source/texts.php", {
                codigo: codigo
            }, function(response) {
                if (response.type == "error") {
                    $codigo.css("color", "rgb(199, 65, 65)");
                } else {
                    $codigo.css("color", "rgb(91, 170, 77)");
                    if ($codigo.val().length == 4) {
                        $codigo.blur();
                        $codigo.prop("disabled", true);
                        $message.remove();
                        getText();
                    }
                }
            }, "json");
        }

        $formSend.submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var $button = form.find("button");
            var $span = form.find("span");
            var $inputCodigo = form.find("input#codigo");
            var codigo = $inputCodigo.val();

            $button.text("Carregando...");

            $.post("source/texts.php", {
                "codigo": codigo
            }, function(response) {
                response = JSON.parse(response);
                if (response.type == "error") {
                    $span.text(response.message).show();
                    $span.addClass("error");
                    $inputCodigo.addClass("error");
                }

                $button.text("Enviar");

                console.log(response);
            });

        });

        // limpa qualquer caractere que não seja um número
        $codigo.keypress(function(e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
        });

        // pega o código
        $codigo.keyup(function(e) {
            validateCodigo($codigo.val())
        });

        $type.bind("input", function(e) {
            if (!startType) {
                startType = true;
                startDate = new Date();
                var seconds = 1;
                toCalculate = setInterval(function() {
                    var now = new Date();
                    var wpm = ((correctDigits.length / 5) / (seconds / 60)).toFixed(0);
                    var accuracy = (($display.text().trim().length - wrongDigits.length) / $display.text().trim().length) * 100
                    //console.log((new Date()).getSeconds());
                    //console.log((new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate())).getSeconds())
                    //console.log(now.getSeconds() - startDate.getSeconds())
                    $("#wpm").text(wpm);
                    if (accuracy >= 0) {
                        $("#accuracy").text(Math.round(accuracy) + "%");
                    }
                    seconds++;
                }, 1000);
            }

            var $current = $display.find(".current");
            var text = $display.text();
            var typeValue = e.currentTarget.value;
            var digit = typeValue[typeValue.length - 1];

            if ($current.text() == digit) {
                $display.children("span.current").addClass("is-correct");
                $current.removeClass("current");

                $current.removeClass("wrong");
                correctDigits.push(digit);

                // se acabou o teste
                if (!$current.next().is("span")) {
                    $type.prop("disabled", true); // desativa o campo

                    clearInterval(toCalculate);
                    startType = false;
                    $(".text-footer").show();
                    $display.hide(800);

                    // adicionar ao ranking
                    $.post("source/texts.php", {
                        ranking: {
                            codigo: $codigo.val(),
                            ppm: $("#wpm").text(),
                            precisao: $("#accuracy").text(),
                            dificuldade: $difficult.val()
                        }
                    }, function(response) {
                        console.log("resposta ranking");
                    });
                    return;
                }

                $current.next().addClass("current");

                return;
            }

            $current.addClass("wrong");
            wrongDigits.push(digit);

            //console.log(e.currentTarget.value)
        });

        /*$type.keyup(function(e) {
            var $current = $display.find(".current");
            var text = $display.text();
            var value = $(this).val();
            var key = e.keyCode || event.charCode || e.which;
            $type.val("");

            if (key == 16 || key == 17) {
                return;
            }

            if (value.length > 1) {

            }

            // console.log(key);

            // console.log($current.text() == value);

            if ($current.text() == value) {
                $display.children("span.current").addClass("is-correct");
                $current.removeClass("current");
                $current.next().addClass("current");
                $current.removeClass("wrong");
                $type.val("");
                return;
            }

            $current.addClass("wrong");

        }); */

        $difficult.change(function() {
            validateCodigo($codigo.val());
            //getText();
        });

        $display.click(function() {
            $type.focus()
        });

        $type.focus(); // permanece o campo com foco

        $("button.text-restart").click(function() {
            $(".text-footer").hide();
            $display.show(800);
            getText();
        });

        $refresh.click(function() {
            $refresh.prop("disabled", true);

            if ($codigo.val().length == 4) {
                getText();
            }
        });

        if ($codigo.val()) {
            validateCodigo($codigo.val());
        } else {
            $circleLoader.hide();
        }

        //getText();
    });
</script>
<?php endHtml(); ?>