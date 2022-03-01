<?php
/**
 * Created by PhpStorm.
 * User: Feibi
 * Date: 2021/12/18/018
 * Time: 16:44
 */

namespace Modules\Admin\Services\brand;


use Modules\Admin\Models\BrandRecommend;
use Modules\Admin\Models\Navi;
use Modules\Admin\Services\BaseAdminService;
class BrandRecommendService extends BaseAdminService
{
    /**
     * @Name: 菜单列表
     * @Author: chenji
     * @Time: 2021/12/20/020 14:05
     * @return \Modules\Common\Services\JSON
     */
    public function list(array $data){

        $model = BrandRecommend::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);

        $model = $model->whereHas('brandInfo',function($query)use($name){
            if ($name !=""){
                return $query->where('zh_name','like',"%".$name."%")->orWhere('en_name','like',"%".$name."%");
            }
        })->with(['brandInfo']);

        if ($status != ""){
            $model = $model->where('status',$status);
        }

        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])->toArray();


        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);

    }



    /**
     * @Name:  更新/添加菜单
     * @Author: chenji
     * @Time: 2021/12/20/020 14:06
     * @param int $id
     * @param array $data
     * @return \Modules\Common\Services\JSON
     * @throws \Modules\Common\Exceptions\AdminException
     */
    public function update(int $id,array $data){
        if ($id > 0){
            return $this->commonUpdate(BrandRecommend::query(),$id,$data);
        }

        return $this->commonCreate(BrandRecommend::query(),$data);

    }

    public function del(array $ids){

        return $this->commonDestroy(BrandRecommend::query(),$ids);
    }


}