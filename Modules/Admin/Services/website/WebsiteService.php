<?php

/**
 * @Name 管理員服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\website;


use Modules\Admin\Models\AuthAdmin;
use Modules\Admin\Models\BannerBelow;
use Modules\Admin\Models\BannerBig;
use Modules\Admin\Models\BannerMiddle;
use Modules\Admin\Models\BannerMiddleCarousel;
use Modules\Admin\Models\BannerSales;
use Modules\Admin\Models\KeywordHint;
use Modules\Admin\Models\KeywordHistory;
use Modules\Admin\Models\Website;
use Modules\Admin\Services\BaseAdminService;
use Modules\Admin\Services\group\GroupService;
use Tymon\JWTAuth\Facades\JWTAuth;

class WebsiteService extends BaseAdminService
{
    /**
     * @Name: 獲取配置
     * @Author: chenji
     * @Time: 2021/12/18/018 16:24
     * @param string $type  類型  ['basis'=>'網站設定','login'=>'登入設定','sms'=>'簡訊設定'，'email'=>'發信設定','member'=>'用戶協議設定','privacy'=>'隱私協議設定']
     * @return mixed|null
     */
    public function getByType(string $type)
    {
        $model = Website::query();
        $res = $model->where('type', $type)->first();

        if (!$res) return null;
        $data = $res->data;
        $data['type'] = $res['type'];
        return  $data;
    }



    /**
     * @name 編輯
     * @description
     * @param data Array 修改數據
     * @param daya.type Int 類型
     * @param daya.data String 整個請求
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function update( array $data)
    {
        $type = $data['type'];
        if (!in_array($type,['basis','login','sms','email','member','privacy'])){
            return $this->apiError();
        }
        unset($data['type']);
        if (in_array($type,['member','privacy'])){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $user = JWTAuth::parseToken()->touser();
            $data['author'] = $user->username;
        }
        $data = ['data'=>json_encode($data)];
        $res = Website::where('type',$type)->first();
        if ($res){

            return $this->commonUpdate(Website::query(), $res->id, $data);
        }else{
            $data['type'] = $type;
            return $this->commonCreate(Website::query(),$data);
        }


    }




}
