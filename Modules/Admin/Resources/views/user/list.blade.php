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
<!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="card radius-15">
                <div class="card-body d-flex flex-wrap">
                    <div class="list-item">
                        <div class="list-item-box">
                            <input type="text" class="form-control" v-model="model.name" autocomplete="off"
                                   placeholder="請輸入姓名"/>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="list-item-box">
                            <el-select v-model="model.register_way" filterable>
                                <el-option label="會員註冊通路" value=""></el-option>
                                <el-option v-for="(it, index) in register_way_list" :label=it :value=index></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="list-item-box">
                            <el-select v-model="model.grade_id" filterable>
                                <el-option label="會員等級" value=""></el-option>
                                <el-option v-for="it in grade_id_list" :label=it.name :value=it.id></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="list-item-box">
                            <el-select v-model="model.status" filterable>
                                <el-option label="會員狀態" value=""></el-option>
                                <el-option v-for="it in status_list" :label=it.v :value=it.k></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="list-item-box">
                            <el-select v-model="model.time_type" filterable>
                                <el-option label="時間類別" value=""></el-option>
                                <el-option v-for="it in time_type_list" :label=it.v :value=it.k></el-option>
                            </el-select>
                        </div>
                        <div class="list-item-box">
                            <el-date-picker
                                    v-model="model.start_time"
                                    type="date"
                                    placeholder="起始日"
                                    format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd">
                            </el-date-picker>
                            -
                            <div class="list-item-box">
                                <el-date-picker
                                        v-model="model.end_time"
                                        type="date"
                                        placeholder="結束日"
                                        format="yyyy-MM-dd"
                                        value-format="yyyy-MM-dd">
                                </el-date-picker>

                            </div>

                        </div>
                    </div>
                    <div class="list-item">
                        <div class="list-item-box">
                            <input type="text" class="form-control" v-model="model.phone" autocomplete="off"
                                   placeholder="請輸入手機號"/>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="list-item-box">
                            <el-select v-model="model.sex" filterable>
                                <el-option label="性別" value=""></el-option>
                                <el-option v-for="it in sex_list" :label=it.v :value=it.k></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="list-item-box">
                            <el-select v-model="model.is_yangxin" filterable>
                                <el-option label="是否為陽信卡友" value=""></el-option>
                                <el-option v-for="it in is_yangxin_list" :label=it.v :value=it.k></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="list-item-box">
                            <el-select v-model="model.is_group_lord" filterable>
                                <el-option label="團購主選擇" value=""></el-option>
                                <el-option v-for="it in is_group_lord_list" :label=it.v :value=it.k></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="list-item-box">
                            <el-select v-model="model.is_say" filterable>
                                <el-option label="發言狀態" value=""></el-option>
                                <el-option v-for="it in is_say_list" :label=it.v :value=it.k></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="list-item-box">
                            <el-select v-model="model.is_epaper" filterable>
                                <el-option label="訂閱電子報" value=""></el-option>
                                <el-option v-for="it in is_epaper_list" :label=it.v :value=it.k></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="list-item-right-btn ml-auto">
                        <button type="button" @click="clean_form()" class="btn btn-light">清除</button>
                        <button type="button" @click="model.page=1;model.total=0;get_table_data()" class="btn btn-info">
                            查询
                        </button>
                    </div>
                </div>
            </div>
            <div class="card radius-15">
                <div class="card-body">
                    <div class="form-item">

                        <div class="form-group ml-auto">
                            <a href="{{route('user_add')}}" class="btn btn-info m-1 px-5 radius-30">新增</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="my-el-table">
                            <el-table :data="table_data" stripe highlight-current-row border
                                      style="width: 100%;"
                                      size="mini"
                                      {{--:default-sort = "{prop:model.sort,order:model.order}"--}}
                                      @sort-change="handle_sort"
                                      @selection-change="handle_selection_change"
                                      v-loading="loading"
                                      row-class-name="my-el-tr">
                                <template slot="empty">
                                    無符合條件記錄
                                </template>
                                <el-table-column type="selection" prop="id"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="uid"
                                                 label="會員UID"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="name"
                                                 label="姓名"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="is_yangxin" label="陽信卡友">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.is_yangxin == 0">否</div>
                                        <div v-else>是</div>
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="register_way_name"
                                                 label="會員註冊通路"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="phone"
                                                 label="會員帳號"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="is_group_lord" label="團購主">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.is_group_lord == 1">是</div>
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="birth"
                                                 label="生日"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="grade_id"
                                                 label="會員等級"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="point"
                                                 label="Sunny Point"></el-table-column>
                                <el-table-column header-align="center" align="center" label="歷程">
                                    <template slot-scope="scope">
                                        <el-link @click="jump('2', scope.row)" type="success">交易歷程</el-link>
                                        <el-link @click="jump('3', scope.row)" type="success">點數歷程</el-link>
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="last_buy_time"
                                                 label="最後一次下單時間"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="last_login_time"
                                                 label="最後登入時間"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="status" label="會員狀態">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.status == 0">拉黑</div>
                                        <div v-else>啟用</div>
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="is_say" label="發言狀態">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.is_say == 0">禁止</div>
                                        <div v-else>允許</div>
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="is_epaper" label="訂閱電子報">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.is_epaper == 0">否</div>
                                        <div v-else>是</div>
                                    </template>
                                </el-table-column>

                                <el-table-column header-align="center" align="center" width="200" label="操作">
                                    <template slot-scope="scope">

                                        <el-button size="mini" type="info" @click="jump('1', scope.row)">
                                            查看/編輯
                                        </el-button>
                                        <el-button size="mini" type="warning" @click="popup('phone', scope.row)">
                                            修改手机
                                        </el-button>
                                        <el-button size="mini" type="warning" @click="popup('email', scope.row)">
                                            修改信箱
                                        </el-button>
                                        <el-button size="mini" type="warning" @click="popup('pwd', scope.row)">
                                            修改密碼
                                        </el-button>


                                    </template>
                                </el-table-column>
                            </el-table>
                            <div style="margin-top: 10px;">
                                <el-pagination
                                        @size-change="size_change"
                                        @current-change="current_change"
                                        :current-page="model.page"
                                        :page-sizes="model.page_sizes"
                                        :page-size="model.limit"
                                        layout="total, sizes, prev, pager, next, jumper"
                                        :total="model.total">
                                </el-pagination>
                            </div>
                        </div>
                    </div>

                    <div class="form-item">
                    </div>
                </div>
            </div>
        </div>
        <!-- 修改手機彈窗 -->
        <el-dialog title="修改會員手機號碼" :visible.sync="dialogPhoneFormVisible">
            <el-form :model="phone_form">
                <el-form-item :label-width="formLabelWidth">
                    <span style="color: red">手機號碼會影響會員其登錄和帳戶安全，請謹慎修改。</span>
                </el-form-item>
                <el-form-item label="手機號碼" prop="phone" :label-width="formLabelWidth" style="width: 50%">
                    <el-input v-model="phone_form.phone"></el-input>
                    <el-button type="primary" @click="send_sms">發送動態密碼</el-button>
                </el-form-item>
                <el-form-item label="簡訊動態密碼" prop="code" :label-width="formLabelWidth" style="width: 40%">
                    <el-input v-model="phone_form.code"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogPhoneFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="save_data('phone')">确定修改</el-button>
            </div>
        </el-dialog>
        <!--end-->
        <!-- 修改郵箱彈窗 -->
        <el-dialog title="修改會員信箱" :visible.sync="dialogEmailFormVisible">

            <el-form :model="email_form">
                <el-form-item :label-width="formLabelWidth">
                    <span style="color: red">信箱會影響會員其登錄和帳戶安全，請謹慎修改。</span>
                </el-form-item>
                <el-form-item label="常用信箱" prop="email" :label-width="formLabelWidth" style="width: 50%">
                    <el-input v-model="email_form.email"></el-input>
                    </el-input>
                    <el-button type="primary" @click="send_sms">發送動態密碼</el-button>
                </el-form-item>
                <el-form-item label="動態密碼" prop="code" :label-width="formLabelWidth" style="width: 40%">
                    <el-input v-model="email_form.code"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogEmailFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="save_data('email')">确定修改</el-button>
            </div>
        </el-dialog>
        <!--end-->
        <!-- 修改郵箱彈窗 -->
        <el-dialog title="修改會員密碼" :visible.sync="dialogPwdFormVisible">

            <el-form :model="pwd_form">
                <el-form-item :label-width="formLabelWidth">
                    <span style="color: red">密碼會影響會員其登錄和帳戶安全，請謹慎修改。</span>
                </el-form-item>
                <el-form-item label="新密碼" prop="password" :label-width="formLabelWidth" style="width: 50%">
                    <el-input v-model="pwd_form.password"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogPwdFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="save_data('pwd')">确定修改</el-button>
            </div>
        </el-dialog>
        <!--end-->
        @include('admin::partials._include_vue_body')
    </div>
    <!--end page-content-wrapper-->
    @include('admin::partials._include_footer')
