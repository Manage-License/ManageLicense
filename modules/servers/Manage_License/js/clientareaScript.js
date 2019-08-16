$(document).ready(function () {
    $("#frmName").on("submit", function (e) {
        e.preventDefault();
        let name = $("#ChangeName").val();
        let token = $("input[name='token']").val();
        let ChangeOs = $("#ChangeOs").val();
        let url=  $("#frmName").attr('action');

        if (name == "") {

            alertShow("danger", "ip field is empty");
            return;
        }
        $.post(url, {
            name:name,
            token:token,
            ChangeOs:ChangeOs,
            changeData:'ChangeName'
        }, function (data) {

        })
    })
});

alertShow = function (type = "danger", message, duration = 1000) {
    $("#alert-div").remove();
    $('body').append('<div class="alert alert-' + type + ' alert-dismissible" role="alert" id="alert-div">\n' +
        '    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>\n' +
        '<span>' + message + '</span>\n' +
        '</div>');
    $("#alert-div").slideDown();

    setTimeout(function () {
        $("#alert-div").slideUp();
    }, duration);
};