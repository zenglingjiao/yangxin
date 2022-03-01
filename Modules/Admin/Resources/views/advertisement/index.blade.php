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
                    <template>
                        <el-radio-group v-model="model.status" style="margin-bottom: 30px;">
                            <el-radio-button name="" label="">全部</el-radio-button>
                            <el-radio-button  name="1" label="1">啓用</el-radio-button>
                            <el-radio-button  name="0" label="0">關閉</el-radio-button>
                        </el-radio-group>
                    </template>
                </div>
                <div class="card-body d-flex flex-wrap">
                    <div class="list-item">
                        <div class="list-item-box">
                            <input type="text" class="form-control" v-model="model.name" autocomplete="off" placeholder="名稱"/>
                        </div>
                    </div>
                    <div class="list-item">

                        <div class="list-item-box">
                            <el-date-picker
                                    v-model="model.up_time"
                                    type="date"
                                    placeholder="上架時間開始"
                                    format="yyyy-MM-dd"
                                    value-format="yyyyMMdd">
                            </el-date-picker>
                            -
                            <div class="list-item-box">
                                <el-date-picker
                                        v-model="model.down_time"
                                        type="date"
                                        placeholder="下架時間結束"
                                        format="yyyy-MM-dd"
                                        value-format="yyyyMMdd">
                                </el-date-picker>

                            </div>

                        </div>
                    </div>
                    <div class="list-item-right-btn ml-auto">
                        <button type="button" @click="clean_form()" class="btn btn-light">清除</button>
                        <button type="button" @click="model.page=1;model.total=0;get_table_data()" class="btn btn-info">查询</button>
                    </div>
                </div>
            </div>
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
                                      @selection-change="handle_selection_change"
                                      v-loading="loading"
                                      row-class-name="my-el-tr">
                                <template slot="empty">
                                    無符合條件記錄
                                </template>
                                <el-table-column type="selection" prop="id"></el-table-column>
                                <el-table-column header-align="center" align="center"  prop="name" label="名稱"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="pc_img" label="網頁版縮圖">
                                    <templage slot-scope="scope">
                                        <img :src="scope.row.pc_img" style="width: 100px; height: 100px">
                                    </templage>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="phone_img" label="手機版縮圖">
                                    <templage slot-scope="scope">
                                        <img :src="scope.row.phone_img" style="width: 100px; height: 100px">
                                    </templage>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="up_time" label="上架時間"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="down_time" label="下架時間"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="status" label="狀態">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.status == 0">關閉</div><div v-else>啓用</div>
                                    </template>
                                </el-table-column>

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
        <el-dialog title="編輯" :visible.sync="dialogFormVisible">
            <el-form :model="form">
                <el-form-item label="名称" prop="name" :label-width="formLabelWidth">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>

                <el-form-item label="電腦圖" prop="pc_img" :label-width="formLabelWidth">
                    <div v-if="form.pc_img">
                        <img :src="form.pc_img" style="width: 100px; height: 100px">
                    </div>
                    <el-upload
                            name="file"
                            drag
                            action="{{route('upload')}}"
                            :on-success="(res,file)=>{return uploadSuccess(res,file,'pc_img')}"
                    >
                        <i class="el-icon-upload"></i>
                        <div class="el-upload__text">拖曳圖片至此,或<em>點擊上傳</em></div>
                        <div class="el-upload__tip" slot="tip">檔案格式：JPG、JPEG、PNG，且5MB以下</div>
                    </el-upload>

                </el-form-item>
                <el-form-item label="手機圖" prop="phone_img" :label-width="formLabelWidth">
                    <div v-if="form.phone_img">
                        <img :src="form.phone_img" style="width: 100px; height: 100px">
                    </div>
                    <el-upload
                            name="file"
                            drag
                            action="{{route('upload')}}"
                            :on-success="(res,file)=>{return uploadSuccess(res,file,'phone_img')}"
                    >
                        <i class="el-icon-upload"></i>
                        <div class="el-upload__text">拖曳圖片至此,或<em>點擊上傳</em></div>
                        <div class="el-upload__tip" slot="tip">檔案格式：JPG、JPEG、PNG，且5MB以下</div>
                    </el-upload>

                </el-form-item>
                <el-form-item label="操作" prop="jump_type" :label-width="formLabelWidth">
                    <el-select v-model="form.jump_type" filterable>
                        <el-option v-for="item in options" :label=item.v :value=item.k></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="跳轉" prop="jump_url" :label-width="formLabelWidth">
                    <el-input v-model="form.jump_url"></el-input>
                </el-form-item>
                <el-form-item label="上架時間" prop="up_time" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="time_select"
                            type="daterange"
                            range-separator="至"
                            start-placeholder="開始日期"
                            end-placeholder="結束日期"  format="yyyy-MM-dd"
                            value-format="yyyyMMdd">
                    </el-date-picker>

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
            options:[
                {k:1,v:"外部連結"},
                {k:2,v:"關鍵詞"},
                {k:3,v:"平台活動號"},
                {k:4,v:"商品號"},
                {k:5,v:"店家號"},
            ],
            time_select:[],
            form: {
                id: 0,
                name: "",
                type: '{{$type}}',
                pc_img: '',
                phone_img: '',
                up_time: '',
                down_time: '',
                jump_type: 1,
                jump_url: '',
                sort: '',
            },
            model: {
                id: "",
                type: "{{$type}}",
                name: "",
                up_time: "",
                down_time: "",
                status: "",
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
            history_name: "advertisement_{{$type}}_list",
            api_get_tabel: "{{route('advertisement_list')}}",
            api_model_update: "{{route('advertisement_update')}}",
            api_model_delete: "{{route('advertisement_del')}}",
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
                this.form.name = row.name
                this.form.pc_img = row.pc_img
                this.form.phone_img = row.phone_img
                this.form.jump_type = row.jump_type
                this.form.jump_url = row.jump_url
                this.form.up_time = String(row.up_time)
                this.form.down_time = String(row.down_time)
                this.time_select[0] = String(row.up_time)
                this.time_select[1] = String(row.down_time)
                this.form.sort = row.sort
                this.dialogFormVisible = true
            },
            add_model: function () {

                this.form.id = 0
                this.form.name = ''
                this.form.pc_img = ''
                this.form.phone_img = ''
                this.form.jump_type = 1
                this.form.jump_url = ''
                this.form.up_time = ''
                this.form.down_time = ''
                this.form.sort = '0'
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
                if (index == "pc_img"){
                    this.form.pc_img = res.data.path;
                } else if(index == "phone_img"){
                    this.form.phone_img = res.data.path;
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
        watch: {
            'model.status':function (val) {
                this.model.status = val
                this.get_table_data();
            },
            time_select:function (val) {
                this.form.up_time = val[0]
                this.form.down_time = val[1]
            }
        }
    });
</script>
</body>

</html>