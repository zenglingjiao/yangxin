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
                                    <a href="{{route('admin_list')}}">管理員列表</a>
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
                                    <el-form-item label="帳號" prop="username">
                                        <el-input v-model="model.username"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :xs="24" :sm="24" :md="12">
                                    <el-form-item label="密碼" prop="password">
                                        <el-input show-password :placeholder="model.id ? '不填則不進行修改 長度 8 碼以上，且必須包含數字、英文字母之組合' :'長度 8 碼以上，且必須包含數字、英文字母之組合'"
                                                  v-model="model.password"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :xs="24" :sm="24" :md="12">
                                    <el-form-item label="信箱" prop="email">
                                        <el-input v-model="model.email"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :xs="24" :sm="24" :md="12">
                                    <el-form-item label="狀態" prop="status">
                                        <el-switch v-model="model.status" active-color="#13ce66" inactive-color="#ff4949" :active-value=1  :inactive-value=0 active-text="啟用" inactive-text="停權"></el-switch>
                                    </el-form-item>
                                </el-col>

                                <el-col :xs="24" :sm="24" :md="12">
                                    <el-form-item label="角色/群組" prop="is_role">
                                        <el-radio-group v-model="model.is_role" @change="console.log(model.is_role);$refs['form'].clearValidate()">
                                            <el-radio-button :label=1>角色</el-radio-button>
                                            <el-radio-button :label=0>群組</el-radio-button>
                                        </el-radio-group>
                                    </el-form-item>
                                </el-col>


                                <el-col :xs="24" :sm="24" :md="12" v-show="model.is_role==1">
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

                                <el-col :xs="24" :sm="24" :md="12" v-show="model.is_role==0">
                                    <el-form-item label="群組" prop="group_id">
                                        <el-select v-model="model.group_id" filterable  placeholder="請選擇">
                                            <el-option v-for="item in group_list"
                                                       :disabled="item.status == 0"
                                                       v-if="item.status != 0||model.group_id == item.id"
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
                    username:"",
                    password:"",
                    email:"",
                    role_list:[],
                    group_id:"",
                    role_ids:[],
                    status:1,
                    is_role:1,
                },
                clean_model:{},
                role_list:[],
                group_list:[],
                loading:false,
                form_is_top:false,
                form_rules: {
                    is_role: [
                        {required: true, message: '請選擇身份/群組', trigger: 'blur'}
                    ],
                    role_ids: [
                        //{required: true, message: '請選擇身份', trigger: 'blur'},
                        {
                            validator: (rule, value, callback) => {
                                if(this.model.is_role==1){
                                    if(!(value&&value.length>0)) callback(new Error('請選擇身份'))
                                }
                                callback();
                            }, trigger: 'blur'
                        },
                    ],
                    group_id: [
                        //{required: true, message: '請選擇群組', trigger: 'blur'}
                        {
                            validator: (rule, value, callback) => {
                                console.log(value);
                                if(this.model.is_role==0){
                                    if(!(value>0)) callback(new Error('請選擇群組'))
                                }
                                callback();
                            }, trigger: 'blur'
                        },
                    ],
                    name: [
                        {required: true, message: '請輸入名稱', trigger: 'blur'}
                    ],
                    username: [
                        {required: true, message: '請輸入帳號', trigger: 'blur'},
                        {
                            validator: (rule, value, callback) => {
                                if (!/^[A-Za-z_\d]{5,18}$/.test(value)) callback(new Error('帳號為5-18位字符'))
                                callback();
                            }, trigger: 'blur'
                        },
                    ],
                    email: [
                        {required: true, message: '請輸入信箱', trigger: 'blur'},
                        {
                            validator: (rule, value, callback) => {
                                if (!/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value)) callback(new Error('請輸入正確的信箱'))
                                callback();
                            }, trigger: 'blur'
                        },
                    ],
                    password: [
                        {
                            validator: (rule, value, callback) => {
                                if(this.model.id>0){

                                }else{
                                    if (!value) callback(new Error('請輸入密碼'))
                                }
                                if (value&&value.length>0) {
                                    if (!/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/.test(value)) callback(new Error('密碼長度8-18碼，且必須包含數字、英文字母之組合'))
                                }
                                callback();
                            }, trigger: 'blur'
                        },
                    ],
                    status: [
                        {required: true, message: '請選擇餐廳狀態', trigger: 'blur'}
                    ],
                },
                api_model_edit: "{{route('admin_update')}}",
                api_model_add: "{{route('admin_add')}}",
                ok_jump_url: "{{route('admin_list')}}",
            }
        },
        created:function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($model) ? $model : null)))}}'.replace(/\+/g," ")));
            if (json_model) {
                if(json_model.group_id&&json_model.group_id>0){
                    json_model.is_role = 0;
                }else{
                    json_model.is_role = 1;
                }
                this.model = json_model;
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
                        if(this.model.is_role==1){
                            this.model.group_id = 0;
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