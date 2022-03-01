<?php

/**
 * @Name 管理員服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\keyword;


use Modules\Admin\Models\AuthAdmin;
use Modules\Admin\Models\BannerBelow;
use Modules\Admin\Models\BannerBig;
use Modules\Admin\Models\BannerMiddle;
use Modules\Admin\Models\BannerMiddleCarousel;
use Modules\Admin\Models\BannerSales;
use Modules\Admin\Models\KeywordHint;
use Modules\Admin\Models\KeywordHistory;
use Modules\Admin\Models\KeywordHot;
use Modules\Admin\Services\BaseAdminService;
use Modules\Admin\Services\group\GroupService;

class KeywordService extends BaseAdminService
{
    /**
     * @name 搜尋歷史列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.keyword String 關鍵詞
     * @param data.start_time Int 上架时间
     * @param data.down_time int 下架时间
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function historyList(array $data)
    {
        $model = KeywordHistory::query();

        $keyword = mb_strlen(trim(isset($data['keyword']) ?: "")) == 0 ? "" : trim($data['keyword']);
        $num = mb_strlen(trim(isset($data['num']) ?: "")) == 0 ? "" : trim($data['num']);
        $start_time = mb_strlen(trim(isset($data['start_time']) ?: "")) == 0 ? "" : trim($data['start_time']);
        $end_time = mb_strlen(trim(isset($data['end_time']) ?: "")) == 0 ? "" : trim($data['end_time']);

        if ($keyword != "") {
            $model = $model->where(function ($query) use ($keyword) {
                $query->where('keyword', 'like', '%' . $keyword . '%');
            });

        }
        if ($num != "") {
            $model = $model->where('num', '>=',$num);
        }

        if ($start_time != ""){
            $model = $model->where('updated_at', '>=',$start_time);
        }

        if ($end_time != ""){
            $model = $model->where('updated_at', '<=',$end_time);
        }

        $list = $model->orderBy('num', 'desc')
            ->paginate($data['limit'])
            ->toArray();

        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }

    /**
     * @name 搜尋提示詞列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.keyword String 提示詞
     * @param data.weight Int 優先級
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function hintList(array $data)
    {
        $model = KeywordHint::query();

        $keyword = mb_strlen(trim(isset($data['keyword']) ?: "")) == 0 ? "" : trim($data['keyword']);
        $weight = mb_strlen(trim(isset($data['weight']) ?: "")) == 0 ? "" : trim($data['weight']);

        if ($keyword != "") {
            $model = $model->where(function ($query) use ($keyword) {
                $query->where('keyword', 'like', '%' . $keyword . '%');
            });

        }
        if ($weight != "") {
            $model = $model->where('weight', $weight);
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
     * @name 添加搜尋提示詞
     * @description
     * @param data Array 添加數據
     * @param data.keyword String 提示詞
     * @param data.code String 代碼
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function hintAdd(array $data)
    {
        return $this->commonCreate(KeywordHint::query(), $data);
    }


    /**
     * @name 修改提交
     * @description
     * @param id Int id
     * @param data Array 修改數據
     * @param data.keyword String 提示詞
     * @param data.code String 代碼
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function hintUpdate(int $id, array $data)
    {
            return $this->commonUpdate(KeywordHint::query(), $id, $data);

    }


    /**
     * @Notes:
     * @Name 刪除
     * @Interface del
     * @param array $ids
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/08   1:23
     */
    public function hintDel(array $ids)
    {

        return $this->commonDestroy(KeywordHint::query(), $ids);
    }

    public function hot(){
        return KeywordHot::where('id','>',0)->first();
    }

    /**
     * @name 修改提交
     * @description
     * @param id Int id
     * @param data Array 修改數據
     * @param data.keyword String 提示詞
     * @param data.code String 代碼
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function hotUpdate(int $id=0, array $data)
    {
        if ($id > 0){
            return $this->commonUpdate(KeywordHot::query(), $id, $data);
        }

        return $this->commonCreate(KeywordHot::query(),$data);
    }


}
