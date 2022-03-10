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
                                    <a :href="ok_jump_url">店家廣告管理</a>
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

                                <el-form-item label="店家編號" prop="type">
                                    <template v-if="model.id>0">
                                        @{{storeInfo.store_no}}
                                    </template>
                                    <template v-else>
                                        <el-autocomplete
                                            v-model="model.state"
                                            :fetch-suggestions="findStore"
                                            placeholder="請輸入內容"
                                            @select="handleSelect"
                                        ></el-autocomplete>
                                    </template>
                                </el-form-item>

                                <el-form-item label="公司名稱" prop="name">
                                    @{{storeInfo.company_name}}
                                </el-form-item>

                                <el-form-item label="廣告名稱" prop="name">
                                    <el-input v-model="model.name"></el-input>
                                </el-form-item>

                                <el-form-item label="廣告圖片" prop="imgs">
                                    <el-upload action="{{route('upload')}}" list-type="picture-card"
                                               accept="image/*"
                                               :limit="1"
                                               :file-list="imgs_list"
                                               :data="{field:'imgs'}"
                                               :on-preview="preview_img"
                                               :on-remove="remove_img"
                                               :on-error="error_upload_img"
                                               :on-success="upload_img"
                                               class="single-upload"
                                               :length="imgs_list.length"
                                    ><i class="el-icon-plus"></i>
                                    </el-upload>

                                </el-form-item>

                                <el-form-item label="上架時間" prop="company_name">
                                    <template>
                                        <el-date-picker
                                            v-model="model.up_at"
                                            value-format="yyyy-MM-dd HH:mm:ss"
                                            type="datetimerange"
                                            range-separator="-"
                                            :disabled="model.is_perpetual == 1"
                                            start-placeholder="開始日期"
                                            end-placeholder="結束日期">
                                        </el-date-picker>
                                    </template>
                                </el-form-item>

                                <el-form-item label="網址" prop="url">
                                    <el-input v-model="model.url"></el-input>
                                </el-form-item>

                                <el-form-item label="排序" prop="ad_sort">
                                    <el-input v-model="model.ad_sort"></el-input>
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
                imgs_list: [],
                industry_category: [],
                storeInfo: {},
                is_true_reg: false,
                is_true_corp: false,
                form_rules: {
                    // name: [
                    //     {required: true, message: '請輸入名稱', trigger: 'blur'}
                    // ],
                },
                clean_model: {},
                loading: false,
                form_is_top: false,
                api_model_edit: "{{route('ec_advertising_update')}}",
                ok_jump_url: "{{route('ec_advertising_index')}}/",
                findstore_url: "{{route('refund_find')}}",

            }
        },
        created: function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($model) ? $model : null)))}}'.replace(/\+/g, " ")));
            if (json_model) {

                this.model = json_model;
                if (json_model.store_info) {
                    this.storeInfo = json_model.store_info;
                }
                console.log(this.model)
            }

            var industry_category = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($industry_category) ? $industry_category : null)))}}'.replace(/\+/g, " ")));
            if (industry_category) {
                this.industry_category = industry_category;
            }


            if (this.model.imgs) this.imgs_list = [{
                url: this.model.imgs,
                field: 'imgs'
            }];


        },
        mounted: function () {
            this.get_device_size();
            window.addEventListener('resize', () => {
                this.get_device_size();
            });

        },
        methods: {
            findStore(queryString, cb) {

                var url = this.findstore_url;
                var results = [];
                if (queryString == '') {
                    cb(results);
                } else {
                    request_ajax_json(url, {name: queryString, page: 1, limit: 10}, function (response) {
                        console.log(response)
                        // return false;
                        if (response.status) {
                            switch (response.status) {
                                case 20000:
                                    //循环放到一个远程搜索需要的数组
                                    for (let i = 0; i < response.data.list.length; i++) {
                                        const element = response.data.list[i];
                                        results.push({
                                            value: element.store_no,
                                            company_name: element.company_name,
                                            tax_id: element.tax_id,
                                            bank_code: element.bank_code,
                                            branch_bank: element.branch_bank,
                                            bank_accounts: element.bank_accounts,
                                            bank_username: element.bank_username,
                                            id: element.id
                                        })
                                    }
                                    cb(results);
                                    break;
                                default:
                                    // 响应错误回调
                                    results = [];
                                    cb(results);
                                    break;
                            }
                        }
                    }, function () {
                        results = [];
                        cb(results);
                    })
                }

            },
            handleSelect(item) {
                this.storeInfo = item;
                this.model.store_id = item.id;
                console.log(item);
            },
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
            same: function (name) {
                console.log(name);
                let that = this.model;
                if (name == 'same_reg') {
                    if (this.model.same_reg == 1) {
                        this.model.corp_city = that.reg_city;
                        this.model.corp_district = that.reg_district;
                        this.model.corp_address = that.reg_address;
                        this.is_true_reg = true;
                    } else {
                        this.is_true_reg = false;
                    }
                }
                if (name == 'same_corp_name') {
                    if (this.model.same_corp_name == 1) {
                        this.model.corporate_brand = that.company_name;
                        this.is_true_corp = true;
                    } else {
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
            uploadSuccess: function (res, index) {
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
            time_select: function (val) {
                this.model.up_time = val[0]
                this.model.down_time = val[1]
            }
        }
    });
</script>
</body>

</html>
