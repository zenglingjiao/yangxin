<?php
/**
 * @Name
 * @Description
 * @Auther 非比網絡
 * @Date 2021/11/29 18:05
 */

namespace Modules\Common\Services;

use Modules\Common\Exceptions\AdminException;
use Modules\Common\Exceptions\CodeData;
use Modules\Common\Exceptions\StatusData;

class BaseService
{
    public function __construct()
    {
    }

    public function getValidParameter(array $data,string $key){
        return mb_strlen(trim(isset($data[$key]) ?: "")) == 0 ? "" : trim($data[$key]);
    }

    /**
     * @name 查詢條件
     * @description
     * @param model Model 模型
     * @param params Array 查詢參數
     * @param key String 模糊查詢參數
     * @return Object
     **@author 非比網絡
     * @date 2021/6/12 2:59
     * @method  GET
     */
    function queryCondition(object $model, array $params, string $key = "username"): Object
    {
        if (!empty($params['created_at'])) {
            $model = $model->whereBetween('created_at', $params['created_at']);
        }
        if (!empty($params['updated_at'])) {
            $model = $model->whereBetween('updated_at', $params['updated_at']);
        }
        if (!empty($params[$key])) {
            $model = $model->where($key, 'like', '%' . $params[$key] . '%');
        }
        if (isset($params['status']) && $params['status'] != '') {
            $model = $model->where('status', $params['status']);
        }
        return $model;
    }

