<?php
/**
 * ---------------------------------------------------------------------------------------------------------------------
 * FileName: QueryOrder.php
 * Description:
 * ---------------------------------------------------------------------------------------------------------------------
 *
 */

namespace Joinpay\Driver;

use Joinpay\Contracts\JoinPayRequest;
use Joinpay\JoinPayClient;

class UniPayQuery extends JoinPayRequest
{

    protected $uri = 'https://www.joinpay.com/trade/queryOrder.action';

    protected $method = 'POST';

    public function __construct($data=[])
    {
        parent::__construct($data);
        $this->params['p1_MerchantNo'] = JoinPayClient::getInstance()->app_id;
    }

    /**
     * 商户的唯一单号
     * @param $val
     * @return $this
     */
    public function setOrderNo($val){
        $this->params['p2_OrderNo'] = $val;
        return $this;
    }

}
