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

                            <el-form-item label="店家編號" prop="company_name">
                                @{{model.store_info.company_name}}
                            </el-form-item>

                            <el-form-item label="商圈認證" prop="tax_id">
                                @{{model.shopping_info.shopping_street_name}}
                            </el-form-item>

                            <el-form-item label="分店名稱" prop="branch_name">
                                @{{model.branch_name}}
                            </el-form-item>

                            <el-form-item label="聯絡電話" prop="tel">
                                @{{model.tel}}
                            </el-form-item>

                            <el-form-item label="門市地址" prop="branch_city">
                                @{{model.branch_city + model.branch_district + model.branch_address}}

                            </el-form-item>

                        </el-row>
                    </div>
                </div>


                <div class="card radius-15">
                    <div class="card-body">
                        <h3 class="card-title">營業時間</h3>
                        <el-row>
                            <el-form-item prop="checkList">
                                <el-checkbox v-model="model.branch_business_hours.checkList" label="1">星期一</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.branch_business_hours.mon.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.branch_business_hours.mon.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.branch_business_hours.mon.startTime
                                    }">
                                </el-time-select>
                            </el-form-item>

                            <el-form-item prop="branch_business_hours">

                                <el-checkbox v-model="model.branch_business_hours.checkList" label="2">星期二</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.branch_business_hours.tues.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.branch_business_hours.tues.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.branch_business_hours.tues.startTime
                                    }">
                                </el-time-select>
                            </el-form-item>

                            <el-form-item prop="branch_business_hours">
                                <el-checkbox v-model="model.branch_business_hours.checkList" label="3">星期三</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.branch_business_hours.wed.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.branch_business_hours.wed.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.branch_business_hours.wed.startTime
                                    }">
                                </el-time-select>
                            </el-form-item>

                            <el-form-item prop="branch_business_hours">
                                <el-checkbox v-model="model.branch_business_hours.checkList" label="4">星期四</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.branch_business_hours.thur.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.branch_business_hours.thur.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.branch_business_hours.thur.startTime
                                    }">
                                </el-time-select>
                            </el-form-item>

                            <el-form-item prop="branch_business_hours">
                                <el-checkbox v-model="model.branch_business_hours.checkList" label="5">星期五</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.branch_business_hours.fri.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.branch_business_hours.fri.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.branch_business_hours.fri.startTime
                                    }">
                                </el-time-select>

                            </el-form-item>

                            <el-form-item prop="branch_business_hours">
                                <el-checkbox v-model="model.branch_business_hours.checkList" label="6">星期六</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.branch_business_hours.sat.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.branch_business_hours.sat.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.branch_business_hours.sat.startTime
                                    }">
                                </el-time-select>

                            </el-form-item>

                            <el-form-item prop="branch_business_hours">
                                <el-checkbox v-model="model.branch_business_hours.checkList" label="7">星期日</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.branch_business_hours.sun.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.branch_business_hours.sun.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.branch_business_hours.sun.startTime
                                    }">
                                </el-time-select>

                            </el-form-item>
                            <el-form-item label="備註" prop="branch_business_hours">
                                <el-input disabled v-model="model.branch_business_hours.remark"  placeholder="備註"></el-input>
                            </el-form-item>


                        </el-row>
                    </div>
                </div>

                <div class="form-group text-center">
                    <a :href="ok_jump_url" class="btn btn-info m-1 px-5 radius-30">返回列表</a>
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
                    store_id: "{{$sid}}",
                    branch_business_hours:{
                        checkList:[],
                        mon:{},
                        tues:{},
                        wed:{},
                        thur:{},
                        fri:{},
                        sat:{},
                        sun:{},
                    },
                },
                copy_business_hours:{
                    checkList:[],
                    mon:{},
                    tues:{},
                    wed:{},
                    thur:{},
                    fri:{},
                    sat:{},
                    sun:{},
                },
                dialog_visible: false,
                dialog_image_url: '',
                image_list:[],
                image1_list:[],
                form_rules: {
                    branch_name: [
                        {required: true, message: '請輸入分店名稱', trigger: 'blur'}
                    ],
                    tel: [
                        {required: true, message: '請輸入聯絡電話', trigger: 'blur'}
                    ],
                    branch_city: [
                        {required: true, message: '請選擇地址', trigger: 'blur'}
                    ],
                    branch_district: [
                        {required: true, message: '請選擇地址', trigger: 'blur'}
                    ],
                    branch_address: [
                        {required: true, message: '請輸入門市地址', trigger: 'blur'}
                    ],
                },
                clean_model: {},
                loading: false,
                form_is_top: false,
                api_model_edit: "{{route('branch_update')}}",
                ok_jump_url: "{{route('shopping_street_branch')}}/{{$sid}}",
            }
        },
        created: function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($model) ? $model : null)))}}'.replace(/\+/g, " ")));
            if (json_model) {

                if(json_model.branch_business_hours){
                    json_model.branch_business_hours = JSON.parse(json_model.branch_business_hours);

                    if(json_model.branch_business_hours.mon === undefined){
                        json_model.branch_business_hours.mon = this.copy_business_hours.mon;
                    }
                    if(json_model.branch_business_hours.tues === undefined){
                        json_model.branch_business_hours.tues = this.copy_business_hours.tues;
                    }
                    if(json_model.branch_business_hours.wed === undefined){
                        json_model.branch_business_hours.wed = this.copy_business_hours.wed;
                    }
                    if(json_model.branch_business_hours.thur === undefined){
                        json_model.branch_business_hours.thur = this.copy_business_hours.thur;
                    }
                    if(json_model.branch_business_hours.fri === undefined){
                        json_model.branch_business_hours.fri = this.copy_business_hours.fri;
                    }
                    if(json_model.branch_business_hours.sat === undefined){
                        json_model.branch_business_hours.sat = this.copy_business_hours.sat;
                    }
                    if(json_model.branch_business_hours.sun === undefined){
                        json_model.branch_business_hours.sun = this.copy_business_hours.sun;
                    }
                }else{
                    json_model.branch_business_hours = this.copy_business_hours;
                }
                this.model = json_model;
                console.log(this.model);

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
