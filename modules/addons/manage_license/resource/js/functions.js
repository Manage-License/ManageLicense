class functions {

    static constructor(e) {
        e.preventDefault();
    }

    static active(variable = null) {
        $(".waitinf").fadeIn();
        if (variable === null) {
            this.alertShow("danger", "value is null");
            return 0;
        }
        $.post("../modules/addons/manage_license/actions/active.php", {
            variable
        }, function (data) {
            if (data == "") {
                $(".waitinf").fadeOut();
                sweetAlert("ERROR IN CREATE ..!", "Please contact with administrator", "error");
                return;
            }
            if (data === "True") {
                location.reload(true);
                return;
            }
            let result = JSON.parse(data);
            if (result["result"] === "error") {
                $("#alertDiv").slideDown();
                setTimeout(function () {
                    $("#alertDiv").fadeOut();
                }, 5000);
                $("#alertDiv > span").html(JSON.stringify(result.message));
                $(".waitinf").fadeOut();
            }else if (result["result"] === "success" && result["response"]["server_ip"] != null){
                $(".waitinf").fadeOut();
                functions.alertShow("success", "create");
            }
            else if (result["result"] === "success" && result["response"]["licensekey"] != null) {
                $(".waitinf").fadeOut();
                functions.alertShow("success", "create");
            }else{
                sweetAlert("ERROR IN CREATE ..!", "Please contact with administrator", "error");
            }
        })

        // console.log($vars.lastDate)
        // console.log($vars["lastDate"])
    }

    static suspend(variable = null) {
        $(".waitinf").fadeIn();
        $.post("../modules/addons/manage_license/actions/suspend.php", {
            variable
        }, function (data) {
            let result = JSON.parse(data);
            if (result["result"] === "error") {
                $("#alertDiv").fadeIn();
                $("#alertDiv > span").html(JSON.stringify(result.message));
                $(".waitinf").fadeOut();
            } else if (data === "true") {
                location.reload(true)
            }
        })

    }

    static unSuspend(variable = null) {
        if (variable === null) {
            alert("error");
            return 0;
        }
        $(".waitinf").fadeIn();
        $.post("../modules/addons/manage_license/actions/unSuspend.php", {
            variable
        }, function (data) {
            let result = JSON.parse(data);

            if (result["result"] === "error") {
                $("#alertDiv").fadeIn();
                $("#alertDiv > span").html(JSON.stringify(result.message));
                $(".waitinf").fadeOut();
            } else if (data === "true") {
                location.reload(true);
                // $(".nav.nav-tabs.admin-tabs > li:nth-child(3)").addClass("active")
            }
        })
    }

    static terminate(variable = null) {
        $(".waitinf").fadeIn();
        if (variable === null) {
            alert("error");
            return 0;
        }
        $.post("../modules/addons/manage_license/actions/terminate.php", {
            variable
        }, function (data) {
            let result = JSON.parse(data);

            if (result["result"] === "error") {
                $("#alertDiv").fadeIn();
                $("#alertDiv > span").html(JSON.stringify(result.message));
                $(".waitinf").fadeOut();
            } else if (data === "true") {
                location.reload(true);
                // $(".nav.nav-tabs.admin-tabs > li:nth-child(3)").addClass("active")
            }
        })
    }

    static searchResult(event) {
        event.preventDefault();
        event.preventDefault();
        if ($("#searchserviceid").val() == "" && $("#userid").val() == "" && $("#licensekey").val() == "" && $("#ip").val() == "") {
            this.alertShow("danger", "please insert any value", 1000);
            return;
        }
        $(".waitinf").fadeIn();
        let serviceid = $("#searchserviceid").val();
        // console.log(serviceid);
        $.post("../modules/addons/manage_license/actions/search.php", {
            'serviceid': serviceid,
            'userid': $("#userid").val(),
            'licensekey': $("#licensekey").val(),
            'ip': $("#ip").val(),

        }, function (data) {
            $("#tblUsersLicese tbody").html(data);
            $(".waitinf").fadeOut();
        });
    }

    static createProduct() {

// this.alertShow("danger","dfsfsdfdsf",1000);
        $(".waitinf").fadeIn();
        let name = $("#productName").val();
        let serviceid = $("#serviceid").val();

        $.post("../modules/addons/manage_license/actions/create.php", {
            serviceid,
            name
        }, function (data) {
            let result = JSON.parse(data);
            if (result["result"] === "error") {
                $(".waitinf").fadeOut();
                functions.alertShow("danger", result["message"], 5000)
            }
            if (result["result"] === "success") {
                $(".waitinf").fadeOut();
                functions.alertShow("success", result["message"], 5000)
            }
        })
    }

    static alertShow(type = "danger", message, duration = 1000) {

        $("#alert-div").remove();
        $('body').append('<div class="alert alert-' + type + ' alert-dismissible" role="alert" id="alert-div">\n' +
            '    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>\n' +
            '<span>' + message + '</span>\n' +
            '</div>');
        $("#alert-div").slideDown();

        setTimeout(function () {
            $("#alert-div").slideUp();
        }, duration);
        //
        // setTimeout(function () {
        //     $("#alert-div").remove();
        // },duration)
    }

    static changeip(id){
       console.log(this.prototype)
    }
}

