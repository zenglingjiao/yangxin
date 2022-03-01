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
                                    <a href="{{route('store_index')}}">分類管理</a>
                                </li>
                                <li class="breadcrumb-item active">@{{model.id?"編輯":"新增"}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <el-form ref="form" :rules="form_rules" v-loading="loading" :model="model" label-width="120px"
                                 :label-position="form_is_top ? 'top' : 'right'">
                <div class="card radius-15">
                    <div class="card-body">
                        <el-row>
                            <el-form-item label="方案名稱" prop="scenario_name">
                                <el-input v-model="model.scenario_name"></el-input>
                            </el-form-item>

                            <el-form-item label="類型" prop="type">
                                <el-select v-model="model.type" placeholder="請選擇">
                                    <el-option label="陽信點" :value="1"></el-option>
                                    <el-option label="自家點" :value="2"></el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item label="點數" prop="points">
                                <el-input v-model="model.points"></el-input>
                            </el-form-item>

                            <el-form-item label="原價" prop="original_price">
                                $<el-input v-model="model.original_price"></el-input>
                            </el-form-item>

                            <el-form-item label="特價" prop="special_offer">
                                $<el-input v-model="model.special_offer"></el-input>
                            </el-form-item>

                            <el-form-item label="排序" prop="scenario_sort">
                                <el-input v-model="model.scenario_sort"></el-input>
                            </el-form-item>

                            <el-form-item label="狀態" prop="status">
                                <el-radio v-model="model.status" :label="1">開啟</el-radio>
                                <el-radio v-model="model.status" :label="0">停用</el-radio>
                            </el-form-item>

                            <el-form-item>
                                <el-button type="primary" @click="send_form('form')">保存</el-button>
                                <el-button @click="cancel">取消</el-button>
                            </el-form-item>
                        </el-row>
                    </div>
                </div>
                </el-form>

            </div>
        </div>
        <el-dialog :visible.sync="dialog_visible">
            <div style="text-align: center;"><img :src="dialog_image_url" style="max-width: 100%;" alt=""></div>
        </el-dialog>
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
                    id: 0,
                },
                dialog_visible: false,
                dialog_image_url: '',
                form_rules: {
                    // name: [
                    //     {required: true, message: '請輸入名稱', trigger: 'blur'}
                    // ],
                },
                clean_model: {},
                loading: false,
                form_is_top: false,
                api_model_edit: "{{route('purchase_scheme_update')}}",
                ok_jump_url: "{{route('purchase_scheme_index')}}/",
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
            /**
             * 移除图片
             * @param response
             */
            remove_img(response) {
                if (response.field) {
                    this.model[response.field] = '';
                    this[response.field + '_list'] = [];
                }
            },
            /**
             * 移除图片
             * @param response
             */
            error_upload_img(response) {
                this.$message({dangerouslyUseHTMLString: true, message: '網絡錯誤，請聯係管理員', type: 'error'});
                if (response.field) {
                    this.model[response.field] = '';
                    this[response.field + '_list'] = [];
                }
            },
            /**
             * 移除图片
             * @param response
             */
            preview_img(response) {
                if (response.url) {
                    this.dialog_visible = true
                    this.dialog_image_url = response.url
                }
            },
            /**
             * 上傳图片
             * @param response
             */
            upload_img(response) {
                if (response.status === 20000) {
                    if (response.data.field) {
                        this.model[response.data.field] = response.data.path;
                        this[response.data.field + '_list'] = [{url: response.data.path, field: response.data.field}];
                    }
                    this.$message.success(response.message);
                } else {
                    this.remove_img(response);
                    this.$message({dangerouslyUseHTMLString: true, message: response.msg, type: 'error'});
                }
            },
            send_form: function (form_name) {
                this.$refs[form_name].validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        var that = this;

                        // this.model.business_hours = JSON.stringify(this.model.business_hours);
                        // if (this.model.id > 0){
                            var url = that.api_model_edit
                        // } else{
                        //     var url = that.api_model_add
                        // }
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
