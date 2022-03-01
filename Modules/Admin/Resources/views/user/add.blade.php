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
                    {{--基本資料--}}
                    <el-form ref="form"  :model="model" label-width="150px">
                       <div>基本资料</div>
                        <el-form-item label="會員賬號" prop="phone">
                            <el-input v-model="model.phone" ></el-input>
                        </el-form-item>

                        <el-form-item label="真實姓名" prop="name">
                            <el-input v-model="model.name"></el-input>
                        </el-form-item>
                        <el-form-item label="性別" prop="sex">
                            <el-select v-model="model.sex" placeholder="请选择">
                                <el-option
                                        v-for="item in sex_options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="出生年月日" prop="birth">
                            <el-date-picker
                                    v-model="model.birth"
                                    type="date"
                                    placeholder="选择日期"  format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd">
                            </el-date-picker>
                        </el-form-item>

                        <div>等级资料</div>
                        <el-form-item label="會員等級" prop="grade_id">
                            <el-select v-model="model.grade_id" placeholder="请选择">
                                <el-option
                                        v-for="item in grade_options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="會員經驗值" prop="exp">
                            <el-input v-model="model.exp" :disabled="true"></el-input>
                        </el-form-item>
                        <el-form-item label="會員等級有效日期" prop="member_expiry_date">
                            <el-date-picker
                                    v-model="model.member_expiry_date"
                                    type="date"
                                    placeholder="选择日期"  format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd">
                            </el-date-picker>
                        </el-form-item>
                        <el-form-item label="推薦人的代碼" prop="inviter_code">
                            <el-input v-model="model.inviter_code"></el-input>
                        </el-form-item>
                        <div>狀態設定</div>
                        <el-form-item label="會員狀態" prop="status">
                            <el-switch v-model="model.status" active-color="#13ce66" inactive-color="#ff4949" :active-value=1  :inactive-value=0 active-text="啟用" inactive-text="停權"></el-switch>
                        </el-form-item>
                        <el-form-item label="團購主狀態" prop="is_group_lord">
                            <el-switch v-model="model.is_group_lord" active-color="#13ce66" inactive-color="#ff4949" :active-value=1  :inactive-value=0 active-text="啟用" inactive-text="停權"></el-switch>

                        </el-form-item>
                        <el-form-item label="發言狀態" prop="is_say">
                            <el-switch v-model="model.is_say" active-color="#13ce66" inactive-color="#ff4949" :active-value=1  :inactive-value=0 active-text="允許" inactive-text="禁止"></el-switch>
                        </el-form-item>

                        <el-form-item label="備註" prop="remark">
                            <el-input v-model="model.remark"></el-input>
                        </el-form-item>

                        <el-form-item>
                            <el-button @click="cancel">取消</el-button>
                            <el-button type="primary" @click="send_form('form')">保存</el-button>

                        </el-form-item>
                    </el-form>
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
            flag: 1,
            sex_options:[{value: 1, label: '男'},{value: 2, label: '女'},{value: 0, label: '未知'},],
            grade_options:[{value: 1, label: 'LV1 出入江湖'},{value: 2, label: 'LV2 出入江湖'},{value: 3, label: 'LV3 出入江湖'},],
            model: {
                name: "",
                up_time: "",
                down_time: "",
                status: 1,
                is_say: 1,
                grade_id: 1,
                exp: 0,
                sex: 0,
            },
            loading: false,
            clean_model: {},
            api_model_edit: "{{route('user_create')}}",
            ok_jump_url: "{{route('user_index')}}",
        },
        created: function () {
            check_login('{{route('login')}}');
        },
        mounted: function () {

        },
        methods: {
            send_form:function (form_name) {
                this.$refs[form_name].validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        var that = this;

                        request_ajax_json(this.api_model_edit, this.model, function (response) {
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
            cancel:function () {
                history.back();
            }

        },
        watch: {
            flag: function (val) {
                this.flag = val
            }
        }
    });
</script>
</body>

</html>