</div>
<!-- end wrapper -->
@include('admin::partials._include_last_js')

<script>
    Vue.http.options.emulateJSON = true;
    ELEMENT.locale(ELEMENT.lang.zhTW)
    var vue_obj = new Vue({
        el: '#vue_html',
        data: {
            formLabelWidth: "120px",
            dialogEmailFormVisible: false,
            email_form: {
                id: "",
                email: "",
                code: "",
                code_bnt: false
            },
            dialogPhoneFormVisible: false,
            phone_form: {
                id: '',
                phone: "",
                code: "",
                code_bnt: false
            },
            dialogPwdFormVisible:false,
            pwd_form: {
                id: '',
                password: "",
                code_bnt: false
            },
            register_way_list: [],
            grade_id_list: [],
            status_list: [{k: 3, v: "全部"}, {k: 1, v: "啟用"}, {k: 0, v: "停用"}],
            time_type_list: [{k: 1, v: "出生年月日"}, {k: 2, v: "最後下單時間"}, {k: 3, v: "註冊時間"}],
            sex_list: [{k: 1, v: "男"}, {k: 2, v: "女"}, {k: 0, v: "未知"}],
            is_yangxin_list: [{k: 1, v: "陽信卡友"}, {k: 0, v: "非陽信卡友"}],
            is_group_lord_list: [{k: 1, v: "團購主"}, {k: 0, v: "非團購主"}],
            is_say_list: [{k: 3, v: "全部"}, {k: 1, v: "允許"}, {k: 0, v: "禁止"}],
            is_epaper_list: [{k: 1, v: "是"}, {k: 0, v: "否"}],
            model: {
                name: "",
                register_way: "",
                grade_id: "",
                status: "",
                phone: "",
                time_type: "",
                start_time: "",
                end_time: "",
                sex: "",
                is_yangxin: "",
                is_group_lord: "",
                is_say: "",
                is_epaper: "",
                sort: "date_created",
                order: "descending",
                total: 0,
                page: 1,
                page_sizes: [10, 20, 50, 100, 200, 300, 500],
                limit: 10,
            },
            table_data: [],
            multiple_selection: [],
            loading: false,
            clean_model: {},
            history_name: "user_list",

            api_get_tabel: "{{route('user_list')}}",
            api_model_edit: "{{route('user_edit')}}",
        },
        created: function () {
            check_login('{{route('login')}}');
            this.clean_model = deep_copy(this.model);
            var temp_data = get_web_temp_data(this.history_name);
            if (temp_data) {
                this.model = temp_data;
            }
            var grade_id_list = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($grade_id_list) ? $grade_id_list : null)))}}'.replace(/\+/g, " ")));
            if (grade_id_list) {

                this.grade_id_list = grade_id_list;
            }
            var register_way_list = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($register_way_list) ? $register_way_list : null)))}}'.replace(/\+/g, " ")));
            if (register_way_list) {

                this.register_way_list = register_way_list;

            }
        },
        mounted: function () {
            this.get_table_data();
        },
        methods: {
            get_table_data: function () {
                save_web_temp_data(this.history_name, this.model);
                this.loading = true;
                var that = this;
                request_ajax_json(this.api_get_tabel, this.model, function (response) {
                    if (response.status) {
                        switch (response.status) {
                            case 20000:
                                that.loading = false;
                                //console.log(response.data.Data);
                                if (response.data && response.data.list) {
                                    that.table_data = response.data.list;
                                }
                                if (response.data && response.data.total) {
                                    that.model.total = response.data.total;
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
            handle_selection_change: function (val) {
                this.multiple_selection = val;
            },
            handle_sort: function (val) {
                this.model.sort = val.prop;
                this.model.order = val.order;
                this.get_table_data();
            },
            size_change: function (val) {

                this.model.limit = val;
                this.get_table_data();
            },
            current_change: function (val) {

                this.model.page = val;
                this.get_table_data();
            },
            jump: function (index, row) {

                window.location.href = this.api_model_edit + '/' + row.id+"?flag="+index;
            },
            get_date: function (date) {
                if (date && date.length > 4) {
                    return date.split(" ")[0];
                } else {
                    return "";
                }
            },

            clean_form: function () {
                this.model = deep_copy(this.clean_model);
                save_web_temp_data(this.history_name, this.model);
                this.get_table_data();
            },
            popup: function (type, row) {

                if (type == "phone") {
                    this.dialogPhoneFormVisible = true
                    this.phone_form.id = row.id
                    this.phone_form.phone = ""
                    this.phone_form.code = ""

                } else if (type == "email") {
                    this.dialogEmailFormVisible = true
                    this.email_form.id = row.id
                    this.email_form.email = ""
                    this.email_form.code = ""
                } else if(type == "pwd"){
                    this.dialogPwdFormVisible = true
                    this.pwd_form.id = row.id
                    this.pwd_form.password = ""
                }
            },
            save_data: function (type) {
                if (type == "phone") {
                    console.log(this.phone_form)
                    var data = this.phone_form
                    var url = "{{route('user_update_phone')}}"
                } else if (type == "email") {
                    var data = this.email_form
                    var url = "{{route('user_update_email')}}"
                }else if (type == "pwd") {
                    var data = this.pwd_form
                    var url = "{{route('user_update_password')}}"
                }
                var that = this;
                request_ajax_json(url, data, function (response) {
                    if (response.status) {
                        switch (response.status) {
                            case 20000:
                                that.loading = false;
                                that.dialogEmailFormVisible = false;
                                that.dialogPhoneFormVisible = false;
                                that.dialogPwdFormVisible = false;
                                that.get_table_data()
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

            },
            send_sms: function () {

            },
            send_email: function () {

            }

        },
        watch: {}
    });
</script>
</body>

</html>