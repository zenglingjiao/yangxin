<?php
/**
 * Created by PhpStorm.
 * User: Feibi
 * Date: 2021/12/18/018
 * Time: 16:44
 */

namespace Modules\Admin\Services\advertisement;


use Modules\Admin\Models\Advertisement;
use Modules\Admin\Models\Brand;
use Modules\Admin\Services\BaseAdminService;
use Monolog\Handler\IFTTTHandler;
use phpDocumentor\Reflection\DocBlock;

class AdvertisementService extends BaseAdminService
{
    /**
     * @Name: 菜单列表
     * @Author: chenji
     * @Time: 2021/12/20/020 14:05
     * @return \Modules\Common\Services\JSON
     */
    public function list(array $data)
    {
        if(!in_array($data['type'],['up','down'])){
            return $this->apiError('類型不存在');
        }
        $model = Advertisement::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);
        $up_time = mb_strlen(trim(isset($data['up_time']) ?: "")) == 0 ? "" : trim($data['up_time']);
        $down_time = mb_strlen(trim(isset($data['down_time']) ?: "")) == 0 ? "" : trim($data['down_time']);

        $model = $model->where('type',$data['type']);
        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });

        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }

        if ($up_time != "") {
            $model = $model->where('up_time', '>=', $up_time);
        }

        if ($down_time != "") {
            $model = $model->where('down_time', '<=', $down_time);
        }


        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();

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
            return $this->commonUpdate(Advertisement::query(),$id,$data);
        }

        return $this->commonCreate(Advertisement::query(),$data);

    }

    public function del(array $ids){

        return $this->commonDestroy(Advertisement::query(),$ids);
    }


}