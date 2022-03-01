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
                        <label class="list-item-label">名稱/帳號</label>
                        <div class="list-item-box">
                            <input type="text" class="form-control" v-model="model.name" autocomplete="off" placeholder="名稱/帳號"/>
                        </div>
                    </div>
                    <div class="list-item">
                        <label class="list-item-label">群組</label>
                        <div class="list-item-box">
                            <el-select v-model="model.group" filterable placeholder="群組">
                                <el-option
                                        v-for="item in group_list"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="list-item">
                        <label class="list-item-label">身份</label>
                        <div class="list-item-box">
                            <el-select v-model="model.role_id" filterable placeholder="身份">
                                <el-option
                                        v-for="item in role_list"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="list-item">
                        <label class="list-item-label">狀態</label>
                        <div class="list-item-box">
                            <el-select v-model="model.status" placeholder="狀態">
                                <el-option label="啟用" :value="1"></el-option>
                                <el-option label="停用" :value="0"></el-option>
                            </el-select>
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
                        <!--<div class="form-group">-->
                        <!--    <label></label>-->
                        <!--    <div class="mx-sm-3"></div>-->
                        <!--</div>-->
                        <!--<div class="form-group">-->
                        <!--    <label></label>-->
                        <!--    <input type="text" class="form-control mx-sm-3" >-->
                        <!--</div>-->
                        <div class="form-group ml-auto">
                            <a href="{{route('admin_edit')}}" class="btn btn-info m-1 px-5 radius-30">新增</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="my-el-table">
                            <el-table :data="table_data" stripe highlight-current-row border
                                      style="width: 100%;"
                                      size="mini"
                                      :default-sort = "{prop:model.sort,order:model.order}"
                                      @sort-change="handle_sort"
                                      @selection-change="handle_selection_change"
                                      v-loading="loading"
                                      row-class-name="my-el-tr">
                                <template slot="empty">
                                    無符合條件記錄
                                </template>
                                <el-table-column type="selection" prop="id"></el-table-column>
                                <el-table-column header-align="center" align="center" sortable="custom" prop="username" label="管理員賬號"></el-table-column>
                                <el-table-column header-align="center" align="center" sortable="custom" prop="name" label="姓名"></el-table-column>
                                <el-table-column header-align="center" align="center" prop="group" label="群組">
                                    <template slot-scope="scope" v-if="scope.row.group">
                                        <el-tag class="m-1">@{{(scope.row.group)?scope.row.group.name:'-'}}</el-tag>
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" align="center" prop="role_list" label="身份">
                                    <template slot-scope="scope">
                                        <el-tag class="m-1" v-for="r in scope.row.role_list?scope.row.role_list:[]">@{{r.name}}</el-tag>
                                    </template>
                                </el-table-column>
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

                                <el-table-column header-align="center" align="center" width="200" label="操作">
                                    <template slot-scope="scope">
                                        <el-button
                                                size="mini"
                                                type="primary"
                                                @click="edit_model(scope.$index, scope.row)">編輯</el-button>
                                        <el-button
                                                size="mini"
                                                type="danger"
                                                @click="del_model(scope.$index, scope.row)">刪除</el-button>
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
                        <!--<div class="form-group">-->
                        <!--    <label></label>-->
                        <!--    <div class="mx-sm-3"></div>-->
                        <!--</div>-->
                        <!--<div class="form-group">-->
                        <!--    <label></label>-->
                        <!--    <input type="text"  class="form-control mx-sm-3" >-->
                        <!--</div>-->
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
            model: {
                name: "",
                role_id: "",
                status:"",

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
            history_name:"admin_list",

            role_list:[],
            group_list:[],
            api_get_tabel:"{{route('get_admin_list')}}",
            api_model_edit:"{{route('admin_edit')}}",
            api_model_delete:"{{route('admin_del')}}",
            api_table_status:"{{route('admin_status')}}",
        },
        created:function () {
            check_login('{{route('login')}}');
            this.clean_model = deep_copy(this.model);
            var temp_data = get_web_temp_data(this.history_name);
            if(temp_data){
                this.model = temp_data;
            }
            var role_list = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($role_list) ? $role_list : null)))}}'.replace(/\+/g," ")));
            if (role_list) {
                this.role_list = role_list;
            }
            var group_list = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($group_list) ? $group_list : null)))}}'.replace(/\+/g," ")));
            if (group_list) {
                this.group_list = group_list;
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
            edit_model:function (index,row) {
                save_web_temp_data(this.history_name,this.model);
                window.location.href = this.api_model_edit+ '/' + row.id;
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
            clean_form:function(){
                this.model = deep_copy(this.clean_model);
                save_web_temp_data(this.history_name,this.model);
                this.get_table_data();
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