<?php
/**
 * ---------------------------------------------------------------------------------------------------------------------
 * FileName: UniPayApi.php
 * Description:
 * ---------------------------------------------------------------------------------------------------------------------
 * Author: liner
 * Date:    2022/1/10
 * Version: 1.0
 */

namespace Joinpay\Driver;

use Joinpay\Contracts\JoinPayRequest;
use Joinpay\JoinPayClient;

class UniPay extends JoinPayRequest
{
    protected $uri = 'https://www.joinpay.com/trade/uniPayApi.action';

    protected $method = "POST";

    function __construct($data=[])
    {
        parent::__construct($data);

        $this->params['p0_Version']         = '1.0';
        $this->params['p1_MerchantNo']      = JoinPayClient::getInstance()->app_id;
        $this->params['p4_Cur']             = 1;
        $this->params['qa_TradeMerchantNo'] = JoinPayClient::getInstance()->app_trade_merchantNo;
    }

    /**
     * 设置当前版本号
     * @param $val
     * @return $this
     */
    public function setVerison($val){
        $this->params['p0_Version'] = $val;
        return $this;
    }

    /**
     * 设置商户ID
     * @param $val
     * @return $this
     */
    public function setMerchantNo($val){
        $this->params['p1_MerchantNo'] = $val;
        return $this;
    }

    /**
     * 设置商家订单号
     * @param $val
     * @return $this
     */
    public function setOrderNo($val){
        $this->params['p2_OrderNo'] = $val;
        return $this;
    }

    /**
     * 设置金额
     * @param $val
     * @return $this
     */
    public function setAmount($val){
        $this->params['p3_Amount'] = $val;
        return $this;
    }

    /**
     * 社渚商品名称
     * @param $val
     * @return $this
     */
    public function setProductName($val){
        $this->params['p5_ProductName'] = $val;
        return $this;
    }

    /**
     * 设置商品描述
     * @param $val
     * @return $this
     */
    public function setProductDesc($val){
        $this->params['p6_ProductDesc'] = $val;
        return $this;
    }

    /**
     * 设置公共的回传参数
     * @param $val
     * @return $this
     */
    public function setMp($val){
        $this->params['p7_Mp'] = $val;
        return $this;
    }

    /**
     * 设置异步回调地址
     * @param $val
     * @return $this
     */
    public function setNotifyUrl($val){
        $this->params['p9_NotifyUrl'] = $val;
        return $this;
    }

    /**
     * 设置交易类型
     * 主扫业务为为用户主扫，商户被扫
     * @param $val   ALIPAY_NATIVE 支付宝(主扫)、WEIXIN_NATIVE 微信（主扫）、UNIONPAY_NATIVE 银联扫码主扫、JD_NATIVE 京东扫码主扫、BAIDU_NATIVE 百度扫码主扫、SUNING_NATIVE 苏宁扫码（主扫）
     * @return $this
     */
    public function setFrpCode($val){
        $this->params['q1_FrpCode'] = $val;
        return $this;
    }

    /**
     * 银行商户编码
     * @param $val
     * @return $this
     */
    public function setMerchantBankCode($val){
        $this->params['q2_MerchantBankCode'] = $val;
        return $this;
    }

    /**
     * 是否输出图片
     * @param $val  默认为空,不输出图片；填1表示输出图片，仅交易类型为主扫时可用
     * @return $this
     */
    public function setIsShowPic($val){
        $this->params['q4_IsShowPic'] = $val;
        return $this;
    }

    /**
     * 微信OpenID 公众号获取用户Openid,公众号支付商户及微信小程序商户必填（即当q1_FrpCode=WEIXIN_GZH、WEIXIN_XCX）;
     * @param $val
     * @return $this
     */
    public function setOpenId($val){
        $this->params['q5_OpenId'] = $val;
        return $this;
    }

    /**
     * 付款码数字
     * 付款码数字被扫支付必填（即当q1_FrpCode= ALIPAY_CARD、WEIXIN_CARD、JD_CARD、QQ_CARD、UNIONPAY_CARD）
     * @param $val
     * @return $this
     */
    public function setAuthCode($val){
        $this->param['q6_AuthCode'] = $val;
        return $this;
    }

    /**
     * APPID
     * 微信公众号、微信小程序、微信App、微信app+支付必填（即当q1_FrpCode= WEIXIN_GZH、WEIXIN_XCX、WEIXIN_APP3【对应报备小程序appid】）
     * @param $val
     * @return $this
     */
    public function setAppId($val){
        $this->param['q7_AppId'] = $val;
        return $this;
    }

    /**
     * 终端号
     * @param $val
     * @return $this
     */
    public function setTerminalNo($val){
        $this->param['q8_TerminalNo'] = $val;
        return $this;
    }

    /**
     * 支付宝H5模式，默认为空
     * 1.模式一：当 q9_TransactionModel = MODEL1 或为空时，有应答参数返回，rc_Result中返回html，需进行重定向跳转；
     * 2.模式二：当 q9_TransactionModel = MODEL2 时，直接跳转链接，不返回应答参数。
     * @param $val
     * @return $this
     */
    public function setTransactionModel($val){
        $this->param['q9_TransactionModel'] = $val;
        return $this;
    }

    /**
     * 报备商户号
     * @param $val
     * @return $this
     */
    public function setTradeMerchantNo($val){
        $this->param['qa_TradeMerchantNo'] = $val;
        return $this;
    }

    /**
     * 买家的支付宝唯一用户号   支付宝服务窗支付必填（即当q1_FrpCode=ALIPAY_FWC ）
     * @param $val
     * @return $this
     */
    public function setBuyerId($val){
        $this->param['qb_buyerId'] = $val;
        return $this;
    }

    /**
     * 禁用的支付方式，目前仅支持使用微信和支付宝支付时可禁用某些方式
     * 微信支付：
     *      no_credit  信用卡
     * 支付宝：
     *      no_credit   余额
     *      moneyFund   余额宝
     *      debitCardExpress    借记卡（储蓄卡）
     *      creditCard  信用卡
     *      pcredit     花呗
     *      pcreditpayInstallment   花呗分期
     *      credit_group    信用支付类型 （包含信用卡花呗，花呗分期）
     * @param $val
     * @return $this
     */
    public function setDisablePayModel($val){
        $this->param['qk_DisablePayModel'] = $val;
        return $this;
    }

}
