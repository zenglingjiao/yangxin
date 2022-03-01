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
    <!--page-wrapper-->
    <div class="page-wrapper">
        <!--page-content-wrapper-->
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="page-breadcrumb d-md-flex align-items-center mb-3">
                    <!--<div class="breadcrumb-title pr-3"></div>-->
                    <div class="pl-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin_index')}}"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{route('group_list')}}">群組列表</a>
                                </li>
                                <li class="breadcrumb-item active">@{{model.id?"編輯":"新增"}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card radius-15">
                    <div class="card-body">
                        <el-form ref="form" :rules="form_rules" v-loading="loading" :model="model" label-width="120px" :label-position="form_is_top ? 'top' : 'right'">
                            <el-row>
                                <el-col :xs="24" :sm="24" :md="12">
                                    <el-form-item label="名稱" prop="name">
                                        <el-input v-model="model.name"></el-input>
                                    </el-form-item>
                                </el-col>

                                <el-col :xs="24" :sm="24" :md="12">
                                    <el-form-item label="身份" prop="role_ids">
                                        <el-select v-model="model.role_ids" filterable multiple placeholder="請選擇">
                                            <el-option v-for="item in role_list"
                                                       :disabled="item.status == 0"
                                                       v-if="item.status != 0||model.role_ids.indexOf(item.id)>-1"
                                                       :label="item.name" :value="item.id" :key="item.id">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                            </el-row>

                            <el-form-item>
                                <el-button type="primary" @click="send_form('form')">保存</el-button>
                                <el-button @click="cancel">取消</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                </div>
            </div>
        </div>
        <!--end page-content-wrapper-->
        @include('admin::partials._include_vue_body')
    </div>
    <!--end page-wrapper-->
    @include('admin::partials._include_footer')
</div>
<!-- end wrapper -->
@include('admin::partials._include_last_js')

<script>
    $(function () {
    });
    ELEMENT.locale(ELEMENT.lang.zhTW)
    var vue_obj = new Vue({
        el: '#vue_html',
        data: function(){
            return {
                model: {
                    id:"",
                    name:"",
                    role_list:[],
                    role_ids:[],
                    status:1
                },
                clean_model:{},
                role_list:[],
                loading:false,
                form_is_top:false,
                form_rules: {
                    role_ids: [
                        {required: true, message: '請選擇身份', trigger: 'blur'}
                    ],
                    name: [
                        {required: true, message: '請輸入名稱', trigger: 'blur'}
                    ]
                },
                api_model_edit: "{{route('group_update')}}",
                api_model_add: "{{route('group_add')}}",
                ok_jump_url: "{{route('group_list')}}",
            }
        },
        created:function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($model) ? $model : null)))}}'.replace(/\+/g," ")));
            if (json_model) {
                this.model = json_model;
            }
            var role_list = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($role_list) ? $role_list : null)))}}'.replace(/\+/g," ")));
            if (role_list) {
                this.role_list = role_list;
            }
        },
        mounted: function () {
            this.get_device_size();
            window.addEventListener('resize',()=>{
                this.get_device_size();
            });

        },
        methods: {
            send_form:function (form_name) {
                this.$refs[form_name].validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        var that = this;
                        this.model.role_list = [];
                        var url = this.api_model_edit;
                        if(this.model.id>0){

                        }else{
                            url = this.api_model_add;
                        }
                        request_ajax_json(url, this.model, function (response) {
                            that.loading = false;
                            if (response.status) {
                                switch (response.status) {
                                    case 20000:
                                        that.$message({
                                            type: 'success',
                                            message: response.message
                                        });
                                        window.location.href = that.ok_jump_url;
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
                        },function () {
                            that.loading = false;
                        })
                    } else {
                        return false;
                    }
                });
            },
            get_device_size:function () {
                let winW = window.innerWidth;
                if(winW < 500){
                    this.form_is_top = true
                }else{
                    this.form_is_top = false
                }
            },
            cancel:function () {
                history.back();
            }
        },
        watch: {
            model: {
                handler(newName, oldName) {
                    this.$nextTick(function () {
                        //$('.selectpicker').selectpicker('refresh');
                    });
                },
                deep: true
            }
        }
    });
</script>
</body>

</html>