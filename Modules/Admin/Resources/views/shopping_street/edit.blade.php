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
                        <h3 class="card-title">商圈基本資料</h3>

                        <el-row>

                            <el-form-item label="商圈名稱" prop="shopping_street_name">
                                <el-input v-model="model.shopping_street_name"></el-input>
                            </el-form-item>

                            <el-form-item label="註冊地址" prop="reg_city">
                                <el-select v-model="model.reg_city" placeholder="縣市">
                                    <el-option label="台北" value="1"></el-option>
                                    <el-option label="高雄" value="0"></el-option>
                                </el-select>
                                <el-select v-model="model.reg_district" placeholder="地區">
                                    <el-option label="盐埕区" value="1"></el-option>
                                    <el-option label="鼓山区" value="0"></el-option>
                                </el-select>

                                <el-input v-model="model.reg_address"  placeholder="詳細地址"></el-input>
                            </el-form-item>


                            <el-form-item label="店家數" prop="store_num">
                                <el-input v-model="model.store_num"></el-input>
                            </el-form-item>

                            <el-form-item label="商圈簡述" prop="sketch">
                                <el-input
                                  type="textarea"
                                  placeholder="请输入内容"
                                  v-model="model.sketch"
                                  maxlength="30"
                                  show-word-limit
                                >
                                </el-input>
                            </el-form-item>

                        </el-row>
                    </div>
                </div>
                <div class="card radius-15">
                    <div class="card-body">
                        <h3 class="card-title">負責人資料</h3>

                        <el-row>

                            <el-form-item label="負責人" prop="principal">
                                <el-input v-model="model.principal"></el-input>
                            </el-form-item>

                            <el-form-item label="聯絡人" prop="liaisons_name">
                                <el-input v-model="model.liaisons_name"></el-input>
                            </el-form-item>

                            <el-form-item label="聯絡人手機" prop="liaisons_tel">
                                <el-input v-model="model.liaisons_tel"></el-input>
                            </el-form-item>

                            <el-form-item label="商圈電話" prop="shopping_street_tel">
                                <el-input v-model="model.shopping_street_tel"></el-input>
                            </el-form-item>

                            <el-form-item label="聯絡Email" prop="liaisons_mail">
                                <el-input v-model="model.liaisons_mail"></el-input>
                            </el-form-item>

                        </el-row>
                    </div>
                </div>

                <div class="card radius-15">
                    <div class="card-body">
                        <h5 class="card-title">營業時間(必填)</h5>
                        <el-row>
                            <el-form-item prop="buy_power">
                                <el-checkbox v-model="model.business_hours.checkList" label="1">星期一</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.business_hours.mon.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.business_hours.mon.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.business_hours.mon.startTime
                                    }">
                                </el-time-select>
                            </el-form-item>

                            <el-form-item prop="buy_power">

                                <el-checkbox v-model="model.business_hours.checkList" label="2">星期二</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.business_hours.tues.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.business_hours.tues.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.business_hours.tues.startTime
                                    }">
                                </el-time-select>
                            </el-form-item>

                            <el-form-item prop="buy_power">
                                <el-checkbox v-model="model.business_hours.checkList" label="3">星期三</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.business_hours.wed.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.business_hours.wed.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.business_hours.wed.startTime
                                    }">
                                </el-time-select>
                            </el-form-item>

                            <el-form-item prop="buy_power">
                                <el-checkbox v-model="model.business_hours.checkList" label="4">星期四</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.business_hours.thur.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.business_hours.thur.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.business_hours.thur.startTime
                                    }">
                                </el-time-select>
                            </el-form-item>

                            <el-form-item prop="buy_power">
                                <el-checkbox v-model="model.business_hours.checkList" label="5">星期五</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.business_hours.fri.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.business_hours.fri.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.business_hours.fri.startTime
                                    }">
                                </el-time-select>

                            </el-form-item>

                            <el-form-item prop="buy_power">
                                <el-checkbox v-model="model.business_hours.checkList" label="6">星期六</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.business_hours.sat.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.business_hours.sat.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.business_hours.sat.startTime
                                    }">
                                </el-time-select>

                            </el-form-item>

                            <el-form-item prop="buy_power">
                                <el-checkbox v-model="model.business_hours.checkList" label="7">星期日</el-checkbox>
                                <el-time-select
                                    placeholder="起始时间"
                                    v-model="model.business_hours.sun.startTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00'
                                    }">
                                </el-time-select>
                                <el-time-select
                                    placeholder="结束时间"
                                    v-model="model.business_hours.sun.endTime"
                                    :picker-options="{
                                      start: '00:00',
                                      step: '00:10',
                                      end: '24:00',
                                      minTime: model.business_hours.sun.startTime
                                    }">
                                </el-time-select>

                            </el-form-item>

                            <el-form-item label="備註" prop="branch_business_hours">
                                <el-input v-model="model.business_hours.remark"  placeholder="備註"></el-input>
                            </el-form-item>

                        </el-row>
                    </div>
                </div>

                <div class="card radius-15">
                    <div class="card-body">
                        <el-row>
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
                    company_name: '',
                    corporate_brand: '',
                    reg_city: '',
                    reg_district: '',
                    reg_address: '',
                    business_hours:{
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

                form_rules: {
                    // name: [
                    //     {required: true, message: '請輸入名稱', trigger: 'blur'}
                    // ],
                },
                clean_model: {},
                loading: false,
                form_is_top: false,
                api_model_edit: "{{route('shopping_street_update')}}",
                ok_jump_url: "{{route('shopping_street_index')}}/",
            }
        },
        created: function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($model) ? $model : null)))}}'.replace(/\+/g, " ")));
            if (json_model) {

                json_model.business_hours = JSON.parse(json_model.business_hours);
                if(json_model.business_hours){

                    if(json_model.business_hours.mon === undefined){
                        json_model.business_hours.mon = this.copy_business_hours.mon;
                    }
                    if(json_model.business_hours.tues === undefined){
                        json_model.business_hours.tues = this.copy_business_hours.tues;
                    }
                    if(json_model.business_hours.wed === undefined){
                        json_model.business_hours.wed = this.copy_business_hours.wed;
                    }
                    if(json_model.business_hours.thur === undefined){
                        json_model.business_hours.thur = this.copy_business_hours.thur;
                    }
                    if(json_model.business_hours.fri === undefined){
                        json_model.business_hours.fri = this.copy_business_hours.fri;
                    }
                    if(json_model.business_hours.sat === undefined){
                        json_model.business_hours.sat = this.copy_business_hours.sat;
                    }
                    if(json_model.business_hours.sun === undefined){
                        json_model.business_hours.sun = this.copy_business_hours.sun;
                    }
                }else{
                    json_model.business_hours = this.copy_business_hours;
                }
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
            //同某某一樣
            same:function(name){
                console.log(name);
                let that = this.model;
                if(name == 'same_reg'){
                    if(this.model.same_reg == 1){
                        this.model.corp_city = that.reg_city;
                        this.model.corp_district = that.reg_district;
                        this.model.corp_address = that.reg_address;
                        this.is_true_reg = true;
                    }else{
                        this.is_true_reg = false;
                    }
                }
                if(name == 'same_corp_name'){
                    if(this.model.same_corp_name == 1){
                        this.model.corporate_brand = that.company_name;
                        this.is_true_corp = true;
                    }else{
                        this.is_true_corp = false;
                    }
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
