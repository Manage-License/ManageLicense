class action {
    constructor() {
        this.ip = $("#changeIP").val();
        this.name = $("#txtChangeName").val();
        this.new_os = $("#sltChangeOs").val();

        this.patch = window.location.href;
        this.v = this.patch.indexOf('?');
        this.postPach = this.patch.substr(this.v);
        this.urlParams = new URLSearchParams(location.search);

        this.id = this.urlParams.get('id');
        this.userid = this.urlParams.get("userid");

        this.token = $("input[name='token']").val();
    }

    change_ip(type) {
        this.ip = $("#changeIP").val();
        swal({
            title: "Are you sure?",
            text: "Change IP,Change ip has cost!",
            icon: "warning",
            buttons: ["No", "Yes"],
            // showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    this.showWaitingDiv();
                    let patch = window.location.href;
                    let v = patch.indexOf('?');
                    let postPach = patch.substr(v);
                    let urlParams = new URLSearchParams(location.search);
                    let id = urlParams.get('id');
                    let userid = urlParams.get("userid");
                    jQuery.post("?userid=" + userid + "&id=" + id + "" + '&sendType=ajax', {
                            'token': $("input[name='token']").val(),
                            'changeIP': this.ip,
                            'type': type
                        }
                        , function (data) {
                            if (data == "noChange") {
                                swal("you dont change ip")
                            }
                            if (data == "True") {
                                location.href = "?userid=" + userid + "&id=" + id + "" + '&success=true';
                            }
                            if (data == "False") {
                                swal("cannot change ip")
                            }
                            actions.hideWaitingDiv();
                        })

                }
            });
    }

    change_name(type) {
        this.showWaitingDiv();
        this.name = $("#txtChangeName").val();
        if (this.name == "") {
            $(".label.changeName").html("required field").fadeIn();
            setTimeout(function () {
                $(".label.changeName").fadeOut();
            }, 3000);
            return false;
        } else {
            $.post("?id=" + this.id + "&userid=" + this.userid + "&sendType=ajax", {
                'ChangeName': this.name,
                "token": this.token,
                "type": type
            }, function (data) {
                if (data == "True") {
                    actions.hideWaitingDiv();
                    actions.alertShow("success", "yor name has bin change", 1000);
                } else if (data == "False") {
                    actions.hideWaitingDiv();
                    actions.alertShow("danger", "change name has bin error", 1000);
                }
            })
        }

    }

    change_os(type) {
        this.showWaitingDiv();
        this.new_os = $("#sltChangeOs").val();
        $.post("?id=" + this.id + "&userid=" + this.userid + "&sendType=ajax", {
            'new_os': this.new_os,
            "token": this.token,
            "type": type
        }, function (data) {
            if (data == "True") {
                actions.hideWaitingDiv();
                actions.alertShow("success", "yor OS has bin change", 1000);
            } else if (data == "False") {
                actions.hideWaitingDiv();
                actions.alertShow("danger", "change OS has bin error", 1000);
            }
        })
    }

    showWaitingDiv() {
        $('body').append('<div class="waitinf" style="z-index: 2000000;\n' +
            '    position: fixed;\n' +
            '    top: 0;\n' +
            '    display: block;\n' +
            '    bottom: 0;\n' +
            '    left: 0;\n' +
            '    right: 0;\n' +
            '    margin: 0;\n' +
            '    text-align: center;\n' +
            '    background: rgba(0,0,0,.5);">\n' +
            '    <i class="fas fa-sync fa-spin"></i>\n' +
            '    </div>');
    }

    hideWaitingDiv() {
        $(".waitinf").fadeOut();
    }

    alertShow(type = "danger", message, duration = 1000) {
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


//    cloudLinux
    cloud_change_ip() {
        this.ip = $("#changeIP").val();
        swal({
            title: "Are you sure?",
            text: "Change IP,Change ip for cloudlinux",
            icon: "warning",
            buttons: ["No", "Yes"],
            // showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    this.showWaitingDiv();
                    let patch = window.location.href;
                    let v = patch.indexOf('?');
                    let postPach = patch.substr(v);
                    let urlParams = new URLSearchParams(location.search);
                    let id = urlParams.get('id');
                     if(id === null){
                          id = urlParams.get('productselect');
                     }
                         // else{
                     //     let id = urlParams.get('id');
                     //
                     // }
                    let userid = urlParams.get("userid");
                    jQuery.post("?userid=" + userid + "&id=" + id + "" + '&sendType=ajax', {
                            'token': $("input[name='token']").val(),
                            'changeIP': $("#changeIP").val(),
                            'type': "change-ip"
                        }
                        , function (data) {
                            let result;
                            try {
                                result = JSON.parse(data);
                                if (result["error"] == true) {
                                    swal(result["errorMessage"])
                                }
                                actions.hideWaitingDiv();
                            } catch (e) {


                                if (data == "noChange") {
                                    swal("you dont change ip")
                                }
                                if (data == "True") {
                                    location.href = "?userid=" + userid + "&id=" + id + "" + '&success=true';
                                }
                                if (data == "False") {
                                    swal("cannot change ip")
                                }
                                actions.hideWaitingDiv();
                            }
                        })

                }
            });
    }
};

let actions = new action();