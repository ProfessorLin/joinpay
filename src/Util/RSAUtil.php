<?php
/**
 * ---------------------------------------------------------------------------------------------------------------------
 * FileName: RSAUtil.php
 * Description:
 * ---------------------------------------------------------------------------------------------------------------------
 * Author: jackven <jackven@qq.com>
 * Date:    2021/4/15
 * Version: 1.0
 */

namespace Jackven\Joinpay\Util;

class RSAUtil
{
    /**
     * 获取私钥
     * @param string $data
     */
    public static function getPrivateKey(string $data){
        if(is_file($data)){
            $keyRead = file_get_contents($data);
            $privateKey = openssl_get_privatekey($keyRead);
        }elseif (!empty($data)){
            $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
                wordwrap($data, 64, "\n", true) .
                "\n-----END RSA PRIVATE KEY-----";
        }else{
            $privateKey = false;
        }
        return $privateKey;
    }

    /**
     * 获取公钥
     * @param string $data
     */
    public static function getPublicKey(string $data){
        if(is_file($data)){
            $keyRead = file_get_contents($data);
            $PublicKey = openssl_get_publickey($keyRead);
        }elseif (!empty($data)){
            $PublicKey = "-----BEGIN PUBLIC KEY-----\n" .
                wordwrap($data, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";
        }else{
            $PublicKey = false;
        }
        return $PublicKey;
    }

    /**
     * 计算签名
     * @param string $data
     * @param string $key
     * @param string $encodeMod
     *
     * @return bool|string
     */
    public static function sign(string $data, string $key, $encodeMod = 'RSA'){

        $rsakey = self::getPrivateKey($key);

        if(empty($rsakey) || !$rsakey){
            return false;
        }

        if(strtoupper($encodeMod) == 'RSA2'){
            openssl_sign($data,$sign,$rsakey,OPENSSL_ALGO_SHA256);
        }elseif (strtoupper($encodeMod) == 'RSA'){
            openssl_sign($data,$sign,$rsakey);
        }

        if(is_file($key)){
            openssl_free_key($rsakey);
        }

        return base64_encode($sign);
    }

    /**
     * 验证签名
     * @param string $data
     * @param string $sign
     * @param string $key
     * @param string $encodeMod
     *
     * @return bool
     */
    public static function verify(string $data, string $sign, string $key, $encodeMod = 'RSA'){

        $rsakey = self::getPublicKey($key);

        if(empty($rsakey) || !$rsakey){
            return false;
        }

        if(strtoupper($encodeMod) == 'RSA2'){
            $result = openssl_verify($data,base64_decode($sign),$rsakey,OPENSSL_ALGO_SHA256);
        }elseif (strtoupper($encodeMod) == 'RSA'){
            $result = openssl_verify($data,base64_decode($sign),$rsakey);
        }

        if(is_file($key)){
            openssl_free_key($rsakey);
        }

        return $result === 1;
    }

    /**
     * RSA加密
     * @param string $data
     * @param string $key
     * @param string $type
     *
     * @return bool|string
     */
    public static function SslEncrypt(string $data,string $key, $type = 'private'){

        $rsakey = ($type == 'private') ? self::getPrivateKey($key) : self::getPublicKey($key);

        if(empty($rsakey) || !$rsakey){
            return false;
        }

        $result = ($type == 'private') ? openssl_private_encrypt($data,$crypted, $rsakey) : openssl_public_encrypt($data,$crypted, $rsakey);

        if(is_file($key)){
            openssl_free_key($rsakey);
        }

        if(!$result){
            return false;
        }

        return base64_encode($crypted);
    }

    /**
     * RSA 解密
     * @param string $data
     * @param string $key
     * @param string $type
     *
     * @return bool
     */
    public static function SslDecrypt(string $data,string $key, $type = 'private'){

        $rsakey = ($type == 'private') ? self::getPrivateKey($key) : self::getPublicKey($key);

        if(empty($rsakey) || !$rsakey){
            return false;
        }

        $result = ($type == 'private') ? openssl_private_decrypt(base64_decode($data),$crypted, $rsakey) : openssl_public_decrypt(base64_decode($data),$crypted, $rsakey);

        if(is_file($key)){
            openssl_free_key($rsakey);
        }

        if(!$result){
            return false;
        }

        return $crypted;
    }
}
