function prevent() {
    var $input = $("#input");
    $('input').on("cut copy paste", function (e) {
        e.preventDefault();
        setTimeout(function () {
            var text = $("#input").val();
        }, 700);
    });
    $(".main").mouseleave(function () {
        $input.val("");
    })
    $(".main").mouseenter(function () {
        $input.val("");
    })
    $(document).bind('keyup', function (e) {
        if (e.ctrlKey) {
            e.preventDefault();
            $input.val("");
            return false;
        }
    });
}
document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
});
