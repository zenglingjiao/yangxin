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
                                    <a href="{{route('keyword_hint')}}">提示詞列表</a>
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

                                <el-form-item label="提示詞" prop="keyword">
                                    <el-input v-model="model.keyword"></el-input>
                                </el-form-item>
                                <el-form-item label="權重" prop="weight">
                                    <el-select v-model="model.weight" filterable>
                                        <el-option v-for="item in options" :label=item.v :value=item.k></el-option>
                                    </el-select>
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
                options:[
                    {k:0,v:"低"},
                    {k:1,v:"中"},
                    {k:2,v:"高"},
                ],
                model: {
                    id: "",
                    keyword: "",
                    weight: 0,
                },
                form_rules: {

                    keyword: [
                        {required: true, message: '請輸入提示詞', trigger: 'blur'}
                    ],
                },
                clean_model: {},
                loading: false,
                form_is_top: false,
                api_model_add: "{{route('keyword_hint_add')}}",
                ok_jump_url: "{{route('keyword_hint')}}",
            }
        },
        created: function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($model) ? $model : null)))}}'.replace(/\+/g, " ")));
            if (json_model) {
                json_model.up_time = String(json_model.up_time)
                json_model.down_time = String(json_model.down_time)
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

                        var url = this.api_model_edit;
                        if (this.model.id > 0) {

                        } else {
                            url = this.api_model_add;
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
</script>
</body>

</html>