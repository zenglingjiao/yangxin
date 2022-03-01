<?php
/**
 * @Name 提示信息
 * @Description
 * @Auther 非比網絡
 * @Date 2021/11/29 16:51
 */

namespace Modules\Common\Exceptions;


class MessageData
{
    const BAD_REQUEST = '服務端異常！';
    const INTERNAL_SERVER_ERROR = '服務器錯誤！';
    const Ok = '操作成功！';
    const PARES_ERROR = '服務器語法錯誤！';
    const Error = '服務器語法錯誤，請註意查看信息！';
    const REFLECTION_EXCEPTION = '服務器異常映射！';
    const RUNTIME_EXCEPTION = '服務器運行期異常 運行時異常 運行異常 未檢查異常！';
    const ERROR_EXCEPTION = '服務器框架運行出錯！';
    const INVALID_ARGUMENT_EXCEPTION = '數據庫鏈接問題！';
    const MODEL_NOT_FOUND_EXCEPTION = '數據模型錯誤！';
    const QUERY_EXCEPTION = '數據庫DB錯誤！';

    const COMMON_EXCEPTION = '網絡錯誤！';
    const API_ERROR_EXCEPTION = '操作失敗！';
    const ADD_API_ERROR = '添加失敗！';
    const ADD_API_SUCCESS = '添加成功！';
    const UPDATE_API_ERROR = '修改失敗！';
    const UPDATE_API_SUCCESS = '修改成功！';
    const STATUS_API_ERROR = '調整失敗！';
    const STATUS_API_SUCCESS = '調整成功！';

    const DELETE_API_ERROR = '刪除失敗！';
    const DELETE_API_SUCCESS = '刪除成功！';

    const DELETE_RECYCLE_API_ERROR = '恢復失敗！';
    const DELETE_RECYCLE_API_SUCCESS = '恢復成功！';

    const TOKEN_ERROR_KEY = 'apikey錯誤！';     // 70001
    const TOKEN_ERROR_SET = '請先登錄！';        // 70002
    const TOKEN_ERROR_BLACK = 'token 被拉黑！';  // 70003
    const TOKEN_ERROR_EXPIRED = 'token 過期！';  // 70004
    const TOKEN_ERROR_JWT = '請先登錄！';         //  70005
    const TOKEN_ERROR_JTB = '請先登錄！';          // 70006

    const NO_PERMISSION = '沒有權限！';
}