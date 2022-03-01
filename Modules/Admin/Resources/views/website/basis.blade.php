<!DOCTYPE html>
<base href="{{asset('')}}"/>
<html lang="en">
<head>
    @include('admin::partials._include_head', ['title' => $title])
</head>
<body>
<!-- wrapper -->
<div class="wrapper" id="vue_html" v-cloak>
@include('admin::partials._include_header_aside')
<!--page-wrapper-->
    <div class="page-wrapper">
        <!--page-content-wrapper-->
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="page-breadcrumb d-md-flex align-items-center mb-3">
                    <!--<div class="breadcrumb-title pr-3"></div>-->
                    <div class="pl-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item">
                                    {{$title}}
                                </li>

                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card radius-15">
                    <div class="card-body">
                        <el-form ref="form" :rules="form_rules" v-loading="loading" :model="model" label-width="120px"
                                 :label-position="form_is_top ? 'top' : 'right'">
                            <el-row>

                                <el-form-item label="網站名稱" prop="name">
                                    <el-input v-model="model.name"></el-input>
                                </el-form-item>
                                <el-form-item label="商城LOGO" prop="logo">

                                        <img :src="model.logo" v-if="model.logo" style="width: 100px; height: 100px">
                                    <el-upload
                                            name="file"
                                            drag
                                            action="{{route('upload')}}"
                                            :on-success="(res,file)=>{return uploadSuccess(res,file,'logo')}"
                                    >
                                        <i class="el-icon-upload"></i>
                                        <div class="el-upload__text">拖曳圖片至此,或<em>點擊上傳</em></div>
                                        <div class="el-upload__tip" slot="tip">檔案格式：JPG、JPEG、PNG，且5MB以下</div>
                                    </el-upload>

                                </el-form-item>


                                <el-form-item label="系統管理員信箱" prop="email">
                                    <el-input v-model="model.email"></el-input>
                                </el-form-item>
                                <el-form-item label="SEO關鍵字" prop="seo_keyword">
                                    <el-input v-model="model.seo_keyword"></el-input>
                                </el-form-item>
                                <el-form-item label="SEO描述" prop="seo_describe">
                                    <el-input v-model="model.seo_describe"></el-input>
                                </el-form-item>


                            </el-row>

                            <el-form-item>
                                <el-button type="primary" @click="send_form('form')">保存</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                </div>
            </div>
        </div>
        <!--end page-content-wrapper-->
        @include('admin::partials._include_vue_body')
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
        data: function () {
            return {
                model: {
                    type:"basis",
                    name: "",
                    logo: "",
                    email: "",
                    seo_keyword: "",
                    seo_describe: "",
                },
                form_rules: {

                    name: [
                        {required: true, message: '請輸入網站名稱', trigger: 'blur'}
                    ],
                    logo: [
                        {required: true, message: '請上傳圖片', trigger: 'blur'}
                    ],
                    email: [
                        {required: true, message: '請選擇日期', trigger: 'blur'}
                    ],
                    seo_keyword: [
                        {required: true, message: '請輸入SEO關鍵詞', trigger: 'blur'}
                    ],
                    seo_describe: [
                        {required: true, message: '請輸入SEO描述', trigger: 'blur'}
                    ],
                },
                clean_model: {},
                loading: false,
                form_is_top: false,
                api_model_update: "{{route('website_update')}}",
            }
        },
        created: function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($model) ? $model : null)))}}'.replace(/\+/g, " ")));
            if (json_model) {
                this.model = json_model;
            }

        },
        mounted: function () {
            this.get_device_size();
            window.addEventListener('resize', () => {
                this.get_device_size();
            });

        },
        methods: {
            send_form: function (form_name) {
                this.$refs[form_name].validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        var that = this;
                        console.log(this.model)
                        request_ajax_json(this.api_model_update, this.model, function (response) {
                            that.loading = false;
                            if (response.status) {
                                switch (response.status) {
                                    case 20000:
                                        that.$message({
                                            type: 'success',
                                            message: response.message
                                        });
                                       // window.location.href = that.ok_jump_url;
                                        break;
                                    default:
                                        // 响应错误回调
                                        that.$message({
                                            type: 'warning',
                                            message: response.message
                                        });
                                        break;
                                }
                            }
                        }, function () {
                            that.loading = false;
                        })
                    } else {
                        return false;
                    }
                });
            },
            get_device_size: function () {
                let winW = window.innerWidth;
                if (winW < 500) {
                    this.form_is_top = true
                } else {
                    this.form_is_top = false
                }
            },
            uploadSuccess:function (res,file,index) {
                    this.model.logo = res.data.path;
            },
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
</script>
</body>

</html>