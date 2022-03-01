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
                                <el-table-column header-align="center" align="center"  prop="name" label="名稱"></el-table-column>
                                <el-table-column header-align="center" align="center"  prop="sort" label="排序"></el-table-column>
                                <el-table-column header-align="center" align="center"  prop="status" label="狀態"></el-table-column>

                                <el-table-column header-align="center" align="center"  label="操作">
                                    <template slot-scope="scope">
                                        <el-button
                                                size="mini"
                                                type="primary"
                                                @click="edit_model(scope.$index, scope.row)">編輯</el-button>
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

                </div>
            </div>
        </div>
        <!-- 彈窗 -->
        <el-dialog title="紅利專區Banner" :visible.sync="dialogFormVisible">
            <el-form :model="form">
                <el-form-item label="名稱" prop="name"  :label-width="formLabelWidth">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="圖片(電腦版)" :rules="{required: true, message: '請上傳圖片', trigger: 'blur'}">
                    <div v-if="form.pc_img" style="width: 100px;float: left">
                        <img :src="form.pc_img" style="width: 100px; height: 100px">
                    </div>
                    <el-upload style="float: left"
                               name="file"
                               drag
                               action="{{route('upload')}}"
                               :on-success="(res,file)=>{return uploadSuccess(res,'pc_img')}"
                    >
                        <i class="el-icon-upload"></i>
                        <div class="el-upload__text">拖曳圖片至此,或<em>點擊上傳</em></div>
                        <div class="el-upload__tip" slot="tip" >檔案格式：JPG、JPEG、PNG，且5MB以下</div>
                    </el-upload>

                </el-form-item>
                <el-form-item label="圖片(手機版)" :rules="{required: true, message: '請上傳圖片', trigger: 'blur'}">
                    <div v-if="form.phone_img" style="width: 100px;float: left">
                        <img :src="form.phone_img" style="width: 100px; height: 100px">
                    </div>
                    <el-upload style="float: left"
                               name="file"
                               drag
                               action="{{route('upload')}}"
                               :on-success="(res,file)=>{return uploadSuccess(res,'phone_img')}"
                    >
                        <i class="el-icon-upload"></i>
                        <div class="el-upload__text">拖曳圖片至此,或<em>點擊上傳</em></div>
                        <div class="el-upload__tip" slot="tip" >檔案格式：JPG、JPEG、PNG，且5MB以下</div>
                    </el-upload>

                </el-form-item>
                <el-form-item label="說明" prop="remark"  :label-width="formLabelWidth">
                    <el-input v-model="form.remark"></el-input>
                </el-form-item>
                <el-form-item label="排序" prop="sort"  :label-width="formLabelWidth">
                    <el-input v-model="form.sort"></el-input>
                </el-form-item>
                <el-form-item label="狀態" prop="status"  :label-width="formLabelWidth">
                    <template>
                        <el-radio v-model="form.status" :label="1">上架</el-radio>
                        <el-radio v-model="form.status" :label="0">下架</el-radio>
                    </template>
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
            form: {
                id: 0,
                name: '',
                pc_img: '',
                phone_img: '',
                remark:'',
                sort:'0',
                status:0,
            },
            model: {
                id: "",
                name: "",
                code: "",
                status: "",
                sort:"date_created",
                order:"descending",
                total:0,
                page:1,
                page_sizes:[10,20,50,100, 200, 300, 500],
                limit:10,
            },
            table_data:[],
            multiple_selection:[],
            loading: false,
            clean_model:{},
            history_name:"invoice_list",
            api_get_tabel:"{{route('bank_dividend_list')}}",
            api_model_update:"{{route('bank_dividend_update')}}",
        },
        created:function () {
            check_login('{{route('login')}}');
            this.clean_model = deep_copy(this.model);
            var temp_data = get_web_temp_data(this.history_name);
            if(temp_data){
                this.model = temp_data;
            }
        },
        mounted: function () {
            this.get_table_data();
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
                },function () {
                    that.loading = false;
                })
            },
            handle_selection_change:function (val) {
                this.multiple_selection = val;
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
            edit_model:function (index,row) {

                this.form.id = row.id
                this.form.name = row.name
                this.form.code = row.code
                this.form.index = index
                this.dialogFormVisible = true
            },
            add_model:function () {

                this.form.id = 0
                this.form.name = ''
                this.form.code = ''
                this.form.index = ''
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
                },function () {
                    that.loading = false;
                    that.get_table_data();
                })
            },
            clean_form:function(){
                this.model = deep_copy(this.clean_model);
                save_web_temp_data(this.history_name,this.model);
                this.get_table_data();
            },
            uploadSuccess:function (res,index) {
                if (index == "pc_img"){
                    this.form.pc_img = res.data.path;
                } else if(index == "phone_img"){
                    this.form.phone_img = res.data.path;
                }

            },

        },
        watch: {
        }
    });
</script>
</body>

</html>