<?php

namespace Helpers;

use Helpers\FormValidation\FormValidationHelper;
use Exception;

/**
 * Description of Uri
 *
 * @author Eric Teixeira
 */
class RequestHelper
{

    private static $routineData;

    public static function get($key, $description = null, $validations = null, $options = null, $decodeUri = false)
    {
        if (!isset($_GET[$key])) {
            return null;
        }

        if (is_array($_GET[$key])) {
            self::inputArray($_GET[$key], $decodeUri);
            return $_GET[$key];
        }

        $_GET[$key] = StringHelper::removeInvisibleCharacters($_GET[$key], FALSE);
        if (trim($_GET[$key]) == '' && !isset($description)) {
            return null;
        }

        if (isset($description) && isset($validations) && is_string($description) && is_array($validations) && count($validations) > 0) {
            $validation = new FormValidationHelper($_GET[$key], $description, $validations, $options);
            if($decodeUri){
                return urldecode($validation->getValue());
            }
            return $validation->getValue();
        }

        if ($decodeUri) {
            return trim(urldecode($_GET[$key]));
        }

        return trim($_GET[$key]);
    }

    public static function gets($decodeUri = false)
    {
        if (!isset($_GET)) {
            return array();
        }
        self::inputArray($_GET, $decodeUri);
        return $_GET;
    }

    private static function inputArray(&$array, $decodeUri = false)
    {
        foreach ($array as &$value) {
            if (!is_array($value)) {
                if ($decodeUri) {
                    $value = urldecode($value);
                }
                $value = trim(StringHelper::removeInvisibleCharacters($value, FALSE));
                continue;
            }
            self::inputArray($value);
        }
    }

    public static function posts($decodeUri = false)
    {
        if (!isset($_POST)) {
            return array();
        }
        self::inputArray($_POST, $decodeUri);
        return $_POST;
    }

    public static function post($key, $description = null, $validations = null, $options = null, $decodeUri= false)
    {
        if (!isset($_POST[$key]) && !isset($description)) {
            return null;
        }

        if (!isset($_POST[$key]) && isset($description)) {
            $_POST[$key] = null;
        }

        if (is_array($_POST[$key])) {
            self::inputArray($_POST[$key], $decodeUri);
            return $_POST[$key];
        }

        $_POST[$key] = StringHelper::removeInvisibleCharacters($_POST[$key], FALSE);
        if (trim($_POST[$key]) == '' && !isset($description)) {
            return null;
        }

        if (isset($description) && isset($validations) && is_string($description) && is_array($validations) && count($validations) > 0) {
            $validation = new FormValidationHelper($_POST[$key], $description, $validations, $options);
            if($decodeUri){
                return urldecode($validation->getValue());
            }
            return $validation->getValue();
        }

        if($decodeUri){
            return trim(urldecode($_POST[$key]));
        }

        return trim($_POST[$key]);
    }

    public static function getHttpMethod()
    {
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            return false;
        }

        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getContent()
    {
        $data = file_get_contents('php://input');
        return $data;
    }

    public static function getData()
    {
        $data = file_get_contents('php://input');
        $data = @json_decode($data, true);
        return (isset($data) ? $data : false);
    }

    public static function getHeader($field)
    {
        if (isset($_SERVER['HTTP_' . strtoupper($field)])) {
            return StringHelper::removeInvisibleCharacters($_SERVER['HTTP_' . strtoupper($field)]);
        }

        if (isset($_SERVER[strtoupper($field)])) {
            return StringHelper::removeInvisibleCharacters($_SERVER[strtoupper($field)]);
        }

        if (isset($_SERVER[$field])) {
            return StringHelper::removeInvisibleCharacters($_SERVER[$field]);
        }

        return '';
    }

