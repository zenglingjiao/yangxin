<script type="text/x-template" id="password-template">
    <el-dialog
            title="修改密碼"
            :visible.sync="show_password.show"
            :modal-append-to-body="false"
            :append-to-body="true"
            :close-on-click-modal="false"
            width="380px"
            center>
        <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
            <el-form-item label="原密碼" prop="oldPass">
                <el-input type="password" v-model="ruleForm.oldPass" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="pass">
                <el-input type="password" v-model="ruleForm.pass" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="确认密码" prop="checkPass">
                <el-input type="password" v-model="ruleForm.checkPass" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm')">確認</el-button>
                <el-button @click="resetForm('ruleForm')">重置輸入</el-button>
            </el-form-item>
        </el-form>
    </el-dialog>
</script>

<script>
    var com_password = {show:false};
    Vue.component('password', {
        props: [],
        data: function () {
            var validateOldPass = (rule, value, callback) => {
                if (!value) {
                    return callback(new Error('原密碼不能為空'));
                }
                callback();
            };
            var validatePass = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('請輸入新密碼'));
                } else {
                    if (this.ruleForm.checkPass !== '') {
                        this.$refs.ruleForm.validateField('checkPass');
                    }
                    callback();
                }
            };
            var validatePass2 = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('請再次輸入新密碼'));
                } else if (value !== this.ruleForm.pass) {
                    callback(new Error('兩次輸入新密碼不一致!'));
                } else {
                    callback();
                }
            };
            return {
                ruleForm: {
                    oldPass:'',
                    pass: '',
                    checkPass: '',
                },
                rules: {
                    oldPass: [
                        { validator: validateOldPass, trigger: 'blur' },
                        { min: 8, max: 18, message: '長度在8 - 18之間', trigger: 'blur' }
                    ],
                    pass: [
                        { validator: validatePass, trigger: 'blur' },
                        { min: 8, max: 18, message: '長度在8 - 18之間', trigger: 'blur' }
                    ],
                    checkPass: [
                        { validator: validatePass2, trigger: 'blur' },
                        { min: 8, max: 18, message: '長度在8 - 18之間', trigger: 'blur' }
                    ]
                },
                show_password:com_password
            };
        },
        template: '#password-template',
        methods:{
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        com_password.show=false;
                        request_ajax_json("{{ route('upadte_password') }}", [
                            {name:"y_password",value:this.ruleForm.oldPass},
                            {name:"password",value:this.ruleForm.pass},
                            {name:"password_confirmation",value:this.ruleForm.checkPass},
                        ], function (response) {
                            //console.log(response.data.Data);
                            if (response.status) {
                                switch (response.status) {
                                    case 20000:
                                        if (response.message && $.trim(response.message) != "") {
                                            Swal.fire({
                                                title:'修改成功',
                                                text:'等待跳轉',
                                                timer:2000,
                                                showConfirmButton:false
                                            });
                                        }
                                        $('#password_modal').modal('hide');
                                        //logout('{{ route('login') }}');
                                        logout_server('{{ route('logout') }}','{{ route('login') }}');
                                        break;
                                    default:
                                        if (response.message && $.trim(response.message) != "") {
                                            Swal.fire({
                                                title: response.message,
                                                text: null,
                                                icon: "error",
                                                showCancelButton: false,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: '確定',
                                                cancelButtonText: '取消',
                                            }).then(function(result){
                                                if (result.value) {
                                                }
                                                com_password.show=true;
                                            });
                                        }
                                        break;
                                }
                            }
                        });
                    }else{
                        return false;
                    }
                    // var jacked = humane.create({baseCls: 'humane-jackedup', addnCls: 'humane-jackedup-error', timeout: 2000})
                    // jacked.log("請補全必要輸入項");
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            }
        },
    })
</script>