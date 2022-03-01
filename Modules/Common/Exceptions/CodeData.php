<?php
/**
 * @Name http狀態碼
 * @Description
 * @Auther 非比網絡
 * @Date 2021/11/29 16:43
 */

namespace Modules\Common\Exceptions;


class CodeData
{
    //1**：請求收到，繼續處理
    //2**：操作成功收到，分析、接受
    //3**：完成此請求必須進一步處理
    //4**：請求包含一個錯誤語法或不能完成
    //5**：服務器執行一個完全有效請求失敗
    const CONTINUE = 100;    //客戶必須繼續發出請求
    const SWITCHING_PROTOCOLS = 101; //客戶要求服務器根據請求轉換HTTP協議版本
    const PROCESSING = 102;


    const OK = 200;   //交易成功
    const CREATED = 201;    // 提示知道新文件的URL
    const ACCEPTED = 202;   //接受和處理、但處理未完成
    const NON_AUTHORIATIVE_INFORMATION = 203;  //返回信息不確定或不完整
    const NO_CONTENT = 204;   //請求收到，但返回信息為空
    const RESET_CONTENT = 205;     //服務器完成了請求，用戶代理必須復位當前已經瀏覽過的文件
    const PARTIAL_CONTENT = 206;  //服務器已經完成了部分用戶的GET請求
    const MULTI_STATUS = 207;



    const MULTIPLE_CHOICES = 300;  //請求的資源可在多處得到
    const MOVED_PERMANENTLY = 301; //刪除請求數據
    const FOUND = 302;   //在其他地址發現了請求數據
    const SEE_OTHER = 303;//建議客戶訪問其他URL或訪問方式
    const NOT_MODIFIED = 304;//客戶端已經執行了GET，但文件未變化
    const USER_PROXY = 305;//請求的資源必須從服務器指定的地址得到
    const UNUSED = 306;//前一版本HTTP中使用的代碼，現行版本中不再使用
    const TEMPORARY_REDIRECT = 307;//申明請求的資源臨時性刪除



    const BAD_REQUEST = 400; //錯誤請求，如語法錯誤
    const UNAUTHORIZED = 401;//請求授權失敗
    const PAYMENT_GRANTED = 402;//保留有效ChargeTo頭響應
    const FORBIDDEN = 403;//請求不允許
    const FILE_NOT_FOUND = 404;//沒有發現文件、查詢或URl
    const METHOD_NOT_ALLOWED = 405;//用戶在Request-Line字段定義的方法不允許
    const NOT_ACCEPTABLE = 406;//根據用戶發送的Accept拖，請求資源不可訪問
    const PROXY_AUTHENTICATION_REQUIRED = 407;//類似401，用戶必須首先在代理服務器上得到授權
    const REQUEST_TIME_OUT = 408;//客戶端沒有在用戶指定的餓時間內完成請求
    const CONFLICT = 409;//對當前資源狀態，請求不能完成
    const GONE = 410;//服務器上不再有此資源且無進一步的參考地址
    const LENGTH_REQUIRED = 411;//服務器拒絕用戶定義的Content-Length屬性請求
    const PRECONDITION_FAILED = 412;//一個或多個請求頭字段在當前請求中錯誤
    const REQUEST_ENTITY_TOO_LARGE = 413;//請求的資源大於服務器允許的大小
    const REQUEST_URL_TOO_LARGE = 414;//請求的資源URL長於服務器允許的長度
    const UNSUPPORTED_MEDIA_TYPE = 415;//請求資源不支持請求項目格式
    const REQUESTED_RANGE_NOT_SATISFIABLE = 416;//請求中包含Range請求頭字段，在當前請求資源範圍內沒有range指示值，請求也不包含If-Range請求頭字段
    const EXPECTATION_FAILED = 417;//服務器不滿足請求Expect頭字段指定的期望值，如果是代理服務器，可能是下一級服務器不能滿足請求
    const UNPROCESSABLE_ENTITY = 422;
    const LOCKED = 423;
    const FAILED_DEPENDENCY = 424;



    const INTERNAL_SERVER_ERROR = 500;//服務器產生內部錯誤
    const NOT_IMPLEMENTED = 501;//服務器不支持請求的函數
    const BAD_GATEWAY = 502;//服務器暫時不可用，有時是為了防止發生系統過載
    const SERVICE_UNAVAILABLE = 503;//服務器過載或暫停維修
    const GATEWAY_TIMEOUT = 504;//關口過載，服務器使用另一個關口或服務來響應用戶，等待時間設定值較長
    const HTTP_VERSION_ONT_SUPPORTED = 505;//服務器不支持或拒絕支請求頭中指定的HTTP版本
    const INSUFFICIENT_STORAGE = 507;
}