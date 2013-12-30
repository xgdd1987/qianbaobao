<?php
class Mcrypt
{
    /**
     * 解密
     * 
     * @param string $encryptedText 已加密字符串
     * @param string $key  密钥
     * @return string
     */
    public static function _decrypt($encryptedText,$key = null)
    {
//        $key = $key === null ? Config::get('secret_key') : $key;
        $cryptText = base64_decode($encryptedText);
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $decryptText = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $cryptText, MCRYPT_MODE_ECB, $iv);
        return trim($decryptText);
    }
    /**
     * 加密
     *
     * @param string $plainText 未加密字符串 
     * @param string $key        密钥
     */
    public static function _encrypt($plainText,$key = null)
    {
//        $key = $key === null ? Config::get('secret_key') : $key;
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $encryptText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plainText, MCRYPT_MODE_ECB, $iv);
        return trim(base64_encode($encryptText));
    }
}
//
//$dd=new Mcrypt();
//echo $dd->_encrypt('汉子阿什顿地方<>asas.,=dfdfd','123123');
//echo $dd->_decrypt('lJZClyywfL8eSe4g9/50HHwHj1b1N40Hy2Andrt1I09i80PY4HUeNgDzljfIGuTuT7V1/6uop8+8j4jawqZaWA==','123123');


