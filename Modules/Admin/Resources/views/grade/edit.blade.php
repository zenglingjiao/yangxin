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
                                    <a href="{{route('grade_index')}}">等級列表</a>
                                </li>
                                <li class="breadcrumb-item active">@{{model.id?"編輯":"新增"}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card radius-15">
                    <div class="card-body">
                        <el-form ref="form" :rules="form_rules" v-loading="loading" :model="model" label-width="150px"
                                 :label-position="form_is_top ? 'top' : 'right'">
                            <el-row>
                                <el-form-item label="等級" prop="id">
                                   <div>LV @{{model.id}}</div>
                                </el-form-item>

                                <el-form-item label="等級名稱" prop="name" style="width: 30%;">
                                    <el-input v-model="model.name"></el-input>
                                </el-form-item>
                                <el-form-item label="升等條件" prop="up_type">
                                    <template>
                                        <el-radio v-model="model.up_type" :label="1">註冊</el-radio>


                                            <el-radio v-model="model.up_type" :label="2" style="margin-right: 1px">經驗值</el-radio>
                                        <el-input v-model="model.up_exp" style="width: 20%;">
                                            <template slot="append">EXP</template></el-input>
                                        <el-radio v-model="model.up_type" :label="3" style="margin-right: 1px">完善會員資料或經驗值</el-radio>
                                        <el-input v-model="model.up_exp" style="width: 20%;">
                                           <template slot="append">EXP</template></el-input>

                                    </template>
                                </el-form-item>
                                <el-form-item label="會員資格" prop="expiry_type">
                                    <template>
                                        <el-radio v-model="model.expiry_type" :label="1">永久</el-radio>
                                        <el-radio v-model="model.expiry_type" :label="2" style="margin-right: 1px">註冊日或升等日後＋</el-radio>
                                        <el-input v-model="model.expiry_date" style="width: 15%"><template slot="append">天</template></el-input>
                                    </template>
                                </el-form-item>
                                <el-form-item label="續等條件" prop="keep">
                                    <el-input v-model="model.keep" style="width: 55%;">
                                        <template slot="prepend">經驗值達升級門檻</template>
                                        <template slot="append">%等級可以維持，若未達此條件，降級一等。</template>
                                    </el-input>
                                </el-form-item>

                                <el-form-item label="徽章" :rules="{required: true, message: '請上傳圖片', trigger: 'blur'}">
                                    <div v-if="model.img" style="width: 100px;float: left">
                                        <img :src="model.img" style="width: 100px; height: 100px">
                                    </div>
                                    <el-upload style="float: left"
                                            name="file"
                                            drag
                                            action="{{route('upload')}}"
                                            :on-success="(res,file)=>{return uploadSuccess(res)}"
                                            >
                                        <i class="el-icon-upload"></i>
                                        <div class="el-upload__text">拖曳圖片至此,或<em>點擊上傳</em></div>
                                        <div class="el-upload__tip" slot="tip" >檔案格式：JPG、JPEG、PNG，且5MB以下</div>
                                    </el-upload>

                                </el-form-item>
                                <el-form-item label="會員等級權利設定"></el-form-item>
                                <el-form-item label="經驗值" prop="exp_radio">
                                    <template>
                                        <el-radio v-model="model.exp_radio" :label="0">無</el-radio>
                                        <el-radio v-model="model.exp_radio" :label="1" >有</el-radio>
                                        <span @click="fold('0')">
                                            @{{fold_value[0]}}
                                        </span>
                                    </template>
                                </el-form-item>
                                <template v-if="fold_value[0] == '-'">
                                    <el-form-item label="註冊完成" prop="register" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.exp_data.register" label="0">無</el-radio>
                                            <el-radio v-model="model.exp_data.register" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.exp_data.register_data" style="width: 15%"><template slot="append">EXP</template></el-input>
                                        </template>
                                    </el-form-item>
                                    <el-form-item label="成功推薦親友" prop="recommend" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.exp_data.recommend" label="0">無</el-radio>
                                            <el-radio v-model="model.exp_data.recommend" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.exp_data.recommend_data" style="width: 15%"><template slot="append">EXP</template></el-input>
                                        </template>
                                    </el-form-item>
                                    <el-form-item label="完善會員資料" prop="perfect_information" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.exp_data.perfect_information" label="0">無</el-radio>
                                            <el-radio v-model="model.exp_data.perfect_information" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.exp_data.perfect_information_data" style="width: 15%"><template slot="append">EXP</template></el-input>
                                        </template>
                                    </el-form-item>
                                    <el-form-item label="消費訂單回饋" prop="order_buy" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.exp_data.order_buy" label="0">無</el-radio>
                                            <el-radio v-model="model.exp_data.order_buy" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.exp_data.order_buy_data" style="width: 15%"><template slot="append">%</template></el-input>
                                        </template>
                                    </el-form-item>
                                    <el-form-item label="訂單商品評價" prop="order_evaluate" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.exp_data.order_evaluate" label="0">無</el-radio>
                                            <el-radio v-model="model.exp_data.order_evaluate" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.exp_data.order_evaluate_data" style="width: 15%"><template slot="append">EXP</template></el-input>
                                        </template>
                                    </el-form-item>
                                    <el-form-item label="推薦的親友消費訂單回饋" prop="recommend_order_buy" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.exp_data.recommend_order_buy" label="0">無</el-radio>
                                            <el-radio v-model="model.exp_data.recommend_order_buy" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.exp_data.recommend_order_buy_data" style="width: 15%"><template slot="append">%</template></el-input>
                                        </template>
                                    </el-form-item>

                                </template>
                                <el-form-item label="點數回饋" prop="point_radio">
                                    <template>
                                        <el-radio v-model="model.point_radio" :label="0">無</el-radio>
                                        <el-radio v-model="model.point_radio" :label="1" >有</el-radio>
                                        <span @click="fold('1')">
                                            @{{fold_value[1]}}
                                        </span>
                                    </template>
                                </el-form-item>

                                <template v-if="fold_value[1] == '-'">
                                    <el-form-item label="首單贈禮" prop="order_first" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.point_data.order_first" label="0">無</el-radio>
                                            <el-radio v-model="model.point_data.order_first" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.point_data.order_first_data" style="width: 15%">
                                                <template slot="append">點</template>
                                            </el-input>
                                            <el-input v-model="model.point_data.order_first_date" style="width: 30%">
                                                <template slot="prepend">點數效期為贈送後</template><template slot="append">天</template></el-input>
                                        </template>
                                    </el-form-item>
                                    <el-form-item label="生日禮(點數)" prop="birthday" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.point_data.birthday" label="0">無</el-radio>
                                            <el-radio v-model="model.point_data.birthday" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.point_data.birthday_data" style="width: 15%">
                                                <template slot="append">點</template>
                                            </el-input>
                                            <el-input v-model="model.point_data.birthday_date" style="width: 30%">
                                                <template slot="prepend">點數效期為贈送後</template><template slot="append">天</template></el-input>
                                        </template>
                                    </el-form-item>
                                    <el-form-item label="消費訂單回饋" prop="order_buy" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.point_data.order_buy" label="0">無</el-radio>
                                            <el-radio v-model="model.point_data.order_buy" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.point_data.order_buy_data" style="width: 15%">
                                                <template slot="append">點</template>
                                            </el-input>
                                            <el-input v-model="model.point_data.order_buy_date" style="width: 30%">
                                                <template slot="prepend">點數效期為贈送後</template><template slot="append">天</template></el-input>
                                        </template>
                                    </el-form-item>
                                    <el-form-item label="註冊完成" prop="register" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.point_data.register" label="0">無</el-radio>
                                            <el-radio v-model="model.point_data.register" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.point_data.register_data" style="width: 15%">
                                                <template slot="append">點</template>
                                            </el-input>
                                            <el-input v-model="model.point_data.register_date" style="width: 30%">
                                                <template slot="prepend">點數效期為贈送後</template><template slot="append">天</template></el-input>
                                        </template>
                                    </el-form-item>
                                    <el-form-item label="成功推薦親友" prop="recommend" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.point_data.recommend" label="0">無</el-radio>
                                            <el-radio v-model="model.point_data.recommend" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.point_data.recommend_data" style="width: 15%">
                                                <template slot="append">點</template>
                                            </el-input>
                                            <el-input v-model="model.point_data.recommend_date" style="width: 30%">
                                                <template slot="prepend">點數效期為贈送後</template><template slot="append">天</template></el-input>
                                        </template>
                                    </el-form-item>
                                    <el-form-item label="完善會員資料" prop="perfect_information" label-width="200px">
                                        <template>
                                            <el-radio v-model="model.point_data.perfect_information" label="0">無</el-radio>
                                            <el-radio v-model="model.point_data.perfect_information" label="1" style="margin-right: 1px">有</el-radio>
                                            <el-input v-model="model.point_data.perfect_information_data" style="width: 15%">
                                                <template slot="append">點</template>
                                            </el-input>
                                            <el-input v-model="model.point_data.perfect_information_date" style="width: 30%">
                                                <template slot="prepend">點數效期為贈送後</template><template slot="append">天</template></el-input>
                                        </template>
                                    </el-form-item>

                                </template>
                                <el-form-item label="免運券" prop="freight_radio">
                                    <template>
                                        <el-radio v-model="model.freight_radio" :label="0">無</el-radio>
                                        <el-radio v-model="model.freight_radio" :label="1" >有</el-radio>
                                        <span @click="fold('2')">
                                            @{{fold_value[2]}}
                                        </span>
                                    </template>
                                </el-form-item>
                                <template v-if="fold_value[2] == '-'">
                                    {{--免运费--}}
                                </template>
                                <el-form-item label="折價券" prop="discount_radio">
                                    <template>
                                        <el-radio v-model="model.discount_radio" :label="0">無</el-radio>
                                        <el-radio v-model="model.discount_radio" :label="1" >有</el-radio>
                                        <span @click="fold('3')">
                                            @{{fold_value[3]}}
                                        </span>
                                    </template>
                                </el-form-item>
                                <template v-if="fold_value[3] == '-'">
                                    {{--折價券--}}
                                </template>

                            </el-row>

                            <el-form-item style="float: right;">
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
        data: function () {
            return {
                fold_bnt_1 : "+",
                fold_value:["+","+","+","+"],
                model: {
                    id: "",
                    name: "",
                    info:[

                        ],
                    up_type: "",
                    up_exp: "",
                    expiry_type: "",
                    expiry_date: "",
                    keep:0
                },
                form_rules: {

                    name: [
                        {required: true, message: '請輸入名稱', trigger: 'blur'}
                    ],
                },
                clean_model: {},
                loading: false,
                form_is_top: false,
                api_model_edit: "{{route('grade_update')}}",
                ok_jump_url: "{{route('grade_index')}}",
            }
        },
        created: function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($model) ? $model : null)))}}'.replace(/\+/g, " ")));
            if (json_model) {
                this.model = json_model;
            }
            console.log(this.model)

        },
        mounted: function () {
            this.get_device_size();
            window.addEventListener('resize', () => {
                this.get_device_size();
            });

        },
        methods: {
            send_form: function (form_name) {
                this.$refs[form_name].validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        var that = this;

                        var url = this.api_model_edit;
                        if (this.model.id > 0) {

                        } else {
                            url = this.api_model_add;
                        }
                       // console.log(that.model);
                       // return;

                        request_ajax_json(url, this.model, function (response) {
                            console.log(response)
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
                        }, function () {
                            that.loading = false;
                        })
                    } else {
                        return false;
                    }
                });
            },
            get_device_size: function () {
                let winW = window.innerWidth;
                if (winW < 500) {
                    this.form_is_top = true
                } else {
                    this.form_is_top = false
                }
            },
            cancel: function () {
                history.back();
            },
            uploadSuccess:function (res) {
                this.model.img = res.data.path;
            },
            fold:function (index) {

                if (this.fold_value[index] == "+"){
                    var s= "-";
                } else{
                    var s= "+";
                }
                this.$set(this.fold_value,index,s)
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
            },
            time_select:function (val) {
                this.model.up_time = val[0]
                this.model.down_time = val[1]
            }
        }
    });
</script>
</body>

</html>