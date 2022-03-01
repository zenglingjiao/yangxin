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


            </div>
            <div class="card radius-15">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="my-el-table">
                            <el-table :data="table_data" stripe highlight-current-row border
                                      style="width: 100%;"
                                      size="mini"
                                      {{--:default-sort = "{prop:model.sort,order:model.order}"--}}
                                      v-loading="loading"
                                      row-class-name="my-el-tr">
                                <template slot="empty">
                                    無符合條件記錄
                                </template>

                                <el-table-column header-align="center" align="center"  prop="lv" label="等級排序"></el-table-column>
                                <el-table-column header-align="center" align="center"  prop="name" label="名稱"></el-table-column>

                                <el-table-column header-align="center" align="center" width="200" label="操作">
                                    <template slot-scope="scope">
                                        <el-button
                                                size="mini"
                                                type="primary"
                                                @click="edit_model(scope.$index, scope.row)">編輯</el-button>
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
            table_data:[],
            multiple_selection:[],
            loading: false,
            clean_model:{},
            history_name:"grade_list",

            role_list:[],
            group_list:[],
            api_get_tabel:"{{route('grade_list')}}",
            api_model_edit:"{{route('grade_edit')}}",
        },
        created:function () {
            check_login('{{route('login')}}');
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
            edit_model:function (index,row) {
                save_web_temp_data(this.history_name,this.model);
                window.location.href = this.api_model_edit+ '/' + row.id;
            },
        },
        watch: {
        }
    });
</script>
</body>

</html>