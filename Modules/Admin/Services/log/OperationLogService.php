<?php
/**
 * @Name  日誌記錄服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/23 10:18
 */

namespace Modules\Admin\Services\log;


use Modules\Admin\Models\AuthOperationLog;
use Modules\Admin\Services\BaseAdminService;

class OperationLogService extends BaseAdminService
{
    /**
     * @name 添加日誌記錄
     * @description
     * @author 非比網絡
     * @date 2021/6/12 3:29
     * @param admin_id Int 管理員id
     * @param content String 操作描述
     * @return JSON
     **/
    public function store(int $admin_id = 0,string $content = '')
    {
        if($admin_id){
            $route_data = request()->route();
            $url = $route_data->uri;
            $data = [
                'content'=>$content,
                'url'=>$url,
                'method'=>request()->getMethod(),
                'ip'=>isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR']:'',
                'admin_id'=>$admin_id,
                'data'=>json_encode(request()->all()),
                'header'=>json_encode(request()->header())
            ];
            if($data['content'] == ''){
                $data['content'] = urldecode(request()->header('breadcrumb'));
            }
            $this->commonCreate(AuthOperationLog::query(),$data);
        }
    }

    /**
     * @name 管理員列表
     * @description
     * @author 非比網絡
     * @date 2021/6/12 3:03
     * @param  data Array 查詢相關參數
     * @param  data.page Int 頁碼
     * @param  data.limit Int 每頁顯示條數
     * @param  data.url String 操作路由
     * @param  data.method String 請求方式
     * @param  data.username String 管理員賬號
     * @param  data.created_at Array 創建時間
     * @return JSON
     **/
    public function index(array $data)
    {
        $model = AuthOperationLog::query();
        $model = $this->queryCondition($model,$data,'url');
        if (isset($data['admin_id']) && $data['admin_id'] > 0){
            $model = $model->where('admin_id',$data['admin_id']);
        }
        if(!empty($data['method'])){
            $model = $model->where('method', 'like', '%' . $data['method'] . '%');
        }
        $list = $model->with([
            'admin_one'=>function($query){
                $query->select('id','username');
            }
        ])
            ->whereHas('admin_one',function($query)use ($data){
                if(!empty($data['username'])){
                    $query->where('username', 'like', '%' . $data['username'] . '%');
                }
            })
            ->orderBy('id','desc')
            ->paginate($data['limit'])
            ->toArray();
        return $this->apiSuccess('',[
            'list'=>$list['data'],
            'total'=>$list['total']
        ]);
    }
    /**
     * @name 刪除
     * @description
     * @author 非比網絡
     * @date 2021/6/14 10:16
     * @param id Int id
     * @return JSON
     **/
    public function cDestroy(int $id){
        return $this->commonDestroy(AuthOperationLog::query(),[$id]);
    }
    /**
     * @name 批量刪除
     * @description
     * @author 非比網絡
     * @date 2021/6/14 10:16
     * @param idArr Array id數組
     * @return JSON
     **/
    public function cDestroyAll(array $idArr){
        return $this->commonDestroy(AuthOperationLog::query(),$idArr);
    }
}
