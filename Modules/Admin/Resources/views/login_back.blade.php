<!DOCTYPE html>
<base href="{{asset('')}}"/>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{isset($title)?$title:"後台管理"}}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css" />
    <!-- Icons CSS -->
    <link rel="stylesheet" href="assets/css/icons.css" />
    <!-- App CSS -->
    <link rel="stylesheet" href="assets/css/app.css" />
    <!-- Animate CSS -->
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link href="assets/plugins/jquery-validation/jquery.validate.css" rel="stylesheet">
    <link href="assets/css/ajaxSendLoad.css" rel="stylesheet">
    <link href="assets/plugins/sweetalert2/default.css" rel="stylesheet">
</head>

<body class="login">
<div class="animated  fadeInDown">
    <h3 class="text-center">Sunny</h3>
    <div class="login_wrapper">
        <div class="animate form">
            <section class="login_content">
                <form id="login" method="post" autocomplete="off">
                    <h1 class="text-center">登入</h1>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="帳號" />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="密碼" />
                    </div>
                    {{csrf_field()}}
                    <div class="form-group d-flex justify-content-between align-items-center">
                        <label class="css-input css-checkbox css-checkbox-primary push-10-r">
                            <input type="checkbox" name="isAlways" value="1"><span></span> 記住密碼
                        </label>
                        <button type="button" style="display: none;" id="submit_btn" onclick="send_login()" class="btn btn-danger px-5 btn-add">登入</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>
<!-- Custom Theme Scripts -->
<script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/plugins/jquery-validation/localization/messages_zh_TW.js"></script>
<script src="assets/plugins/vue/vue.min.js"></script>
<script src="assets/plugins/vue/vue-resource.min.js"></script>
<script src="assets/js/ajaxSendLoad.js"></script>
<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/js/admin-common.js"></script>

<script>
    var validator_login;
    $(function () {
        validator_login = $("#login").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper:"div",
            rules: {
                username: {
                    required: true,
                    rangelength:[3,20],
                },
                password: {
                    required: true,
                    rangelength:[6,18],
                }
            },
            messages: {
                username: {
                    required: "請輸入帳號",
                    rangelength: "請輸入{0}-{1}個字符"
                },
                password: {
                    required: "請輸入密碼",
                    rangelength: "請輸入{0}-{1}個字符"
                }
            },
            // errorPlacement: function (error, element) { //指定错误信息位置
            //     if (element.is(':input')) { //如果是radio或checkbox
            //         var eid = element.attr('name'); //获取元素的name属性
            //         error.prependTo(element.parent()); //将错误信息添加当前元素的父结点後面
            //     } else {
            //         error.insertAfter(element);
            //     }
            // }
        });
        $("#submit_btn").show();
    });
    function send_login() {
        if (!$('#login').valid()) {
            validator_login.focusInvalid();
            return false;
        }
        clean_token();
        clean_user_info();
        clean_expires_in();
        var form_data = $('#login').serializeArray();
        addBodyload();
        request_ajax_json("{{ route('login_in') }}", form_data, function (response) {
            if (response.status) {
                switch (response.status) {
                    case 20000:
                        if (response.message && $.trim(response.message) != "") {
                            //console.log(response);
                            save_token(response.data.token);
                            save_user_info(response.data.user_info);
                            save_expires_in((response.data.expires_in*1000)+(new Date().getTime()));
                            //window.location = "{{ route('admin_index') }}";
                            get_menu();
                        }
                        break;
                    default:
                        if (response.message && $.trim(response.message) != "") {
                            removeBodyload();
                            Swal.fire({
                                title: response.message,
                                text: null,
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: '確定',
                                cancelButtonText: '取消',
                            }).then(function(result){
                                if (result.value) {

                                }
                            });
                        }
                        break;
                }
            }
        },function () {
            removeBodyload();
        })
    }
    function get_menu()
    {
        request_ajax_json("{{ route('get_menu') }}", {}, function (response) {
            removeBodyload();
            if (response.status) {
                switch (response.status) {
                    case 20000:
                        save_web_temp_data('menu',response.data);
                        Swal.fire({
                            title:'登入成功',
                            text:'等待跳轉',
                            timer:2000,
                            showConfirmButton:false
                        });
                        window.location = "{{ route('admin_index') }}";
                        break;
                    default:
                        break;
                }
            }
        },function () {
            removeBodyload();
        })
    }
    document.onkeydown = function (e) { // 回车提交表单
        // 兼容FF和IE和Opera
        var theEvent = window.event || e;
        var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
        if(code == 13){
            send_login();
        }
    }
</script>
</body>
</html>
