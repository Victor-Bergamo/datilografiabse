<div class="content">
    <form action="https://datilografia.brasilsuleducacional.com.br/adm/source/speed_type.php">
        <div class="form">
            <div class="form-header">
                <h2>Teste de digitação</h2>
            </div>
            <div class="form-body" style="width: 400px;">
                <div class="difficult-options">
                    <label>
                        Fácil
                        <input type="radio" name="difficulty" checked id="difficulty" value="easy">
                        <span class="checkmark"></span>
                    </label>
                    <label>
                        Médio
                        <input type="radio" name="difficulty" id="difficulty" value="medium">
                        <span class="checkmark"></span>
                    </label>
                    <label>
                        Difícil
                        <input type="radio" name="difficulty" id="difficulty" value="hard">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="difficulty-obs" style="display: flex; flex-direction: column;">
                    <span style="margin: 0; color: #1c1c1c; font-weight: 500;">TEXTO FÁCIL: Média de 25 palavras.</span>
                    <span style="margin: 0; color: #1c1c1c; font-weight: 500;">TEXTO MÉDIO: Média de 35 palavras.</span>
                    <span style="margin: 0; color: #1c1c1c; font-weight: 500;">TEXTO DIFÍCIL: Média de 45 palavras.</span>
                </div>
                <textarea name="speedText" id="speedText" cols="30" rows="10"></textarea>
            </div>
            <div class="form-footer" style="flex-direction: column;">
                <p style="margin: 0px 0px 20px 0px; display: flex; justify-content: space-between; width: 100%;">
                    <span>Caracteres: <span id="caracteres" style="font-weight: 500;">0</span></span>
                    <span>Palavras: <span id="palavras" style="font-weight: 500;">0</span></span>
                    <span>Linhas: <span id="linhas" style="font-weight: 500;">0</span></span>
                </p>
                <button type="submit">Enviar</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
        $speedText = $("#speedText");
        $spanChar = $("span#caracteres");
        $spanWord = $("span#palavras");
        $spanLine = $("span#linhas");
        $form = $("form");

        $speedText.bind("input", function(e) {
            var value = e.currentTarget.value

            $spanChar.text(value.length); // conta a quantidade de caracteres
            $spanWord.text(value.length ? value.trim().replace(/\n/g, " ").split(" ").length : 0); // conta a quantidade de palavras
            $spanLine.text((value.match(new RegExp("\n", "g")) || []).length + 1); // conta a quantidade de enters

            //console.log(value.split(" "));
            //$spanWord.text(value.length ? (value.split(" ")).length : 0);
        });

        $form.submit(function(e) {
            e.preventDefault();

            $button = $form.find("button");
            $button.attr("disabled", true);

            $.post($form.attr("action"), $form.serialize(), function(response) {
                alert(response.mensagem);
            }, "json").done(function() {
                $button.attr("disabled", false);
            });
        })
    });
</script>