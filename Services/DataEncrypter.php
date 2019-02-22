<?php


namespace CrossKnowledge\FeedbackDataEncrypterBundle\Services;


class DataEncrypter
{
    /**
     * encrypt data in 128 bits
     *
     * @param array|string $data
     * @param string $key
     * @param string $method : the cypher method
     * @return string
     */
    public function encrypt($data, $key, $method='aes128') {

         if (empty($data)) {
            return $data;
        }

        $ivSize = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($ivSize);

        $data = json_encode($data);
        $crypted_text = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);

        return base64_encode($iv . $crypted_text);
    }

    /**
     * Decrypt 128 bits data
     *
     * @param string $data
     * @param string $key
     * @param string $method : the cypher method
     * @return mixed The decrypted value is returned, and can be a boolean, integer, float, string, array or object.
     */
    public function decrypt($data, $key, $method='aes128') {
        $data = base64_decode($data);
        $ivSize = openssl_cipher_iv_length($method);
        $iv = substr($data, 0, $ivSize);
        $string = openssl_decrypt(substr($data, $ivSize), $method, $key, OPENSSL_RAW_DATA, $iv);

        return json_decode($string, true);
    }
}