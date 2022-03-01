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
                            <el-table
                                    :data="table_data"
                                    style="width: 100%;margin-bottom: 20px;"
                                    row-key="id"
                                    border
                                    default-expand-all
                                    :tree-props="{children: 'children', hasChildren: 'hasChildren'}">
                                <el-table-column label="名稱" prop="full_name">

                                </el-table-column>
                                <el-table-column label="路由" prop="route">

                                </el-table-column>
                                <el-table-column label="操作">
                                    <template slot-scope="scope">
                                        <el-button
                                                size="mini"
                                                @click="edit_model(scope.$index, scope.row)">编辑</el-button>
                                        <el-button
                                                size="mini"
                                                type="danger"
                                                @click="del_model(scope.$index, scope.row)">删除</el-button>
                                    </template>
                                </el-table-column>

                            </el-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin::partials._include_vue_body')
    </div>

    <!-- 彈窗 -->
    <el-dialog title="菜單" :visible.sync="dialogFormVisible">
        <el-form :model="form" :rules="form_rules">

            <el-form-item label="父級" prop="parent" :label-width="formLabelWidth" >
                <el-select v-model="form.parent" placeholder="请选择类型" style="width: 100%">
                    <el-option  label="root" value=0></el-option>
                    <el-option v-for="item in options" :label=item.v :value=item.k></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="全稱" prop="full_name"  :label-width="formLabelWidth">
                <el-input v-model="form.full_name"></el-input>
            </el-form-item>
            <el-form-item label="別稱" prop="name"  :label-width="formLabelWidth">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="組名" prop="guard_name"  :label-width="formLabelWidth">
                <el-input  v-model="form.guard_name"></el-input>
            </el-form-item>
            <el-form-item label="菜單" prop="is_menu"  :label-width="formLabelWidth">
                <template>
                    <el-radio v-model="form.is_menu" label="0">否</el-radio>
                    <el-radio v-model="form.is_menu" label="1">是</el-radio>
                </template>
            </el-form-item>
            <el-form-item label="路由" prop="is_route"  :label-width="formLabelWidth">
                <template>
                    <el-radio v-model="form.is_route" label="0">否</el-radio>
                    <el-radio v-model="form.is_route" label="1">是</el-radio>
                </template>
            </el-form-item>
            <el-form-item label="路由地址" prop="route"  :label-width="formLabelWidth">
                <el-input  v-model="form.route"></el-input>
            </el-form-item>
            <el-form-item label="active" prop="active"  :label-width="formLabelWidth">
                <el-input  v-model="form.active"></el-input>
            </el-form-item>
            <el-form-item label="ico" prop="ico"  :label-width="formLabelWidth">
                <el-input  v-model="form.ico"></el-input>
            </el-form-item>
            <el-form-item label="排序" prop="sort"  :label-width="formLabelWidth">
                <el-input  v-model="form.sort"></el-input>
            </el-form-item>
        </el-form>

        <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisible = false">取 消</el-button>
            <el-button type="primary" @click="save_data">确 定</el-button>
        </div>
    </el-dialog>
    <!--end-->
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
                parent: '',
                name: '',
                guard_name: '',
                full_name: '',
                is_menu:0,
                is_route:0,
                route:'',
                active:'',
                ico:'',
                sort:0,
            },
            table_data:[],
            multiple_selection:[],
            loading: false,
            clean_model:{},
            history_name:"menu_list",
            form_rules: {
                name: [
                    {required: true, message: '請輸入名稱', trigger: 'blur'}
                ],
                guard_name: [
                    {required: true, message: '請輸入组名', trigger: 'blur'}
                ],
                full_name: [
                    {required: true, message: '請輸入全称', trigger: 'blur'}
                ],
            },
            api_get_tabel:"{{route('get_menu_list')}}",
            api_get_menu_select:"{{route('get_menu_select')}}",
            api_model_update:"{{route('menu_update')}}",
            api_model_delete:"{{route('menu_del')}}",
        },
        created:function () {
            check_login('{{route('login')}}');
        },
        mounted: function () {
            this.get_table_data();
            this.get_menu_select();
        },
        methods: {
            get_table_data: function () {
                save_web_temp_data(this.history_name,this.model);
                this.loading = true;
                var that = this;
                request_ajax_json(this.api_get_tabel, this.model, function (response) {
                    if (response.status) {
                        switch (response.status) {
                            case 20000:
                                that.loading = false;
                                //console.log(response.data.Data);
                                if (response.data ) {
                                    that.table_data = response.data;
                                }
                                break;
                            default:
                                // 响应错误回调
                                that.loading = false;
                                break;
                        }
                    }
                },function () {
                    that.loading = false;
                })
            },
            get_menu_select: function () {
                this.loading = true;
                var that = this;
                request_ajax_json(this.api_get_menu_select, '', function (response) {
                    if (response.status) {
                        switch (response.status) {
                            case 20000:
                                that.loading = false;
                                console.log(response.data);
                                if (response.data ) {
                                    that.options = response.data;
                                }
                                break;
                            default:
                                // 响应错误回调
                                that.loading = false;
                                break;
                        }
                    }
                },function () {
                    that.loading = false;
                })
            },
            handle_selection_change:function (val) {
                this.multiple_selection = val;
            },
            handle_sort:function (val) {
                this.model.sort = val.prop;
                this.model.order = val.order;
                this.get_table_data();
            },
            size_change:function (val) {
                //console.log(`每页 ${val} 条`);
                this.model.limit = val;
                this.get_table_data();
            },
            current_change:function (val) {
                //console.log(`当前页: ${val}`);
                this.model.page = val;
                this.get_table_data();
            },
            add_model:function () {
                this.form.id = 0
                this.form.parent = '0'
                this.form.name = ''
                this.form.guard_name = ''
                this.form.full_name = ''
                this.form.is_menu = '0'
                this.form.is_route = '0'
                this.form.route = ""
                this.form.active = ""
                this.form.ico = ''
                this.form.sort = 0
                this.dialogFormVisible = true
            },
            edit_model:function (index,row) {
                save_web_temp_data(this.history_name,this.model);
               // this.form = row;
                this.form.id = row.id
                if (row.parent == 0){
                    this.form.parent = String(row.parent)
                } else{
                    this.form.parent = row.parent
                }
                this.form.name = row.name
                this.form.guard_name = row.guard_name
                this.form.full_name = row.full_name
                this.form.is_menu = String(row.is_menu)
                this.form.is_route = String(row.is_route)
                this.form.route = row.route
                this.form.active = row.active
                this.form.ico = row.ico
                this.form.sort = row.sort
                this.dialogFormVisible = true
            },
            get_date:function (date) {
                if (date && date.length > 4) {
                    return date.split(" ")[0];
                } else {
                    return "";
                }
            },

            save_data:function () {
                console.log(this.form)
                var that = this;
                request_ajax_json(this.api_model_update, this.form, function (response) {
                    if (response.status) {
                        switch (response.status) {
                            case 20000:
                                that.dialogFormVisible = false
                                that.get_table_data();
                                that.get_menu_select();
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
                },function () {
                    that.loading = false;
                    that.get_table_data();
                })
            },
            del_model:function (index,row) {
                var selectid = [];
                if(row&&row.id>0){
                    selectid.push(row.id);
                }else{
                    this.multiple_selection.forEach(function (item) {
                        selectid.push(item.id);
                    });
                    if(!selectid.length>0){
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
                }).then(function (result){
                    if (result.value) {
                        that.loading = true;
                        request_ajax_json(that.api_model_delete, {
                            ids:selectid,
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
                        },function () {
                            that.loading = false;
                            that.get_table_data();
                        })
                    }
                })
            },
        },
        watch: {
        }
    });
</script>
</body>

</html>