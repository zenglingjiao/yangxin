<?php
/**
 * Created by PhpStorm.
 * User: Feibi
 * Date: 2021/12/22/022
 * Time: 16:10
 */

namespace Modules\Admin\Services\user;



use Modules\Admin\Models\AnnexeHot;
use Modules\Admin\Models\AuthUser;
use Modules\Admin\Services\BaseAdminService;
use Cache;

class UserService extends BaseAdminService
{

    /**
     * @name 大banner列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.name String 名称
     * @param data.up_time Int 上架时间
     * @param data.down_time int 下架时间
     * @param data.status Int 狀態:0=关闭,1=啟用
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function list(array $data)
    {
        $model = AuthUser::query();

        $name = $this->getValidParameter($data,'name');
        $status = $this->getValidParameter($data,'status');;
        $start_time = $this->getValidParameter($data,'start_time');;
        $end_time = $this->getValidParameter($data,'end_time');;
        $is_yangxin = $this->getValidParameter($data,'is_yangxin');;
        $register_way = $this->getValidParameter($data,'register_way');;
        $is_group_lord = $this->getValidParameter($data,'is_group_lord');
        $grade_id = $this->getValidParameter($data,'grade_id');
        $is_say = $this->getValidParameter($data,'is_say');;
        $is_epaper = $this->getValidParameter($data,'is_epaper');;
        $time_type = $this->getValidParameter($data,'time_type');;
        $phone = $this->getValidParameter($data,'phone');;

        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });
        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }
        if ($is_yangxin != "") {
            $model = $model->where('is_yangxin', $is_yangxin);
        }
        if ($register_way != "") {
            $model = $model->where('register_way', $register_way);
        }
        if ($is_group_lord != "") {
            $model = $model->where('is_group_lord', $is_group_lord);
        }
        if ($grade_id != "") {
            $model = $model->where('grade_id', $grade_id);
        }
        if ($is_say != "") {
            $model = $model->where('is_say', $is_say);
        }
        if ($is_epaper != "") {
            $model = $model->where('is_epaper', $is_epaper);
        }
        if ($phone != "") {
            $model = $model->where('phone', $phone);
        }



        if ($time_type != "" && ($start_time !="" || $end_time != "")) {
            switch ($time_type){
                case 1: //出生年月日
                    $field = "birth";
                    break;
                case 2: //最後下單時間
                    $field = "last_buy_time";
                    break;
                case 3: //註冊時間
                    $field = "created_at";
                    break;
            }
            if ($start_time !=""){
                $model = $model->where($field, '>=', $start_time);
            }
            if ($end_time !=""){
                $model = $model->where($field, '<=', $end_time);
            }

        }



        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit']);
           // ->toArray();
        foreach ($list as $v){
            $v->uid = $v->uid;
            $v->register_way_name = $v->register_way_name;
        }
        $list = $list->toArray();

        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }



    /**
     * @name 修改頁面
     * @description
     * @param id Int id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function edit(int $id)
    {
        $user = AuthUser::find($id);
        if (!empty($user)){
            $user->uid=$user->uid;
            $user->register_way=AuthUser::REGISTER_WAY_NAME[$user->register_way];
        }
        return $user;
    }

    /**
     * @name 修改提交
     * @description
     * @param id int ID
     * @param data Array 修改數據
     * @param data.name String 名稱
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function update(int $id, array $data)
    {
        $userInfo = AuthUser::find($id);
        if (empty($userInfo)){
            return $this->apiError('用戶不存在');
        }
        if (isset($data['inviter_code']) && !empty($data['inviter_code']) && $data['inviter_code'] != $userInfo->inviter_code){
            $inviterInfo = AuthUser::where('recommend_code',$data['inviter_code'])->first();
            if (empty($inviterInfo)){
                return $this->apiError('推薦人不存在');
            }
            $data['inviter_id'] = $inviterInfo->id;
        }

        return $this->commonUpdate(AuthUser::query(),$id,$data);

    }

    public function create( array $data)
    {
       // dd($data);
            $data['recommend_code'] =AuthUser::createRecommendCode();

        if (isset($data['inviter_code']) && !empty($data['inviter_code'])){
            $inviterInfo = AuthUser::where('recommend_code',$data['inviter_code'])->first();
            if (empty($inviterInfo)){
                return $this->apiError('推薦人不存在');
            }
            $data['inviter_id'] = $inviterInfo->id;
        }

        return $this->commonCreate(AuthUser::query(),$data);

    }



   public function getRegisterWayList(){
        return AuthUser::REGISTER_WAY_NAME;
   }

    public function getGradeIdList(){
        return [
            ['id'=>1,'name'=>"LV1 出入江湖"],
            ['id'=>2,'name'=>"LV2 武林新秀"],
            ['id'=>3,'name'=>"LV3 鳴動一方"],
        ];
    }

    public function updatePhone(int $id,array $data){

        $config = config('admin.user_update_phone_send');
        $key = $config['key'].$id;
        Cache::put($key,$data['code'],300);

        if (!Cache::has($key) || Cache::get($key) != $data['code']){
            return $this->apiError('驗證碼錯誤');
        }

       $res =  $this->commonUpdate(AuthUser::query(),$id,['phone'=>$data['phone']]);
        if ($res->getData()->status == 20000) {
            Cache::forget($key);
            return $res;
        }

        return $this->apiError('修改失敗');

    }

    public function updateEmail(int $id,array $data){

        $config = config('admin.user_update_email_send');
        $key = $config['key'].$id;
        Cache::put($key,$data['code'],300);

        if (!Cache::has($key) || Cache::get($key) != $data['code']){
            return $this->apiError('驗證碼錯誤');
        }

        $res =  $this->commonUpdate(AuthUser::query(),$id,['email'=>$data['email']]);
        if ($res->getData()->status == 20000) {
            Cache::forget($key);
            return $res;
        }

        return $this->apiError('修改失敗');

    }

    public function updatePassword(int $id,array $data){

        return $this->commonUpdate(AuthUser::query(),$id,['password'=>bcrypt($data['password'])]);

    }

}