    /**
     * @param $key
     * @param null $description
     * @param null $validations
     * @param null $options
     * @return bool
     * @throws Exception
     */
    public static function json($key, $description = null, $validations = null, $options = null, $decodeUri = false)
    {
        $data = self::getData();
        if (!isset($data[$key]) && !isset($description)) {
            return null;
        }

        if (!isset($data[$key]) && isset($description)) {
            $data[$key] = null;
        }

        if (is_array($data[$key])) {
            self::inputArray($data[$key], $decodeUri);
            return $data[$key];
        }

        $data[$key] = StringHelper::removeInvisibleCharacters($data[$key], FALSE);
        if (trim($data[$key]) == '' && !isset($description)) {
            return null;
        }

        if (isset($description) && isset($validations) && is_string($description) && is_array($validations) && count($validations) > 0) {
            $validation = new FormValidationHelper($data[$key], $description, $validations, $options);
            if($decodeUri){
                return urldecode($validation->getValue());
            }
            return $validation->getValue();
        }

        if($decodeUri){
            return trim(urldecode($data[$key]));    
        }

        return trim($data[$key]);
    }

    public static function jsons($decodeUri = false)
    {
        $data = self::getData();
        if ($data === false) {
            return [];
        }

        self::inputArray($data, $decodeUri);
        return $data;
    }

    public static function setRoutineData($routine, $filename)
    {
        if (!is_file(getenv('PATH_TMP') . $filename)) {
            throw new Exception('Arquivo "' . $filename . '" temporário da rotina "' . $routine . '" não existe.');
        }
        $content = file_get_contents(getenv('PATH_TMP') . $filename);
        self::$routineData = @json_decode($content, true);
        if (!self::$routineData || !is_array(self::$routineData)) {
            self::$routineData = [];
        }
        RoutineHelper::close($filename);
    }

    public static function routine($key, $description = null, $validations = null, $options = null)
    {
        if (!isset(self::$routineData[$key]) && !isset($description)) {
            return null;
        }

        if (!isset(self::$routineData[$key]) && isset($description)) {
            self::$routineData[$key] = null;
        }

        if (is_array(self::$routineData[$key])) {
            self::inputArray(self::$routineData[$key]);
            return self::$routineData[$key];
        }

        self::$routineData[$key] = StringHelper::removeInvisibleCharacters(self::$routineData[$key], FALSE);
        if (trim(self::$routineData[$key]) == '' && !isset($description)) {
            return null;
        }

        if (isset($description) && isset($validations) && is_string($description) && is_array($validations) && count($validations) > 0) {
            $validation = new FormValidationHelper(self::$routineData[$key], $description, $validations, $options);
            return $validation->getValue();
        }

        return trim(self::$routineData[$key]);
    }

    /**
     * @param $url
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public static function sendGetJson($url, $headers = [], $ssl = true, $encoded = true, $timeout = 30)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, false);

        if ($ssl === false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }

        if ($encoded === false) {
            curl_setopt($ch, CURLOPT_ENCODING, "");
        }

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (curl_errno($ch)) {
            throw new Exception('Ocorreu um erro na sua requisição / Info: ' . json_encode($info, JSON_PRETTY_PRINT));
        }

        curl_close($ch);

        return array(
            'response' => $response,
            'info' => $info
        );
    }

    /**
     * @param $url
     * @param $data
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public static function sendPostJson($url, $data, $headers = [], $ssl = true, $encoded = true, $timeout = 30)
    {
        $ch = curl_init();
        $postFields = (is_array($data) ? json_encode($data) : $data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, StringHelper::escapeSequenceDecode($postFields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, false);

        if ($ssl === false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }

        if ($encoded === false) {
            curl_setopt($ch, CURLOPT_ENCODING, "");
        }

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (curl_errno($ch)) {
            throw new Exception('Ocorreu um erro na sua requisição / Info: ' . json_encode($info, JSON_PRETTY_PRINT));
        }

        curl_close($ch);

        return array(
            'response' => $response,
            'info' => $info
        );
    }

    /**
     * @param $url
     * @param $data
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public static function sendPostForm($url, $data, $headers = [], $ssl = true, $encoded = true, $timeout = 30)
    {
        $ch = curl_init();
        $postFields = (is_array($data) ? http_build_query($data) : $data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, StringHelper::escapeSequenceDecode($postFields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, false);

        if ($ssl === false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }

        if ($encoded === false) {
            curl_setopt($ch, CURLOPT_ENCODING, "");
        }

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (curl_errno($ch)) {
            throw new Exception('Ocorreu um erro na sua requisição / Info: ' . json_encode($info, JSON_PRETTY_PRINT));
        }

        curl_close($ch);

        return array(
            'response' => $response,
            'info' => $info
        );
    }
}
