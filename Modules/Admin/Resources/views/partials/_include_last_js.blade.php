<!-- JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!--plugins-->
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>

<!-- App JS -->
<script src="assets/js/app.js"></script>

<script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/plugins/jquery-validation/localization/messages_zh_TW.js"></script>
<!-- <script src="assets/plugins/vue/vue.min.js"></script> -->
<script src="assets/plugins/vue/vue.js"></script>
<script src="assets/plugins/vue/vue-resource.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/plugins/vue/Sortable.min.js"></script>
<script src="assets/plugins/vue/vuedraggable.min.js"></script>

<!-- element-ui -->
<script src="assets/plugins/element-ui/vue-i18n.js"></script>
<script src="assets/plugins/element-ui/index.js"></script>
<script src="assets/plugins/element-ui/lang/zh-TW.js"></script>
<script src="assets/js/ajaxSendLoad.js"></script>
<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/js/humane.js"></script>
<script src="assets/js/admin-common.js"></script>
@include('admin::partials._include_password')
@include('admin::partials._include_tree')
<script>
    $(function () {
        $(".menu_list").click(function(){
            var name = $(this).attr("param_name");
            if(name&&name.length>0){
                del_web_temp_data(name);
            }
        });
        $("#cancel_edit").click(function(){
            window.history.go(-1);
        });
    });
    /**
     * 跳转
     * @param url
     * @param is_new
     */
    Vue.prototype.get_menu = function (){
        var menu = [];
        if(get_web_temp_data("menu")&&get_web_temp_data("menu").length>0){
            menu = get_web_temp_data("menu");
        }
        return menu;
    }
</script>
<script>
    function tick() {
        var today;
        today = new Date();
        var yy = today.getYear();
        if (yy < 1900) yy = yy + 1900;
        var MM = today.getMonth() + 1;
        var dd = today.getDate();

        var hh = today.getHours();
        if (hh < 10) hh = '0' + hh;
        var mm = today.getMinutes();
        if (mm < 10) mm = '0' + mm;
        //        var ss = today.getSeconds();
        //        if(ss<10) ss = '0' + ss;

        var ww = today.getDay();
        var arr = new Array(" 星期日", " 星期一", " 星期二", " 星期三", " 星期四", " 星期五", " 星期六")

        //document.getElementById("time").innerHTML =  yy + "年" + MM + "月" + dd + "日 " + hh + ":" + mm + ":" + ss + "  " +arr[ww] ;
        //window.setTimeout("tick()", 1000);
        document.getElementById("time").innerHTML = yy + "年" + MM + "月" + dd + "日 " + hh + ":" + mm + "  " + arr[ww];
        window.setTimeout("tick()", 60000);
    }
    tick();
</script>
