<div class="content">
    <form>
        <div class="form">
            <div class="form-header">
                <h2>Ranking</h2>
                <span>Atualmente tem <span id="countPlayers">0</span> jogador(es) no ranking</span>
            </div>
            <div class="form-body">
                <span>Ultima vez resetado: <span id="lastReset">data</span></span>
            </div>
            <div class="form-footer">
                <button id="reset" style="width: 200px;">Resetar Ranking</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
        var $form = $("form");
        var $reset = $("#reset");
        var $countPlayers = $("#countPlayers");
        var $lastReset = $("#lastReset");

        var circleLoader = `
            <div class="circle-loader">
                <div class="load"></div>
            </div>`;

        $form.submit(function(e) {
            e.preventDefault();
        });

        function getPlayers() {
            $.post("source/resetRanking.php", {
                type: "getPlayers"
            }, function(response) {
                response = JSON.parse(response);

                $countPlayers.text(response["alunos"].length);
            });
        }

        function updateDate() {
            $.post("source/resetRanking.php", {
                type: "updateDate"
            }, function(response) {
                response = JSON.parse(response);
                var date = new Date(response["date"].feito_em);

                $lastReset.text(date.toLocaleString());
            })
        }

        $reset.click(function() {
            var $button = $(this);

            $.post("source/resetRanking.php", {
                type: "delete"
            }, function(response) {
                $button.html(circleLoader);
                $button.prop("disabled", true);
            }).fail(function() {
                alert("Obtivemos um erro, tente novamente mais tarde.");
            }).always(function() {
                $button.text("Ranking resetado");
                $button.css("background-color", "var(--green-background)");
                getPlayers();
            });
        });

        getPlayers();
        updateDate();
    });
</script>