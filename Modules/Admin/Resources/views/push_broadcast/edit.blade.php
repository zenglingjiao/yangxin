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
                                <el-form-item label="标题" prop="title">
                                    <template v-if="is_true_status == true">
                                        @{{model.title}}
                                    </template>
                                    <template v-else>
                                        <el-input v-model="model.title"></el-input>
                                    </template>
                                </el-form-item>

                                <el-form-item label="内容" prop="name">
                                    <template v-if="is_true_status == true">
                                        @{{model.content}}
                                    </template>
                                    <template v-else>
                                        <el-input
                                            type="textarea"
                                            placeholder="請輸入內容"
                                            v-model="model.content"
                                            maxlength="30"
                                            show-word-limit
                                        >
                                        </el-input>
                                    </template>
                                </el-form-item>

                                <el-form-item label="對象" prop="company_name">
                                    <template v-if="is_true_status == true">
                                        <template v-if="model.push_object == 1">
                                            全體
                                        </template>
                                        <template v-else>
                                            <a href="javascript:;" @click="dialog_check_visible = true">查看</a>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <el-radio v-model="model.push_object" :label="1">
                                            對象
                                        </el-radio>

                                        <a href="javascript:;" @click="dialog_visible = true">
                                            <el-radio v-model="model.push_object" :label="2">
                                                去選擇
                                            </el-radio>
                                        </a>
                                    </template>
                                </el-form-item>

                                <el-form-item label="推播時間" prop="company_name">
                                    <template v-if="is_true_status == true">
                                        <template v-if="model.push_manner == 1">
                                            @{{model.created_at}}
                                        </template>
                                        <template v-else>
                                            @{{model.push_time}}
                                        </template>
                                    </template>
                                    <template v-else>
                                        <el-radio v-model="model.push_manner" :label="1">立即</el-radio>
                                        <el-radio v-model="model.push_manner" :label="2">
                                            預約
                                            <el-date-picker
                                                v-model="model.push_time"
                                                value-format="yyyy-MM-dd HH:mm:ss"
                                                type="datetime"
                                                :disabled="model.push_manner == 1"
                                                placeholder="選擇日期時間">
                                            </el-date-picker>
                                        </el-radio>
                                    </template>
                                </el-form-item>

                                <el-form-item label="狀態" prop="company_name" v-if="is_true_status == true">
                                    已發送
                                </el-form-item>

                                <el-form-item>
                                    <template v-if="is_true_status == true">
                                        <el-button type="primary" @click="cancel">返回列表</el-button>
                                    </template>
                                    <template v-else>
                                        <el-button type="primary" @click="send_form('form')">保存</el-button>
                                        <el-button @click="cancel">取消</el-button>
                                    </template>
                                </el-form-item>
                            </el-row>
                        </div>
                    </div>

                </el-form>

            </div>
        </div>
        <el-dialog :visible.sync="dialog_visible">
            <div class="my-el-table">
                <el-table :data="table_data" stripe highlight-current-row border
                          style="width: 100%;"
                          ref="multipleTable"
                          size="mini"
                          v-loading="loading"
                          row-class-name="my-el-tr"
                          @selection-change="handleSelectionChange"
                >
                    <template slot="empty">
                        無符合條件記錄
                    </template>
                    <el-table-column
                        type="selection"
                        width="55">
                    </el-table-column>
                    <el-table-column header-align="center" align="center" prop="branch_no"
                                     label="店家編號"></el-table-column>
                    <el-table-column header-align="center" align="center" prop="branch_name"
                                     label="公司名稱"></el-table-column>
                    <el-table-column header-align="center" align="center" label="操作">
                        <template slot-scope="scope">
                            <el-button
                                size="mini"
                                type="primary"
                                @click="edit_model(scope.$index, scope.row)">編輯
                            </el-button>
                            <el-button
                                size="mini"
                                type="danger"
                                @click="del_model(scope.$index, scope.row)">刪除
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <div style="margin-top: 10px;">
                    <el-pagination
                        @size-change="size_change"
                        @current-change="current_change"
                        :current-page="table_model.page"
                        :page-sizes="table_model.page_sizes"
                        :page-size="table_model.limit"
                        layout="total, sizes, prev, pager, next, jumper"
                        :total="table_model.total">
                    </el-pagination>
                </div>
                <div>

                    <el-button @click="clearselect">取消</el-button>
                    <el-button type="primary" @click="add_selection">確定</el-button>
                </div>
            </div>
        </el-dialog>
        <el-dialog :visible.sync="dialog_check_visible">
            <el-table :data="store_list" stripe highlight-current-row border
                          style="width: 100%;"
                          ref="multipleTable"
                          size="mini"
                          v-loading="loading"
                          row-class-name="my-el-tr"
                          @selection-change="handleSelectionChange"
                >
                    <template slot="empty">
                        無符合條件記錄
                    </template>
                    <el-table-column header-align="center" align="center" prop="branch_no"
                                     label="店家編號"></el-table-column>
                    <el-table-column header-align="center" align="center" prop="branch_name"
                                     label="公司名稱"></el-table-column>
                </el-table>
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
                    receive_object: [],
                },
                table_model: {
                    id: "",
                    name: "",
                    sort: "date_created",
                    order: "descending",
                    total: 0,
                    page: 1,
                    page_sizes: [10, 20, 50, 100, 200, 300, 500],
                    limit: 10,
                },
                table_data: [],
                store_list: [],
                multipleSelection: [],
                dialog_visible: false,
                dialog_check_visible: false,
                dialog_image_url: '',
                imgs_list: [],
                industry_category: [],
                is_true_status: false,
                form_rules: {
                    // name: [
                    //     {required: true, message: '請輸入名稱', trigger: 'blur'}
                    // ],
                },
                clean_model: {},
                loading: false,
                form_is_top: false,
                api_get_tabel: "{{route('branch_list')}}",
                api_model_edit: "{{route('push_broadcast_update')}}",
                ok_jump_url: "{{route('push_broadcast_index')}}/",
            }
        },
        created: function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($model) ? $model : null)))}}'.replace(/\+/g, " ")));
            if (json_model) {
                this.model = json_model;

                if (this.model.push_manner == 1) {
                    this.is_true_status = true;
                } else {
                    //前三十分鐘仍可以編輯
                    let s_time = new Date(this.model.push_time).getTime() - (30 * 60 * 1000);
                    let now_time = new Date().getTime();
                    if (s_time < now_time) {
                        this.is_true_status = true;
                    }
                }
                var store = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($store) ? $store : null)))}}'.replace(/\+/g, " ")));
                if(store){
                    this.store_list = store;
                }
            }

        },
        mounted: function () {
            this.get_table_data();
            this.get_device_size();
            window.addEventListener('resize', () => {
                this.get_device_size();
            });

        },
        methods: {
            add_selection() {
                for (x in this.multipleSelection) {
                    this.model.receive_object.push(this.multipleSelection[x].id);
                }
                this.dialog_visible = false;
            },
            handleSelectionChange(val) {
                console.log(val);
                this.multipleSelection = val;
            },
            clearselect() {
                this.dialog_visible = false;
                this.$refs.multipleTable.clearSelection();
            },
            get_table_data: function () {
                save_web_temp_data(this.history_name, this.table_model);
                this.loading = true;
                var that = this;
                request_ajax_json(this.api_get_tabel, this.table_model, function (response) {
                    if (response.status) {
                        switch (response.status) {
                            case 20000:
                                that.loading = false;
                                //console.log(response.data.Data);
                                if (response.data && response.data.list) {
                                    that.table_data = response.data.list;
                                }
                                if (response.data && response.data.total) {
                                    that.table_model.total = response.data.total;
                                }
                                break;
                            default:
                                // 响应错误回调
                                that.loading = false;
                                break;
                        }
                    }
                }, function () {
                    that.loading = false;
                })
            },
            size_change: function (val) {
                //console.log(`每页 ${val} 条`);
                this.table_model.limit = val;
                this.get_table_data();
            },
            current_change: function (val) {
                //console.log(`当前页: ${val}`);
                this.table_model.page = val;
                this.get_table_data();
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
