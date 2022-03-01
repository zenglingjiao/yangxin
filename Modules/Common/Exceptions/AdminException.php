<?php
/**
 * @Name 後台異常處理
 */
namespace Modules\Common\Exceptions;

use Throwable;

class AdminException extends \Exception
{
    public function __construct(array $adminErrConst, Throwable $previous = null)
    {
        parent::__construct($adminErrConst['message'],$adminErrConst['status'], $previous);
    }
}