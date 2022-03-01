<?php
/**
 * Created by PhpStorm.
 * User: Feibi
 * Date: 2021/12/18/018
 * Time: 16:44
 */

namespace Modules\Admin\Services\brand;


use Modules\Admin\Models\Brand;
use Modules\Admin\Services\BaseAdminService;
class BrandService extends BaseAdminService
{
    /**
     * @Name: 菜单列表
     * @Author: chenji
     * @Time: 2021/12/20/020 14:05
     * @return \Modules\Common\Services\JSON
     */
    public function list(array $data)
    {
        $model = Brand::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);

        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('zh_name', 'like', '%' . $name . '%')->orWhere('en_name', 'like', '%' . $name . '%');
            });

        }

        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();

        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }

    public function select(){

        $model = Brand::query();

        $list = $model->orderBy('id', 'desc')->get()->toArray();

        return $this->apiSuccess('', $list);
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
            return $this->commonUpdate(Brand::query(),$id,$data);
        }

        return $this->commonCreate(Brand::query(),$data);

    }

    public function del(array $ids){

        return $this->commonDestroy(Brand::query(),$ids);
    }

    public function search(string $query){
        $list = Brand::where('zh_name','like',"%".$query."%")
            ->orWhere('en_name','like',"%".$query."%")->get()->toArray();
        return $this->apiSuccess('',$list);
    }


}