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
                                    <a href="{{route('classify_index')}}">分類管理</a>
                                </li>
                                <li class="breadcrumb-item active">新增</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card radius-15">
                    <div class="card-body">
                        <el-form ref="form" :rules="form_rules" v-loading="loading" :model="model" label-width="120px"
                                 :label-position="form_is_top ? 'top' : 'right'">
                            <el-row>

                                <el-form-item label="名稱" prop="name">
                                    <el-input v-model="model.name"></el-input>
                                </el-form-item>
                                <el-form-item v-if="model.lv == 1" label="圖片" :rules="{required: true, message: '請上傳圖片', trigger: 'blur'}">
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

                                <el-form-item label="排序" prop="sort">
                                    <el-input v-model="model.sort"></el-input>
                                </el-form-item>

                                <el-form-item label="狀態" prop="status">
                                    <el-switch v-model="model.status" active-color="#13ce66" inactive-color="#ff4949"
                                               :active-value=1 :inactive-value=0 active-text="啓用"
                                               inactive-text="關閉"></el-switch>
                                </el-form-item>
                                <el-form-item label="已選擇品牌">
                                <el-tag @close="close1(index)"
                                        v-for="tag,index in model.brands"
                                        :key="tag.zh_name"
                                        closable>
                                    @{{tag.zh_name}}
                                </el-tag>
                                </el-form-item>
                                <el-form-item label="快速搜尋品牌">
                                <el-select @change="selectChanged" v-model="model.value"
                                        filterable
                                        remote
                                        reserve-keyword
                                        placeholder="请输入关键词"
                                        :remote-method="remoteMethod"
                                        :loading="loading">
                                    <el-option
                                            v-for="item in options"
                                            :key="item.id"
                                            :label="item.zh_name"
                                            :value="item.id">
                                    </el-option>
                                </el-select>
                                </el-form-item>

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
        data: function () {
            return {
                options:[],
                tags: [
                    { name: '标签一', type: '' },
                    { name: '标签二', type: 'success' },
                    { name: '标签三', type: 'info' },
                    { name: '标签四', type: 'warning' },
                    { name: '标签五', type: 'danger' }
                ],
                model: {
                  value:"",
                    id: "",
                    name: "",
                    img: "",
                    pid:"{{$parent?$parent->id:0}}",
                    lv:"{{$parent?$parent->lv:0}}",
                    brands:[],
                    sort:"1",
                    status: 1,
                },
                form_rules: {

                    name: [
                        {required: true, message: '請輸入名稱', trigger: 'blur'}
                    ],
                    up_time: [
                        {required: true, message: '請選擇日期', trigger: 'blur'}
                    ],
                    status: [
                        {required: true, message: '請選擇餐廳狀態', trigger: 'blur'}
                    ],
                },
                clean_model: {},
                loading: false,
                form_is_top: false,
                api_model_create: "{{route('classify_create')}}",
                ok_jump_url: "{{route('classify_index')}}/{{$parent?$parent->id:0}}",
            }
        },
        created: function () {
            this.clean_model = deep_copy(this.model);
            var json_model = JSON.parse(decodeURIComponent('{{urlencode(json_encode((isset($parent) ? $parent : null)))}}'.replace(/\+/g, " ")));

            if (json_model && json_model.brands) {
                this.model.brands = json_model.brands;
            }

        },
        mounted: function () {
            this.get_device_size();
            window.addEventListener('resize', () => {
                this.get_device_size();
            });

        },
        methods: {
            close1:function(index){
                this.model.brands.splice(index)
            },
            selectChanged:function(item){
                console.log(item)
                for (var i=0;i<this.options.length;i++){
                    if (this.options[i].id == item){
                        var f = false;
                       // console.log(this.model.brands)
                        for (var j=0;j<this.model.brands.length;j++){
                          //  console.log(this.model.brands[j].id);
                            if (this.model.brands[j].id == item){
                                f = true;
                            }
                        }

                        if (f == false){
                            this.model.brands.push(this.options[i]);
                        }

                    }
                }
               // this.model.brands.push(this.options[item]);
            },
            remoteMethod:function(query){
                if (query != ""){
                   var data = {query:query}
                    var url = "{{route('brand_search')}}";
                   var that = this;
                    request_ajax_json(url, data, function (response) {
                        that.loading = false;
                        if (response.status) {
                            switch (response.status) {
                                case 20000:

                                   that.options  = response.data;
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
                }
            },
            send_form: function (form_name) {
                this.$refs[form_name].validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        var that = this;
                       // console.log(this.model)
                       // return;
                        request_ajax_json(this.api_model_create, this.model, function (response) {
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
            uploadSuccess:function (res,index) {
                this.model.img = res.data.path;
            },
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