    /**
     * @name  成功返回
     * @description  用於所有的接口返回
     * @param status Int 自定義狀態碼
     * @param message String 提示信息
     * @param data Array 返回信息
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 12:32
     */
    public function apiSuccess(string $message = '', array $data = array(), int $status = StatusData::Ok)
    {
        if ($message == '') {
            $message = __('exceptions.Ok');
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], CodeData::OK);
    }

    /**
     * @name 失敗返回
     * @description 用於所有的接口返回
     * @param status Int 自定義狀態碼
     * @param message String 提示信息
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 12:36
     */
    public function apiError(string $message = '', int $status = StatusData::BAD_REQUEST)
    {
        if($message==''){
            $message = __('exceptions.API_ERROR_EXCEPTION');
        }
        throw new AdminException([
            'status' => $status,
            'message' => $message
        ]);
    }

    /**
     * @name  成功返回
     * @description  用於所有的接口返回
     * @param status Int 自定義狀態碼
     * @param message String 提示信息
     * @param data Array 返回信息
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 12:32
     */
    public function webSuccess(string $message = '', array $data = array(), int $status = StatusData::Ok)
    {
        if ($message == '') {
            $message = __('exceptions.Ok');
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], CodeData::OK);
    }

    /**
     * @name 失敗返回
     * @description 用於所有的接口返回
     * @param status Int 自定義狀態碼
     * @param message String 提示信息
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 12:36
     */
    public function webError(string $message = '', int $status = StatusData::BAD_REQUEST)
    {
        if($message==''){
            $message = __('exceptions.API_ERROR_EXCEPTION');
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => null
        ], CodeData::OK);
    }

    /**
     * @name 添加公共方法
     * @description
     * @param model Model  當前模型
     * @param data array 添加數據
     * @param successMessage string 成功返回數據
     * @param errorMessage string 失敗返回數據
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 12:54
     */
    public function commonCreate($model, array $data = [], string $successMessage = '', string $errorMessage = '')
    {
        if($successMessage==''){
            $successMessage = __('exceptions.ADD_API_SUCCESS');
        }
        if($errorMessage==''){
            $errorMessage = __('exceptions.ADD_API_ERROR');
        }
        $data['created_at'] = date('Y-m-d H:i:s');

        if ($id = $model->insertGetId($data)) {
            return $this->webSuccess($successMessage, ["insert_id" => $id]);
        }
        $this->webError($errorMessage);
    }

    /**
     * @name 編輯公共方法
     * @description
     * @param model Model  當前模型
     * @param id   Int  修改id
     * @param data array 添加數據
     * @param successMessage string 成功返回數據
     * @param errorMessage string 失敗返回數據
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 13:17
     */
    public function commonUpdate($model, $id, array $data = [], string $successMessage = '', string $errorMessage = '')
    {
        if($successMessage==''){
            $successMessage = __('exceptions.UPDATE_API_SUCCESS');
        }
        if($errorMessage==''){
            $errorMessage = __('exceptions.UPDATE_API_ERROR');
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        if ($model->where('id', $id)->update($data)) {
            return $this->webSuccess($successMessage);
        }
        $this->webError($errorMessage);
    }

    /**
     * @name 調整公共方法
     * @description
     * @param model Model  當前模型
     * @param id   Int  修改id
     * @param data array 添加數據
     * @param successMessage string 成功返回數據
     * @param errorMessage string 失敗返回數據
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 13:31
     */
    public function commonStatusUpdate($model, $id, array $data = [], string $successMessage = '', string $errorMessage = '')
    {
        if($successMessage==''){
            $successMessage = __('exceptions.STATUS_API_SUCCESS');
        }
        if($errorMessage==''){
            $errorMessage = __('exceptions.STATUS_API_ERROR');
        }
        if ($model->where('id', $id)->update($data)) {
            return $this->apiSuccess($successMessage);
        }
        $this->apiError($errorMessage);
    }

    /**
     * @name 排序公共方法
     * @description
     * @param model Model  當前模型
     * @param id   Int  修改id
     * @param data array 添加數據
     * @param successMessage string 成功返回數據
     * @param errorMessage string 失敗返回數據
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 13:31
     */
    public function commonSortsUpdate($model, $id, array $data = [], string $successMessage = '', string $errorMessage = '')
    {
        if($successMessage==''){
            $successMessage = __('exceptions.STATUS_API_SUCCESS');
        }
        if($errorMessage==''){
            $errorMessage = __('exceptions.STATUS_API_ERROR');
        }
        if ($model->where('id', $id)->update($data) !== false) {
            return $this->apiSuccess($successMessage);
        }
        $this->apiError($errorMessage);
    }

    /**
     * @name 真刪除公共方法
     * @description
     * @param model Model  當前模型
     * @param ArrId Array  刪除id
     * @param successMessage string 成功返回數據
     * @param errorMessage string 失敗返回數據
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 13:33
     */
    public function commonDestroy($model, array $ArrId, string $successMessage = '', string $errorMessage = '')
    {
        if($successMessage==''){
            $successMessage = __('exceptions.DELETE_API_SUCCESS');
        }
        if($errorMessage==''){
            $errorMessage = __('exceptions.DELETE_API_ERROR');
        }
        if ($model->whereIn('id', $ArrId)->delete()) {
            return $this->webSuccess($successMessage);
        }
        $this->webError($errorMessage);
    }

    /**
     * @name 假刪除公共方法
     * @description
     * @param model Model  當前模型
     * @param idArr Array  刪除id
     * @param successMessage string 成功返回數據
     * @param errorMessage string 失敗返回數據
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 13:35
     */
    public function commonIsDelete($model, array $idArr, string $successMessage = '', string $errorMessage = '')
    {
        if($successMessage==''){
            $successMessage = __('exceptions.DELETE_API_SUCCESS');
        }
        if($errorMessage==''){
            $errorMessage = __('exceptions.DELETE_API_ERROR');
        }
        if ($model->whereIn('id', $idArr)->update(['is_delete' => 1, 'deleted_at' => date('Y-m-d H:i:s')])) {
            return $this->apiSuccess($successMessage);
        }
        $this->apiError($errorMessage);
    }

    /**
     * @name 假刪除恢復公共方法
     * @description
     * @param model Model  當前模型
     * @param idArr Array  刪除id
     * @param successMessage string 成功返回數據
     * @param errorMessage string 失敗返回數據
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 13:35
     */
    public function commonRecycleIsDelete($model, array $idArr, string $successMessage = '', string $errorMessage = '')
    {
        if($successMessage==''){
            $successMessage = __('exceptions.DELETE_RECYCLE_API_SUCCESS');
        }
        if($errorMessage==''){
            $errorMessage = __('exceptions.DELETE_RECYCLE_API_ERROR');
        }
        if ($model->whereIn('id', $idArr)->update(['is_delete' => 0])) {
            return $this->apiSuccess($successMessage);
        }
        $this->apiError($errorMessage);
    }

    /**
     * @name 獲取當前域名
     * @description
     * @return String
     **@author 非比網絡
     * @date 2021/6/12 0:25
     */
    public function getHttp(): String
    {
        $http = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        return $http . $_SERVER['HTTP_HOST'];
    }

    /**
     * @name 將編輯器的content的圖片轉換為相對路徑
     * @description
     * @param content String 內容
     * @return string
     **@author 非比網絡
     * @date 2021/6/12 0:28
     */
    public function getRemvePicUrl(string $content = ''): String
    {
        $con = $this->getHttp();
        if ($content) {
            //提取圖片路徑的src的正則表達式 並把結果存入$matches中
            preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/", $content, $matches);
            $img = "";
            if (!empty($matches)) {
                //註意，上面的正則表達式說明src的值是放在數組的第三個中
                $img = $matches[1];
            } else {
                $img = "";
            }
            if (!empty($img)) {
                $patterns = array();
                $replacements = array();
                //$default = config('filesystems.disks.qiniu.domains.default');
                foreach ($img as $imgItem) {
                    //if (strpos($imgItem, $default) !== false) {
                    //    $final_imgUrl = $imgItem;
                    // } else {
                    $final_imgUrl = str_replace($con, "", $imgItem);
                    //}
                    $replacements[] = $final_imgUrl;
                    $img_new = "/" . preg_replace("/\//i", "\/", $imgItem) . "/";
                    $patterns[] = $img_new;
                }
                //讓數組按照key來排序
                ksort($patterns);
                ksort($replacements);
                //替換內容
                $content = preg_replace($patterns, $replacements, $content);
            }
        }
        return $content;
    }

    /**
     * @name 將編輯器的content的圖片轉換為絕對路徑
     * @description
     * @param content string 內容
     * @return String
     **@author 非比網絡
     * @date 2021/6/12 0:33
     */
    public function getReplacePicUrl(string $content = ''): String
    {
        $con = $this->getHttp();
        if ($content) {
            //提取圖片路徑的src的正則表達式 並把結果存入$matches中
            preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/", $content, $matches);
            $img = "";
            if (!empty($matches)) {
                //註意，上面的正則表達式說明src的值是放在數組的第三個中
                $img = $matches[1];
            } else {
                $img = "";
            }
            if (!empty($img)) {
                $patterns = array();
                $replacements = array();
                //$default = config('filesystems.disks.qiniu.domains.default');
                foreach ($img as $imgItem) {
                    //if (strpos($imgItem, $default) !== false) {
                    //    $final_imgUrl = $imgItem;
                    //} else {
                    $final_imgUrl = $con . $imgItem;
                    //}
                    $replacements[] = $final_imgUrl;
                    $img_new = "/" . preg_replace("/\//i", "\/", $imgItem) . "/";
                    $patterns[] = $img_new;
                }
                //讓數組按照key來排序
                ksort($patterns);
                ksort($replacements);
                //替換內容
                $content = preg_replace($patterns, $replacements, $content);
            }
        }
        return $content;
    }

    /**
     * @name 生成隨機字符串
     * @description
     * @param length Int 生成字符串長度
     * @return String
     **@author 非比網絡
     * @date 2021/6/12 0:38
     */
    public function GetRandStr(int $length = 11): String
    {
        //字符組合
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($str) - 1;
        $randstr = '';
        for ($i = 0; $i < $length; $i++) {
            $num = mt_rand(0, $len);
            $randstr .= $str[$num];
        }
        return $randstr;
    }

    /**
     * @name  處理二維數組轉為json字符串亂碼問題
     * @description
     * @param data Array  需要轉為json字符串的數組
     * @return String
     **@author 非比網絡
     * @date 2021/6/12 0:40
     */
    public function setJsonEncodes($data): String
    {
        $count = count($data);
        for ($k = 0; $k < $count; $k++) {
            foreach ($data[$k] as $key => $value) {
                $data[$k][$key] = urlencode($value);
            }
        }
        return urldecode(json_encode($data));
    }

    /**
     * @name 傳入時間戳,計算距離現在的時間
     * @description
     * @param theTime Int 時間戳
     * @return String
     **@author 非比網絡
     * @date 2021/6/12 2:55
     */
    public function format_time(int $theTime = 0): String
    {
        $nowTime = time();
        $dur = $nowTime - $theTime;
        if ($dur < 0) {
            return $theTime;
        } else {
            if ($dur < 60) {
                return $dur . '秒前';
            } else {
                if ($dur < 3600) {
                    return floor($dur / 60) . '分鐘前';
                } else {
                    if ($dur < 86400) {
                        return floor($dur / 3600) . '小時前';
                    } else {//昨天
                        //獲取今天淩晨的時間戳
                        $day = strtotime(date('Y-m-d', time()));
                        //獲取昨天淩晨的時間戳
                        $pday = strtotime(date('Y-m-d', strtotime('-1 day')));
                        if ($theTime > $pday && $theTime < $day) {//是否昨天
                            return $t = '昨天 ' . date('H:i', $the_time);
                        } else {
                            if ($dur < 172800) {
                                return floor($dur / 86400) . '天前';
                            } else {
                                return date('Y-m-d H:i', $the_time);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @name 處理遞歸數據
     * @description
     * @param array Array  總數據
     * @param pid Int  父級id
     * @return Array
     **@author 非比網絡
     * @date 2021/6/12 1:23
     */
    public function tree(array $array, int $pid = 0): Array
    {
        $tree = array();
        foreach ($array as $key => $value) {
            if ($value['pid'] == $pid) {
                $value['children'] = $this->tree($array, $value['id']);
                if (!$value['children']) {
                    unset($value['children']);
                }
                $tree[] = $value;
            }
        }
        return $tree;
    }

    /**
     * @name 獲取用戶真實 ip
     * @description
     * @return array|false|mixed|string
     **@author 非比網絡
     * @date 2021/6/23 10:46
     */
    public function getClientIp()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        if (getenv('HTTP_X_REAL_IP')) {
            $ip = getenv('HTTP_X_REAL_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
            $ips = explode(',', $ip);
            $ip = $ips[0];
        } elseif (getenv('REMOTE_ADDR')) {
            $ip = getenv('REMOTE_ADDR');
        } else {
            $ip = '0.0.0.0';
        }
        if (!$ip) {
            return '';
        }
        return $ip;
    }

    /**
     * @name PHP格式化字節大小
     * @description
     * @param size Int  字節數
     * @param delimiter string  數字和單位分隔符
     * @return String 格式化後的帶單位的大小
     **@author 非比網絡
     * @date 2021/6/23 17:02
     */
    public function formatBytes(int $size, string $delimiter = ''): String
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
        return round($size, 2) . $delimiter . $units[$i];
    }
}
