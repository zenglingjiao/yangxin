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
                                    <a href="{{route('admin_index')}}"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{route('classify_index')}}">分類管理</a>
                                </li>
                                <li class="breadcrumb-item active">@{{model.id?"編輯":"新增"}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card radius-15">
                    <div class="card-body">
                        <el-form ref="form" :rules="form_rules" v-loading="loading" :model="model" label-width="120px"
                                 :label-position="form_is_top ? 'top' : 'right'">
                            <el-row>

                                <el-form-item label="名稱" prop="name">
                                    <el-input v-model="model.name"></el-input>
                                </el-form-item>
                                <el-form-item v-if="model.lv == 1 || model.img" label="圖片" :rules="{required: true, message: '請上傳圖片', trigger: 'blur'}">
                                    <div v-if="model.img" style="width: 100px;float: left">
                                        <img :src="model.img" style="width: 100px; height: 100px">
                                    </div>
                                    <el-upload style="float: left"
                                               name="file"
                                               drag
                                               action="{{route('upload')}}"
                                               :on-success="(res,file)=>{return uploadSuccess(res)}"
                                    >
                                        <i class="el-icon-upload"></i>
                                        <div class="el-upload__text">拖曳圖片至此,或<em>點擊上傳</em></div>
                                        <div class="el-upload__tip" slot="tip" >檔案格式：JPG、JPEG、PNG，且5MB以下</div>
                                    </el-upload>

                                </el-form-item>

                                <el-form-item label="排序" prop="sort">
                                    <el-input v-model="model.sort"></el-input>
                                </el-form-item>

                                <el-form-item label="狀態" prop="status">
                                    <el-switch v-model="model.status" active-color="#13ce66" inactive-color="#ff4949"
                                               :active-value=1 :inactive-value=0 active-text="啓用"
                                               inactive-text="關閉"></el-switch>
                                </el-form-item>

                            </el-row>

                            <el-form-item>
                                <el-button type="primary" @click="send_form('form')">保存</el-button>
                                <el-button @click="cancel">取消</el-button>
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
                    id: "",
                    name: "",
                    img: "",
                    pid:"{{$parent?$parent->id:0}}",
                    lv:"{{$parent?$parent->lv:0}}",
                    sort:"1",
                    status: 1,
                },
                form_rules: {

                    name: [
                        {required: true, message: '請輸入名稱', trigger: 'blur'}
                    ],
                    up_time: [
                        {required: true, message: '請選擇日期', trigger: 'blur'}
                    ],
                    status: [
                        {required: true, message: '請選擇餐廳狀態', trigger: 'blur'}
                    ],
                },
                clean_model: {},
                loading: false,
                form_is_top: false,
                api_model_edit: "{{route('classify_update')}}",
                api_model_add: "{{route('classify_add')}}",
                ok_jump_url: "{{route('classify_index')}}/{{$parent?$parent->id:0}}",
            }
        },
        created: function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($model) ? $model : null)))}}'.replace(/\+/g, " ")));
            if (json_model) {
                this.model = json_model;
                console.log(this.model)
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
                        if (this.model.id > 0){
                            var url = that.api_model_edit
                        } else{
                            var url = that.api_model_add
                        }
                        request_ajax_json(url, this.model, function (response) {
                            console.log(response)
                            that.loading = false;
                            if (response.status) {
                                switch (response.status) {
                                    case 20000:
                                        that.$message({
                                            type: 'success',
                                            message: response.message
                                        });
                                        window.location.href = that.ok_jump_url;
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
            cancel: function () {
                history.back();
            },
            uploadSuccess:function (res,index) {
                this.model.img = res.data.path;
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
            },
            time_select:function (val) {
                this.model.up_time = val[0]
                this.model.down_time = val[1]
            }
        }
    });
</script>
</body>

</html>