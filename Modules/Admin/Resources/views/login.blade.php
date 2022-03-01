<!DOCTYPE html>
<base href="{{asset('')}}"/>
<html lang="en">
<head>
    @include('admin::partials._include_head', ['title' => $title])
</head>
<body class="login">
<!-- wrapper -->
<div class="wrapper" id="vue_html" v-cloak>
<!--page-wrapper-->
    <div class="page-wrapper">
        <h3 class="text-center">Sunny EC 總管理後台</h3>
        <div class="login_wrapper">
            <div class="animate form">
                <section class="login_content">
                    <el-form ref="form" autocomplete="off" :rules="form_rules" v-loading="loading" :model="model" label-width="70px" :label-position="form_is_top ? 'top' : 'right'">
                        <h1 class="text-center">登入</h1>
                        <el-row>
                            <el-col :xs="24" :sm="24" :md="24">
                                <el-form-item label="帳號" prop="username">
                                    <el-input v-model="model.username"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :xs="24" :sm="24" :md="24">
                                <el-form-item label="密碼" prop="password">
                                    <el-input show-password v-model="model.password"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :xs="24" :sm="24" :md="24">
                                <el-form-item label="驗證碼" prop="code">
                                    <el-input v-model="model.code">
                                        <template slot="append">
                                            <el-image
                                                    v-loading="loading_code"
                                                    v-show="captcha"
                                                    class="cursor"
                                                    @click="get_code"
                                                    style="width: 100px; height: 35px"
                                                    :src="captcha"
                                                    fit="fill"></el-image>
                                        </template>
                                    </el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row type="flex" class="row-bg" justify="space-around">
                            <el-col :span="6">
                                <el-checkbox v-model="model.isAlways" true-label="1" false-label="0">保持一天</el-checkbox>
                            </el-col>
                            <el-col :span="6">
                                <el-button type="danger" class="btn btn-danger px-5 btn-add" @click="send_form('form')">登入</el-button>
                            </el-col>
                        </el-row>
                    </el-form>
                </section>
            </div>
        </div>
    </div>
    <!--end page-wrapper-->
    @include('admin::partials._include_footer')
</div>
<!-- end wrapper -->
@include('admin::partials._include_last_js')

<script>
    $(function () {
    });
    ELEMENT.locale(ELEMENT.lang.zhTW)
    var vue_obj = new Vue({
        el: '#vue_html',
        data: function(){
            return {
                model: {
                    username:"",
                    password:"",
                    isAlways:"",
                    client:"",
                },
                captcha:"",
                clean_model:{},
                loading_code:false,
                loading:false,
                form_is_top:false,
                form_rules: {
                    username: [
                        {required: true, message: '請輸入帳號', trigger: 'blur'},
                        {
                            validator: (rule, value, callback) => {
                                if (!/^[A-Za-z_\d]{5,18}$/.test(value)) callback(new Error('帳號為5-18位字符'))
                                callback();
                            }, trigger: 'blur'
                        },
                    ],
                    password: [
                        {required: true, message: '請輸入密碼', trigger: 'blur'}
                    ],
                    code: [
                        {required: true, message: '請輸入驗證碼', trigger: 'blur'}
                    ]
                },
                api_login: "{{ route('login_in') }}",
                api_get_menu: "{{route('get_menu')}}",
                api_admin_index: "{{route('admin_index')}}",
                api_get_img_code: "{{route('get_img_code')}}",
            }
        },
        created:function () {
        },
        mounted: function () {
            this.get_device_size();
            window.addEventListener('resize',()=>{
                this.get_device_size();
            });
            this.get_code();
        },
        methods: {
            send_form:function (form_name) {
                this.$refs[form_name].validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        clean_token();
                        clean_user_info();
                        clean_expires_in();
                        var that = this;
                        request_ajax_json(this.api_login, this.model, function (response) {
                            that.loading = false;
                            if (response.status) {
                                switch (response.status) {
                                    case 20000:
                                        if (response.message && $.trim(response.message) != "") {
                                            save_token(response.data.token);
                                            save_user_info(response.data.user_info);
                                            save_expires_in((response.data.expires_in*1000)+(new Date().getTime()));
                                            //window.location = "{{ route('admin_index') }}";
                                            that.get_menu();
                                        }
                                        break;
                                    default:
                                        if (response.message && $.trim(response.message) != "") {
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
                            that.loading = false;
                        })
                    } else {
                        return false;
                    }
                });
            },
            get_device_size:function () {
                let winW = window.innerWidth;
                if(winW < 500){
                    this.form_is_top = true
                }else{
                    this.form_is_top = false
                }
            },
            get_menu:function () {
                this.loading = true;
                var that = this;
                request_ajax_json(this.api_get_menu, {}, function (response) {
                    that.loading = false;
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
                                window.location = that.api_admin_index;
                                break;
                            default:
                                break;
                        }
                    }
                },function () {
                    that.loading = false;
                })
            },
            get_code:function (){
                var that = this;
                this.loading_code = true;
                $.ajax({
                    url:this.api_get_img_code,
                    success(res){
                        that.loading_code = false;
                        that.model.client = res.client;
                        that.captcha = res.captcha;
                    },
                    error(){
                        that.loading_code = false;
                    }
                })
            }
        },
        watch: {
            model: {
                handler(newName, oldName) {
                    this.$nextTick(function () {
                        //$('.selectpicker').selectpicker('refresh');
                    });
                },
                deep: true
            }
        }
    });
    document.onkeydown = function (e) { // 回车提交表单
        // 兼容FF和IE和Opera
        var theEvent = window.event || e;
        var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
        if(code == 13){
            vue_obj.send_form('form');
        }
    }
</script>
</body>

</html>
