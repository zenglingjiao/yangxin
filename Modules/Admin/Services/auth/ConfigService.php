<?php
/**
 * @Name 系統配置服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/11 23:21
 */

namespace Modules\Admin\Services\auth;


use Illuminate\Support\Facades\DB;
use Modules\Admin\Models\AuthArea;
use Modules\Admin\Models\AuthConfig;
use Modules\Admin\Models\AuthOperationLog;
use Modules\Admin\Models\AuthProject;
use Modules\Admin\Models\AuthRule;
use Modules\Admin\Services\BaseAdminService;
use Illuminate\Support\Facades\Cache;
class ConfigService extends BaseAdminService
{
    /**
     * @name 清除緩存
     * @description
     * @author 非比網絡
     * @date 2021/6/11 23:24
     * @return JSON
     **/
    public function outCache(){
        //        Cache::forget('areaList');
        return $this->apiSuccess('清除成功！');
    }
    /**
     * @name 獲取地區數據
     * @description
     * @author 非比網絡
     * @date 2021/6/11 23:24
     * @return JSON
     **/
    public function getAreaData(){
        $list = Cache::get('auth_rule');
        if(!$list){
            $list = AuthArea::orderBy('sort','asc')
                ->orderBy('id','asc')
                ->where('status',1)
                ->get()
                ->toArray();
            if(count($list)){
                $list = $this->tree($list);
                Cache::put('areaList',$list);
            }
        }
        return $this->apiSuccess('',$list);
    }

    /**
     * @name 轉換編輯器內容
     * @description
     * @author 非比網絡
     * @date 2021/7/1 11:07
     * @param  content String  編輯器內容
     * @return JSON
     **/
    public function content(string $content){
        $project_id = (new TokenService())->my()->project_id;
        preg_match_all('/<img (.*?)+src=[\'"](.*?)[\'"]/i',$content,$matches);
        $img = "";
        $replacements = [];
        if(!empty($matches)) {
            //註意，上面的正則表達式說明src的值是放在數組的第三個中
            $img = $matches[2];
        }
        if (!empty($img)) {
            $http = $this->getHttp();
            $patterns= array();
            $replacements = array();
            $date = date('YmdH');
            iconv("UTF-8", "GBK",$date);
            if(!file_exists(public_path('upload/images') . '/' . $project_id)){
                mkdir(public_path('upload/images') . '/' . $project_id . '',0777,true);
            }
            if(!file_exists(public_path('upload/images') . '/' . $project_id. '/content')){
                mkdir(public_path('upload/images') . '/' . $project_id. '/content',0777,true);
            }
            $dir = public_path('upload/images') . '/' . $project_id . '/content/' . $date;
            if (!file_exists($dir)){
                mkdir($dir,0777,true);
            }
            foreach($img as $imgItem){
                $url = $this->getRandStr(20).rand(1,99999).'.png';
                if($fileInfo = @file_get_contents(str_replace('&amp;','&',$imgItem))){
                    file_put_contents($dir.'/'.$url,$fileInfo);
                    $replacements[] = '/upload/images/' .$project_id . '/content/' . $date.'/'.$url;
                    $img_new = "/".preg_replace("/\//i","\/",$imgItem)."/";
                    $patterns[] = $img_new;
                }
            }
            //讓數組按照key來排序
            ksort($patterns);
            ksort($replacements);
            $replacementsArr = [];
            foreach ($replacements as $k=>$v){
                $replacementsArr[] = $http.$v;
            }
            //替換內容
            $content = preg_replace($patterns,$replacementsArr, $content);
        }
        return [
            'content'=>$content,
            'urlArr'=>$replacements
        ];
    }
}
