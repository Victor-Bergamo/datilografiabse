<div class="content">
    <div class="form" style="background-color: white;">
        <form>
            <div class="form-signup">
                <div class="form-header">
                    <h2>
                        Realize seu cadastro temporário <br>
                        <span>Lembre-se esse cadastro só é válido até ser completado 5 exercícios, para ter mais acesso, entre em contanto.</span>
                    </h2>
                </div>
                <div class="form-body">
                    <div class="form-signup-group">
                        <label for="nome">Nome: <span class="erro-form"></span></label>
                        <input type="text" name="nome" id="nome" autocomplete="off">
                    </div>
                    <div class="form-signup-group">
                        <label for="email">E-mail: <span class="erro-form"></span></label>
                        <input type="text" id="email" name="email" autocomplete="off">
                    </div>
                </div>
                <div class="form-footer">
                    <button>
                        Cadastrar-se
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="modal" class="modal-cadastro">
    <div class="modal-cadastro-content">
        <div class="modal-cadastro-header">
            <a href="#fechar" class="fechar">X</a>
            <h2>Seu cadastro foi efetuado com sucesso!</h2>
        </div>
        <div class="modal-cadastro-body">
            <p>Seu código de acesso: <br> <span id="codigoAcesso">0000</span></p>
        </div>
        <div class="modal-cadastro-footer">
            <p>Enviamos uma cópia do seu código por e-mail, confira!</p>
        </div>
    </div>
</div>

<?php startHtml("js"); ?>
<script>
    $(function() {
        $form = $("form");
        $formGroup = $(".form-signup-group");
        $button = $(".form-footer button");
        $modal = $(".modal-cadastro");

        $(".fechar").click(function(e) {
            e.preventDefault();
            $modal.removeClass("showing");
        })

        $formGroup.children("input").on("focus blur", function() {
            $input = $(this);
            if (!$input.val()) {
                $input.siblings("label").toggleClass("label-up")
            }
        });

        $form.submit(function(e) {
            e.preventDefault();
            $button.prop("disabled", true);
            $button.text("Carregando...");

            $.post("source/cadastrar_usr.php", $form.serialize(), function(response) {
                var $label = $("label");
                $label.removeClass("label-erro");
                $label.children().text("");

                if (typeof response.mensagem.email !== 'undefined') {
                    var $labelErro = $("input#email").siblings("label");
                    $labelErro.addClass("label-erro");
                    $labelErro.children().text(response.mensagem.email);
                }

                if (typeof response.mensagem.nome !== 'undefined') {
                    var $labelErro = $("input#nome").siblings("label");
                    $labelErro.addClass("label-erro");
                    $labelErro.children().text(response.mensagem.nome);
                }

                if (typeof response.mensagem.tipo !== 'undefined') {
                    if (response.mensagem.tipo == "erro") {
                        $(".form-header h2 span").text("Você já realizou um cadastro essa semana");
                        $(".form-header h2 span").css("color", "#fa4545");
                    } else {
                        $modal.addClass("showing");
                        $("#codigoAcesso").text(response.mensagem.codigo);
                    }
                }
            }, "json").done(function() {
                $button.text("Cadastrar-se");
                $button.prop("disabled", false);
            });
        });
    });
</script>
<?php endHtml(); ?>