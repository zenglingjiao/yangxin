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
                                <el-table-column header-align="center" align="center" prop="id"
                                                 label="序號"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="en_name"
                                                 label="品牌英文名稱"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="zh_name"
                                                 label="品牌中文名稱"></el-table-column>

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
                <el-form-item label="英文名称" prop="en_name" :label-width="formLabelWidth">
                    <el-input v-model="form.en_name"></el-input>
                </el-form-item>
                <el-form-item label="中文名称" prop="zh_name" :label-width="formLabelWidth">
                    <el-input v-model="form.zh_name"></el-input>
                </el-form-item>
                <el-form-item label="LOGO" prop="logo" :label-width="formLabelWidth">
                    <div v-if="form.logo">
                        <img :src="form.logo" style="width: 100px; height: 100px">
                    </div>
                    <el-upload
                            name="file"
                            drag
                            action="{{route('upload')}}"
                            :on-success="(res,file)=>{return uploadSuccess(res,file,'logo')}"
                    >
                        <i class="el-icon-upload"></i>
                        <div class="el-upload__text">拖曳圖片至此,或<em>點擊上傳</em></div>
                        <div class="el-upload__tip" slot="tip">檔案格式：JPG、JPEG、PNG，且5MB以下</div>
                    </el-upload>

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
                en_name: "",
                zh_name: '',
                logo: '',
            },
            model: {
                id: "",
                en_name: "",
                zh_name: "",
                logo: "",
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
            history_name: "brand_index_list",
            api_get_tabel: "{{route('brand_list')}}",
            api_model_update: "{{route('brand_update')}}",
            api_model_delete: "{{route('brand_del')}}",
        },
        created: function () {
            check_login('{{route('login')}}');
            this.clean_model = deep_copy(this.model);
            var temp_data = get_web_temp_data(this.history_name);
            if (temp_data) {
                this.model = temp_data;
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
                                    that.table_data = response.data.list;
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
                this.form.zh_name = row.zh_name
                this.form.en_name = row.en_name
                this.form.logo = row.logo
                this.dialogFormVisible = true
            },
            add_model: function () {

                this.form.id = 0
                this.form.zh_name = ''
                this.form.en_name = ''
                this.form.logo = ''
                this.dialogFormVisible = true
            },
            get_date: function (date) {
                if (date && date.length > 4) {
                    return date.split(" ")[0];
                } else {
                    return "";
                }
            },
            uploadSuccess:function (res,file,index) {
                    this.form.logo = res.data.path;
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