<div class="content">
    <div class="ranking-players">
        <div class="ranking-header">
            <div class="ranking-options">
                <div class="ranking-config">
                    <span>Selecione a Dificuldade:</span>
                    <div class="difficult-buttons">
                        <button id="diffEasy" class="active" data-diff="easy">Fácil</button>
                        <button id="diffMedium" data-diff="medium">Médio</button>
                        <button id="diffHard" data-diff="hard">Difícil</button>
                        <select name="month" id="month">
                            <option <?= ("01" == date("m") ? "selected='selected'" : "") ?> value="01">Janeiro</option>
                            <option <?= ("02" == date("m") ? "selected='selected'" : "") ?> value="02">Fevereiro</option>
                            <option <?= ("03" == date("m") ? "selected='selected'" : "") ?> value="03">Março</option>
                            <option <?= ("04" == date("m") ? "selected='selected'" : "") ?> value="04">Abril</option>
                            <option <?= ("05" == date("m") ? "selected='selected'" : "") ?> value="05">Maio</option>
                            <option <?= ("06" == date("m") ? "selected='selected'" : "") ?> value="06">Junho</option>
                            <option <?= ("07" == date("m") ? "selected='selected'" : "") ?> value="07">Julho</option>
                            <option <?= ("08" == date("m") ? "selected='selected'" : "") ?> value="08">Agosto</option>
                            <option <?= ("09" == date("m") ? "selected='selected'" : "") ?> value="09">Setembro</option>
                            <option <?= ("10" == date("m") ? "selected='selected'" : "") ?> value="10">Outubro</option>
                            <option <?= ("11" == date("m") ? "selected='selected'" : "") ?> value="11">Novembro</option>
                            <option <?= ("12" == date("m") ? "selected='selected'" : "") ?> value="12">Dezembro</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="ranking-content">
            <div class="main-players">
                <div class="ranking-first-place">
                    <div class="placing">
                        <i class="fas fa-trophy"></i>
                        <span>1</span>
                    </div>
                    <div class="player-name">
                        <h3></h3>
                    </div>
                    <div class="player-data"></div>
                </div>
                <div class="ranking-second-place">
                    <div class="placing">
                        <i class="fas fa-trophy"></i>
                        <span>2</span>
                    </div>
                    <div class="player-name">
                        <h3></h3>
                    </div>
                    <div class="player-data"></div>
                </div>
                <div class="ranking-third-place">
                    <div class="placing">
                        <i class="fas fa-trophy"></i>
                        <span>3</span>
                    </div>
                    <div class="player-name">
                        <h3></h3>
                    </div>
                    <div class="player-data"></div>
                </div>
            </div>
            <div class="other-players" data-repeat="10"></div>
        </div>
        <div class="ranking-footer"></div>
    </div>
</div>
<?php startHtml("js"); ?>
<script>
    $(function() {
        var $mainPlayers = $(".main-players");
        var $otherPlayers = $(".other-players");
        var $difficultButtons = $(".difficult-buttons button");
        var $selectMonth = $("#month");

        var circleLoader = `
            <div class="circle-loader">
                <div class="load"></div>
            </div>`;

        $selectMonth.change(function(e) {
            $selectMonth.prop("disabled", true);
            var $mode = $difficultButtons.parent().find(".active");
            loadRanking($mode.data("diff"), $(this).val());
        });

        $difficultButtons.click(function() {
            var active = $difficultButtons.parent().find(".active"); // retorna botão com class active

            active.removeClass("active"); // remove a classe atual que tem o active
            $(this).addClass("active"); // adiciona ao botão que foi clicado

            $difficultButtons.prop("disabled", true);

            loadRanking($(this).data("diff"), $selectMonth.val()); // carrega o ranking pela dificuldade
        });

        function place(ranking) {
            ranking = ranking.slice(0, 3); // remove os alunos que não estão no top 3

            // para os 3 no ranking
            $(".player-name").each(function(i, e) {
                // adiciona o circulo de carregamento
                $(e).children().html(circleLoader);

                if (ranking[i]) {
                    // faz um pedido para receber o nome do aluno
                    $.post("source/ranking.php", {
                        type: "name",
                        idAluno: ranking[i].id_aluno
                    }, function(response) {
                        response = JSON.parse(response); // transforma em json

                        $(e).children().text(response.nome); // escreve o nome
                        $(e).children().prop("title", response.nome);
                    });


                    $(e).parent().find(".player-data").html(`
                        <h5>Precisão: <span>${ranking[i].precisao}%</span></h5>
                        <h5>PPM: <span>${ranking[i].ppm}</span></h5>
                        <h5>Realizado em: <span>${(new Date(ranking[i].realizado_em)).toLocaleDateString()}</span></h5>

                    `);
                } else {
                    $(e).children().html(`<span class="error-loading">Ainda não há um ${(i) + 1}º colocado</span>`);
                    $(e).children().prop("title", "");
                    $(e).parent().find(".player-data").empty();
                }
            });

            //$circleLoader.hide();
            $mainPlayers.show(); // mostra o placar
        }

        function generateRanking(ranking) {
            // limpa o ranking antigo
            $otherPlayers.empty();

            ranking = ranking.slice(3, ranking.length); // remove os 3 primeiros

            var repeat = $otherPlayers.data("repeat");
            var templateHTML = `
                <div class="o-player">
                    <div class="o-player-place">
                        <span></span>
                    </div>
                    <div class="o-player-name">
                        <i class="fas fa-medal"></i>
                        <h5></h5>
                    </div>
                    <div class="o-player-data">
                        <span></span>
                    </div>
                </div>
            `;
            (async () => {
                for (var i = 0; i < repeat; i++) {
                    var $loadHtml = $(templateHTML);

                    $loadHtml.find(".o-player-place span").text(i + 4);

                    if (ranking[i]) {
                        // faz um pedido para receber o nome do aluno
                        await $.post("source/ranking.php", {
                            type: "name",
                            idAluno: ranking[i].id_aluno
                        }, function(response) {
                            response = JSON.parse(response); // transforma em json
                            $loadHtml.find(".o-player-name h5").text(response.nome); // escreve o nome
                        });

                        $loadHtml.find(".o-player-data span").text(ranking[i].ppm + " PPM");
                    } else {
                        $loadHtml.find(".o-player-name h5").text("Ainda não há um " + (i + 4) + "º Colocado");
                    }

                    $otherPlayers.append($loadHtml);
                }

                $difficultButtons.prop("disabled", false);
                $selectMonth.prop("disabled", false);
            })();

            console.log($otherPlayers.data("repeat"));

            /*$.each($otherPlayers.data("repeat"), function(i) {
                console.log(i);
            });*/
        }

        function loadRanking(difficult = "easy", month = null) {
            $.post("source/ranking.php", {
                difficult: difficult,
                month: month
            }, function(response) {
                response = JSON.parse(response);
                place(response);
                generateRanking(response);
            });

        }

        loadRanking();
    });
</script>
<?php endHtml(); ?>