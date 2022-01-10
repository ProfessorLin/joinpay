<?php
/**
 * ---------------------------------------------------------------------------------------------------------------------
 * FileName: FactoryInterface.php
 * Description:
 * ---------------------------------------------------------------------------------------------------------------------
 * Author: liner
 * Date:    2022/1/10
 * Version: 1.0
 */

namespace Joinpay\Contracts;


interface JoinPayFactoryInterface
{
    /**
     * @param $driver
     * @return mixed
     */
    public function driver($driver);
}