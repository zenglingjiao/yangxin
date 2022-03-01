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
                <div class="card-body">
                     <div class="form-item">
                         <div class="form-group ml-auto">
                             <el-button type="primary" @click="add_model">新增</el-button>
                         </div>
                     </div>
                    <div class="table-responsive">
                        <div class="my-el-table">
                            <el-table :data="table_data" stripe highlight-current-row border
                                      style="width: 100%;"
                                      size="mini"
                                      v-loading="loading"
                                      row-class-name="my-el-tr">
                                <template slot="empty">
                                    無符合條件記錄
                                </template>
                                <el-table-column header-align="center" align="center" prop="sort"
                                                 label="排序"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="name"
                                                 label="名稱"></el-table-column>

                                <el-table-column header-align="center" align="center" label="操作">
                                    <template slot-scope="scope">

                                        <el-button size="mini" type="primary"
                                                   @click="edit_model(scope.$index, scope.row)">
                                            編輯
                                        </el-button>
                                        <el-button size="mini" type="danger"
                                                   @click="del_model(scope.$index, scope.row)">
                                            删除
                                        </el-button>


                                    </template>
                                </el-table-column>
                            </el-table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- 彈窗 -->
        <el-dialog title="編輯" :visible.sync="dialogFormVisible">
            <el-form :model="form">
                <el-form-item label="名称" prop="name" :label-width="formLabelWidth">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="操作" prop="jump_type" :label-width="formLabelWidth">
                    <el-select v-model="model.jump_type" filterable>
                        <el-option label="無操作" value="0"></el-option>
                        <el-option v-for="item in options" :label=item.v :value=item.k></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="跳转" prop="jump_url" :label-width="formLabelWidth">
                    <el-input v-model="form.jump_url"></el-input>
                </el-form-item>
                <el-form-item label="排序" prop="sort" :label-width="formLabelWidth">
                    <el-input v-model="form.sort"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="save_data">确 定</el-button>
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
            dialogFormVisible: false,
            formLabelWidth: '120px',
            options:{},
            form: {
                id: 0,
                type: "pc",
                name: '',
                jump_type: '0',
                jump_url: '',
                sort: 0,
            },
            model: {
                id: "",
                name: "",
                sort: "",
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
            history_name: "navi_index_list",

            role_list: [],
            group_list: [],
            api_get_tabel: "{{route('navi_list')}}",
            api_model_update: "{{route('navi_update')}}",
            api_model_delete: "{{route('navi_del')}}",
        },
        created: function () {
            check_login('{{route('login')}}');
            this.clean_model = deep_copy(this.model);
            var temp_data = get_web_temp_data(this.history_name);
            if (temp_data) {
                this.model = temp_data;
            }
            var role_list = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($role_list) ? $role_list : null)))}}'.replace(/\+/g, " ")));
            if (role_list) {
                this.role_list = role_list;
            }
            var group_list = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($group_list) ? $group_list : null)))}}'.replace(/\+/g, " ")));
            if (group_list) {
                this.group_list = group_list;
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
                                if (response.data) {
                                    that.table_data = response.data;
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

                this.form.id = row.id
                this.form.name = row.name
                this.form.jump_type = String(row.jump_type)
                this.form.jump_url = row.jump_url
                this.form.sort = row.sort
                this.dialogFormVisible = true
            },
            add_model: function () {

                this.form.id = 0
                this.form.name = ''
                this.form.jump_type = '0'
                this.form.jump_url = ''
                this.form.sort = 0
                this.dialogFormVisible = true
            },
            get_date: function (date) {
                if (date && date.length > 4) {
                    return date.split(" ")[0];
                } else {
                    return "";
                }
            },
            jump: function (id) {

                window.location.href = "{{route('menu_footer')}}/" + id
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
            del_model: function (index, row) {
                var selectid = [];
                if (row && row.id > 0) {
                    selectid.push(row.id);
                } else {
                    this.multiple_selection.forEach(function (item) {
                        selectid.push(item.id);
                    });
                    if (!selectid.length > 0) {
                        Swal.fire("請至少選擇一條記錄");
                        return false;
                    }
                }
                var that = this;
                Swal.fire({
                    title: '確定刪除資料?',
                    text: "刪除後無法還原!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '刪除',
                    cancelButtonText: '取消',
                }).then(function (result) {
                    if (result.value) {
                        that.loading = true;
                        request_ajax_json(that.api_model_delete, {
                            ids: selectid,
                        }, function (response) {
                            if (response.status) {
                                that.loading = false;
                                switch (response.status) {
                                    case 20000:
                                        that.$message({
                                            type: 'success',
                                            message: response.message
                                        });
                                        that.get_table_data();
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
                    }
                })
            },
        },
        watch: {}
    });
</script>
</body>

</html>