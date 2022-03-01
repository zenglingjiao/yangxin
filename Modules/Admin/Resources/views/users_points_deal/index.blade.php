<!DOCTYPE html>
<base href="{{asset('')}}"/>
<html lang="en">
<head>
    @include('admin::partials._include_head', ['title' => $title])
</head>
<body>
<style>
    .el-table .warning-row {
        background: oldlace;
    }

    /*.el-table .success-row {*/
    /*  background: #f0f9eb;*/
    /*}*/
</style>
<!-- wrapper -->
<div class="wrapper" id="vue_html" v-cloak>
@include('admin::partials._include_header_aside')
<!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="card radius-15">
                <!-- <div class="card-body d-flex flex-wrap">
                    <template>
                        <el-radio-group v-model="model.status" style="margin-bottom: 30px;">
                            <el-radio-button name="" label="">全部</el-radio-button>
                            <el-radio-button  name="1" label="1">啓用</el-radio-button>
                            <el-radio-button  name="0" label="0">關閉</el-radio-button>
                        </el-radio-group>
                    </template>
                </div> -->
                <div class="card-body d-flex flex-wrap">
                    <div class="list-item">
                        <div class="list-item-box">
                            <input type="text" class="form-control" v-model="model.name" autocomplete="off"
                                   placeholder="名稱"/>
                        </div>
                    </div>
                    <div class="list-item">
                        <!-- <label class="list-item-label">產業別</label> -->
                        <div class="list-item-box">
                            <el-select v-model="model.status" placeholder="產業別">
                                <el-option label="啟用" :value="1"></el-option>
                                <el-option label="停用" :value="0"></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="list-item">
                        <!-- <label class="list-item-label">狀態</label> -->
                        <div class="list-item-box">
                            <el-select v-model="model.status" placeholder="狀態">
                                <el-option label="啟用" :value="1"></el-option>
                                <el-option label="停用" :value="0"></el-option>
                            </el-select>
                        </div>
                    </div>
                    <!-- <div class="list-item">

                        <div class="list-item-box">
                            <el-date-picker
                                    v-model="model.start_time"
                                    type="date"
                                    placeholder="建立開始時間"
                                    format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd">
                            </el-date-picker>
                            -
                            <div class="list-item-box">
                                <el-date-picker
                                        v-model="model.end_time"
                                        type="date"
                                        placeholder="建立結束時間"
                                        format="yyyy-MM-dd"
                                        value-format="yyyy-MM-dd">
                                </el-date-picker>

                            </div>

                        </div>
                    </div> -->
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
{{--                    <div class="form-item">--}}
{{--                        <div class="form-group ml-auto">--}}
{{--                            <a :href="api_model_edit" class="btn btn-info m-1 px-5 radius-30">新增</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="table-responsive">
                        <div class="my-el-table">
                            <el-table :data="table_data" stripe highlight-current-row border
                                      style="width: 100%;"
                                      size="mini"
                                      v-loading="loading"
                                      :row-class-name="tableRowClassName"
                                {{--                                      row-class-name="my-el-tr"--}}
                            >
                                <template slot="empty">
                                    無符合條件記錄
                                </template>

                                <el-table-column header-align="center" align="center" prop="scenario_sort" label="店家編號">
                                    <template slot-scope="scope">
                                        @{{scope.row.storebranch_info.branch_no}}
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="scenario_name" label="公司名稱">
                                    <template slot-scope="scope">
                                        @{{scope.row.storebranch_info.branch_name}}
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="corporate_brand" label="點數類型">
                                    <template slot-scope="scope">
                                        @{{['','陽信點數','自家點數','自家點數','商圈點數'][scope.row.type]}}
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="industry_info.name" label="用途">
                                    <template slot-scope="scope">
                                        @{{['','扣點','贈點'][scope.row.operation_type]}}
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="users_id" label="會員編號"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="users_id" label="姓名"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="users_id" label="手機號碼"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="num" label="點數">
                                    <template slot-scope="scope">
                                        @{{scope.row.num}}點
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="created_at" label="交易日期">
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


                </div>
            </div>
        </div>
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
            dialogFormVisible: false,
            formLabelWidth: '120px',
            model: {
                id: "",
                name: "",
                sort: "date_created",
                order: "descending",
                total: 0,
                page: 1,
                page_sizes: [10, 20, 50, 100, 200, 300, 500],
                limit: 10,
            },
            dialogVisible: false,
            table_data: [],
            multiple_selection: [],
            loading: false,
            clean_model: {},
            history_name: "users_points_deal_list",
            api_get_tabel: "{{route('users_points_deal_list')}}",
            api_model_index: "{{route('users_points_deal_index')}}",
        },
        created: function () {
            check_login('{{route('login')}}');
            this.clean_model = deep_copy(this.model);
            /*var temp_data = get_web_temp_data(this.history_name);
            if(temp_data){
                this.model = temp_data;
            }*/
        },
        mounted: function () {
            this.get_table_data();
        },
        methods: {
            tableRowClassName({row, rowIndex}) {
                if (row.register_audit_status == 1) {
                    return 'warning-row';
                } else {
                    return 'my-el-tr';
                }
            },
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
            size_change: function (val) {
                //console.log(`每页 ${val} 条`);
                this.model.limit = val;
                this.get_table_data();
            },
            current_change: function (val) {
                //console.log(`当前页: ${val}`);
                this.model.page = val;
                this.get_table_data();
            },
            edit_model: function (index, row) {

                window.location.href = this.api_model_edit + "/" + row.id;
            },
            list_model: function (index, row) {

                window.location.href = this.api_model_index + "/" + row.id;
            },
            get_date: function (date) {
                if (date && date.length > 4) {
                    return date.split(" ")[0];
                } else {
                    return "";
                }
            },
            save_data: function () {

                var that = this;
                request_ajax_json(this.api_model_update, this.form, function (response) {
                    if (response.status) {
                        switch (response.status) {
                            case 20000:
                                that.dialogFormVisible = false
                                that.get_table_data();
                                //that.table_data[that.form.index].freight = that.form.freight
                                break;
                            default:
                                // 响应错误回调
                                that.$message({
                                    type: 'warning',
                                    message: response.message
                                });
                                that.get_table_data();
                                break;
                        }
                    }
                }, function () {
                    that.loading = false;
                    that.get_table_data();
                })
            },
            clean_form: function () {
                this.model = deep_copy(this.clean_model);
                save_web_temp_data(this.history_name, this.model);
                this.get_table_data();
            },


        },
        watch: {
            'model.status': function (val) {
                this.model.status = val
                this.get_table_data();
            }
        }
    });
</script>
</body>

</html>
