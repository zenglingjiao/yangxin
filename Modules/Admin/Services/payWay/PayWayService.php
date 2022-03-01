<?php

/**
 * @Name 管理員服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\payWay;



use Modules\Admin\Models\Invoice;
use Modules\Admin\Models\Logistics;
use Modules\Admin\Models\MenuFooter;
use Modules\Admin\Models\PayPoundage;
use Modules\Admin\Models\PayWay;
use Modules\Admin\Services\BaseAdminService;


class PayWayService extends BaseAdminService
{
    /**
     * @name 支付方式列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function list(array $data)
    {
        $model = PayWay::query();

        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();

        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }

    /**
     * @name 調整支付方式狀態
     * @description
     * @param data Array 調整數據
     * @param id Int id
     * @param data.status Int 狀態（0或1）
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:06
     */
    public function status(int $id, array $data)
    {
        return $this->commonStatusUpdate(PayWay::query(), $id, $data);
    }

    /**
     * @name 手續費列表
     * @description
     * @param $id int 支付方式ID
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function poundageList(int $id,array $data)
    {
        $model = PayPoundage::query();
        $model->where('pay_id',$id);

        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();

        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }

    /**
     * @name 手續費編輯/添加
     * @description
     * @param data Array 修改數據
     * @param daya.pay_id Int 支付方式ID
     * @param daya.name String 名稱
     * @param daya.nper String 期數
     * @param daya.rate String 匯率
     * @param daya.note Int 說明
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function poundageUpdate(int $id, array $data)
    {
        if ($id > 0){
            return $this->commonUpdate(PayPoundage::query(), $id, $data);
        }
        $payWay = PayWay::find($data['pay_id']);
        if (empty($payWay)){
            return $this->apiError("支付方式不存在");
        }
        return $this->commonCreate(PayPoundage::query(),$data);
    }

    /**
     * @Name:手續費刪除
     * @Author: chenji
     * @Time: 2021/12/18/018 16:23
     * @param array $ids
     * @return \Modules\Common\Services\JSON
     */
    public function poundageDel(array $ids)
    {
        return $this->commonDestroy(PayPoundage::query(), $ids);
    }


}
