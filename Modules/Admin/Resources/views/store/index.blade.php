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
                            <input type="text" class="form-control" v-model="model.name" autocomplete="off" placeholder="名稱"/>
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
                        <button type="button" @click="model.page=1;model.total=0;get_table_data()" class="btn btn-info">查询</button>
                    </div>
                </div>
            </div>
            <div class="card radius-15">
                <div class="card-body">
                    <div class="form-item">
                        <div class="form-group ml-auto">
                            <a href="{{route('industry_category')}}" class="btn btn-info m-1 px-5 radius-30">產業別設定</a>
                            <a href="javascript:;" class="btn btn-info m-1 px-5 radius-30">匯出</a>
                            <a href="{{route('store_edit')}}" class="btn btn-info m-1 px-5 radius-30">新增</a>
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

                                <el-table-column header-align="center" align="center"  prop="store_no" label="店家編號"></el-table-column>
                                <el-table-column header-align="center" align="center"  prop="company_name" label="公司名稱"></el-table-column>
                                <el-table-column header-align="center" align="center"  prop="corporate_brand" label="公司品牌"></el-table-column>
                                <el-table-column header-align="center" align="center"  prop="industry_info.name" label="產業別"></el-table-column>
                                <el-table-column header-align="center" align="center"  prop="tax_id" label="統一編號"></el-table-column>
                                <el-table-column header-align="center" align="center"  prop="company_name" label="點數名稱"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="status" label="狀態">
                                    <template slot-scope="scope">
                                        <el-switch
                                                v-model="scope.row.status"
                                                @change="change_switch(scope.row.id,scope.row.status)"
                                                :active-value=1
                                                :inactive-value=0
                                                active-color="#13ce66"
                                                inactive-color="#ff4949">
                                        </el-switch>
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center"  label="操作">
                                    <template slot-scope="scope">
                                        <el-button
                                                v-if="scope.row.have_branch == 1"
                                                size="mini"
                                                type="primary"
                                                @click="edit_model_branch(scope.$index, scope.row)">分店</el-button>
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
            history_name:"store_list",
            api_get_tabel:"{{route('store_list')}}",
            api_model_index:"{{route('store_index')}}",
            api_model_edit:"{{route('store_edit')}}",
            api_table_status:"{{route('store_status')}}",
        },
        created:function () {
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

                window.location.href = this.api_model_edit+"/"+row.id;
            },

            edit_model_branch:function (index,row) {

                window.location.href = "{{route('branch')}}"+"/"+row.id;
            },
            list_model:function (index,row) {

                window.location.href = this.api_model_index+"/"+row.id;
            },
            get_date:function (date) {
                if (date && date.length > 4) {
                    return date.split(" ")[0];
                } else {
                    return "";
                }
            },
            change_switch:function (id, status) {
                this.loading = true;
                var that = this;
                request_ajax_json(this.api_table_status, {
                    id:id,
                    status:status,
                }, function (response) {
                    if (response.status) {
                        switch (response.status) {
                            case 20000:
                                that.loading = false;
                                break;
                            default:
                                // 响应错误回调
                                that.loading = false;
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


        },
        watch: {
            'model.status':function (val) {
                this.model.status = val
                this.get_table_data();
            }
        }
    });
</script>
</body>

</html>
