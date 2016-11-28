<?php


namespace CrossKnowledge\DataEncrypterBundle\Services;


class DataEncrypter
{
    /**
     * Encrypt data in 128 bits
     *
     * @param array|string $data
     * @param string $key
     * @return string
     */
    public function encrypt($data, $key)
    {
        if (empty($data)) {
            return $data;
        }

        $data = rtrim(json_encode($data));
        $td   = mcrypt_module_open(MCRYPT_RIJNDAEL_128, "", MCRYPT_MODE_ECB, "");
        $iv   = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = base64_encode(mcrypt_generic($td, '!'.$data));
        mcrypt_generic_deinit($td);

        return $data;

    }

    /**
     * Decrypt 128 bits data
     *
     * @param string $data
     * @param string $key
     * @return mixed The decrypted value is returned, and can be a boolean, integer, float, string, array or object.
     */
    public function decrypt($data, $key)
    {
        if (empty($data)) {
            return $data;
        }

        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, "", MCRYPT_MODE_ECB, "");
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = mdecrypt_generic($td, base64_decode($data));
        mcrypt_generic_deinit($td);

        if (substr($data, 0, 1) != '!') {
            return false;

        }

        $data = substr($data, 1, strlen($data) - 1);

        return json_decode(rtrim($data), true);
    }
}