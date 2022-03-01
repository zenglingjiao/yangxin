<!DOCTYPE html>
<base href="{{asset('')}}"/>
<html lang="en">
<head>
    @include('admin::partials._include_head', ['title' => $title])
    <style>
        .textColor .el-form-item__label, .textColor .el-form-item__content {
            color: red;
        }
    </style>
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
                    <div class="form-item">
                        <div class="form-group ml-auto">
                            <button @click="record_visible = true;" type="button" class="btn btn-info m-1 px-5 radius-30">審核記錄</button>
                        </div>
                    </div>
                    <div class="card radius-15" v-if="model.register_audit_status == 3">
                        <div class="card-body">
                            <h4 class="card-title">審核回覆</h4>
                            <div>
                                @{{recordInfo.reply}}
                            </div>
                        </div>
                    </div>
                    <div class="card radius-15">
                        <div class="card-body">
                            <h3 class="card-title">公司資料</h3>
                            <el-row>

                                <el-form-item label="公司名稱" prop="bank_accounts"
                                              :class="{textColor:red_tag('company_name')}">
                                    @{{model.company_name}}
                                </el-form-item>

                                <el-form-item label="統一編號" prop="bank_accounts}" :class="{textColor:red_tag('tax_id')}">
                                    @{{model.tax_id}}
                                </el-form-item>

                                <el-form-item label="註冊地址" prop="bank_accounts}"
                                              :class="{textColor:red_tag('reg_address')}">
                                    @{{model.reg_city + model.reg_district + model.reg_address}}
                                </el-form-item>

                                <el-form-item label="公司地址" prop="corp_address}"
                                              :class="{textColor:red_tag('corp_address')}">
                                    @{{model.corp_city + model.corp_district + model.corp_address}}
                                </el-form-item>

                                <el-form-item label="公司網站" prop="company_websites}"
                                              :class="{textColor:red_tag('company_websites')}">
                                    @{{model.company_websites}}
                                </el-form-item>

                                <el-form-item label="公司人數" prop="people}" :class="{textColor:red_tag('people')}">
                                    @{{model.people}}
                                </el-form-item>

                                <el-form-item label="有無分店" prop="have_branch}"
                                              :class="{textColor:red_tag('have_branch')}">
                                    @{{model.have_branch == 1 ?'有':'無'}}
                                </el-form-item>

                                <el-form-item label="分店數" prop="branch_num}" :class="{textColor:red_tag('branch_num')}">
                                    @{{model.branch_num}}
                                </el-form-item>

                                <el-form-item label="公司品牌" prop="corporate_brand}"
                                              :class="{textColor:red_tag('corporate_brand')}">
                                    @{{model.corporate_brand}}
                                </el-form-item>

                                <el-form-item label="公司簡述" prop="company_profile}"
                                              :class="{textColor:red_tag('company_profile')}">
                                    @{{model.company_profile}}
                                </el-form-item>

                                <el-form-item label="產業類別" prop="industry_category_id}"
                                              :class="{textColor:red_tag('industry_category_id')}">
                                    @{{model.industry_category_id}}
                                </el-form-item>

                            </el-row>
                        </div>
                    </div>
                    <div class="card radius-15">
                        <div class="card-body">
                            <h3 class="card-title">負責人資料</h3>
                            <el-row>

                                <el-form-item label="負責人" prop="principal" :class="{textColor:red_tag('principal')}">
                                    @{{model.principal}}
                                </el-form-item>

                                <el-form-item label="聯絡人" prop="liaisons_name}"
                                              :class="{textColor:red_tag('liaisons_name')}">
                                    @{{model.liaisons_name}}
                                </el-form-item>

                                <el-form-item label="聯絡人手機" prop="liaisons_tel}"
                                              :class="{textColor:red_tag('liaisons_tel')}">
                                    @{{model.liaisons_tel}}
                                </el-form-item>

                                <el-form-item label="公司電話" prop="company_tel}"
                                              :class="{textColor:red_tag('company_tel')}">
                                    @{{model.company_tel}}
                                </el-form-item>

                                <el-form-item label="聯絡Email" prop="liaisons_mail}"
                                              :class="{textColor:red_tag('liaisons_mail')}">
                                    @{{model.liaisons_mail}}
                                </el-form-item>
                            </el-row>
                        </div>
                    </div>
                    <div class="card radius-15">
                        <div class="card-body">
                            <el-row>

                                <el-form-item label="狀態" prop="remark">
                                    <template v-if="model.is_show == 1">
                                        <el-radio v-model="model.register_audit_status" :label="1">待審核</el-radio>
                                        <el-radio v-model="model.register_audit_status" :label="2">審核通過</el-radio>
                                        <p @click="dialogFormVisible = true">
                                            <el-radio v-model="model.register_audit_status" :label="3">審核失敗</el-radio>
                                        </p>
                                    </template>
                                    <template v-else>
                                        @{{['','','審核通過','審核失敗'][model.register_audit_status]}}
                                    </template>

                                </el-form-item>

                                <el-form-item v-if="model.id > 0 && model.is_show > 1">
                                    <div class="form-group text-center">
                                        <a :href="ok_jump_url" class="btn btn-info m-1 px-5 radius-30">返回審核紀錄</a>
                                    </div>
                                </el-form-item>

                                <el-form-item v-else>
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
        <el-dialog :visible.sync="record_visible">
            <el-table :data="record_list" stripe highlight-current-row border
                      style="width: 100%;"
                      size="mini"
                      v-loading="loading"
                      row-class-name="my-el-tr"
            >
                <template slot="empty">
                    無符合條件記錄
                </template>

                <el-table-column header-align="center" align="center" prop="created_at" label="審核日期">
                </el-table-column>
                <el-table-column header-align="center" align="center" prop="adjust_field" label="調整欄位">
                    <template slot-scope="scope">
                        @{{scope.row.adjust_field}}
                    </template>
                </el-table-column>
                <el-table-column header-align="center" align="center" prop="reply" label="審核回覆"></el-table-column>
            </el-table>
        </el-dialog>
        <el-dialog title="調整欄位" :visible.sync="dialogFormVisible">
            <el-form :model="model">
                <el-checkbox-group v-model="adjust_field">
                    <div>
                        <el-checkbox label="company_name">公司名稱</el-checkbox>
                        <el-checkbox label="corporate_brand">公司品牌</el-checkbox>
                    </div>
                    <div>
                        <el-checkbox label="tax_id">統一編號</el-checkbox>
                        <el-checkbox label="company_profile">公司簡述</el-checkbox>
                    </div>
                    <div>
                        <el-checkbox label="reg_address">註冊地址</el-checkbox>
                        <el-checkbox label="industry_category_id">產業類別</el-checkbox>
                    </div>
                    <div>
                        <el-checkbox label="corp_address">公司地址</el-checkbox>
                        <el-checkbox label="principal">負責人</el-checkbox>
                    </div>
                    <div>
                        <el-checkbox label="company_websites">公司網站</el-checkbox>
                        <el-checkbox label="liaisons_name">聯絡人</el-checkbox>
                    </div>
                    <div>
                        <el-checkbox label="people">公司人數</el-checkbox>
                        <el-checkbox label="liaisons_tel">聯絡人手機</el-checkbox>
                    </div>
                    <div>
                        <el-checkbox label="have_branch">有無分店</el-checkbox>
                        <el-checkbox label="company_tel">公司電話</el-checkbox>
                    </div>
                    <div>
                        <el-checkbox label="branch_num">分店數</el-checkbox>
                        <el-checkbox label="liaisons_mail">聯絡E-mail</el-checkbox>
                    </div>

                </el-checkbox-group>

                <div>
                    <el-input
                        type="textarea"
                        placeholder="審核回覆"
                        v-model="model.reply"
                        maxlength="30"
                        show-word-limit
                    >
                    </el-input>
                </div>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="dialogFormVisible = false">确 定</el-button>
            </div>
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
                    is_show: 0,
                },
                adjust_field: [],//調整欄位
                recordInfo: {},
                record_list: [],
                purchase_scheme_list: [],
                dialog_visible: false,
                dialogFormVisible: false,
                record_visible: false,
                dialog_image_url: '',
                form_rules: {
                    // name: [
                    //     {required: true, message: '請輸入名稱', trigger: 'blur'}
                    // ],
                },
                clean_model: {},
                loading: false,
                form_is_top: false,
                api_model_edit: "{{route('store_register_update')}}",
                ok_jump_url: "{{route('store_register_index')}}/",
                {{--findstore_url: "{{route('refund_find')}}",--}}
            }
        },
        created: function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($model) ? $model : null)))}}'.replace(/\+/g, " ")));
            if (json_model) {
                this.model = json_model;
                this.model.is_show = json_model.register_audit_status;
            }
            var record = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($record) ? $record : null)))}}'.replace(/\+/g, " ")));
            if (record) {
                this.recordInfo = record;
            }
            var record_list = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($record_list) ? $record_list : null)))}}'.replace(/\+/g, " ")));
            if (record_list) {
                this.record_list = record_list;
            }
        },
        mounted: function () {
            this.get_device_size();
            window.addEventListener('resize', () => {
                this.get_device_size();
            });

        },
        methods: {
            //是否標記為紅
            red_tag(e) {
                if (this.recordInfo.adjust_field && this.recordInfo.adjust_field.length > 0 && this.recordInfo.adjust_field.indexOf(e) > -1) {
                    return true;
                } else {
                    return false;
                }
            },
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
            send_form: function (form_name) {
                if (this.model.register_audit_status == 3 && this.adjust_field.length == 0) {
                    this.$message.error('請選擇一個調整欄位');
                    return false;
                } else {
                    this.$refs[form_name].validate((valid) => {
                        if (valid) {
                            this.model.adjust_field = this.adjust_field;
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
                }
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
