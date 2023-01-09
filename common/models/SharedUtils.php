<?php

namespace common\models;

use Yii;

/**
 * Description of SharedUtils
 *
 * @author Francis Chulu
 */
class SharedUtils {

    public static function maskNumber($number) {
        $rest = substr($number, -4);
        return "********" . "$rest";
    }

    /**
     * Get json data from url
     * @param type $msisdn
     * @param type $url
     * @param type $payload
     * @param type $log
     * @return type
     */
    public static function getJson($url) {
        $resp = [
            "status" => 0,
            "content" => ""
        ];
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url,
                    [
                        'verify' => false,
                        'timeout' => Yii::$app->params['connectionTimeout'],
                        'connect_timeout' => Yii::$app->params['connectionTimeout']
            ]);
            if ($response->getStatusCode() === 200 ||
                    $response->getStatusCode() === 202) {
                $resp['status'] = 1;
                $resp['content'] = $response->getBody()->getContents();
            }
        } catch (Exception | \GuzzleHttp\Exception | \GuzzleHttp\Exception\RequestException | \GuzzleHttp\Exception | \GuzzleHttp\Exception\ConnectException | \GuzzleHttp\Exception\ClientException $ex) {
            $resp['content'] = "Exception occured. Error is:" . $ex->getMessage();
            return $resp;
        }
        return $resp;
    }

    /**
     * Sending http json request
     * @param type $msisdn
     * @param type $url
     * @param type $payload
     * @param type $log
     * @return type
     */
    public static function postJson($url, $payload) {
        $resp = [
            "status" => 0, //not OK
            "content" => "",
        ];
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $url, [
                'verify' => false,
                'body' => json_encode($payload),
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'timeout' => Yii::$app->params['connectionTimeout'],
                'connect_timeout' => Yii::$app->params['connectionTimeout']
            ]);

            if ($response->getStatusCode() === 200 ||
                    $response->getStatusCode() === 202) {
                $resp['status'] = 1; //OK
                $resp['content'] = $response->getBody()->getContents();
            }
        } catch (\GuzzleHttp\Exception | \GuzzleHttp\Exception\ConnectException | \GuzzleHttp\Exception\ClientException | GuzzleHttp\Exception\RequestException $ex) {
            $resp['content'] = "Exception occured. Error is:" . $ex->getMessage();
            return $resp;
        }
        return $resp;
    }

    public static function postJsonKycData($url, $payload) {
        $resp = [
            "status" => 0, //not OK
            "content" => ""
        ];
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data"));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, Yii::$app->params['connectionTimeout']);
            curl_setopt($ch, CURLOPT_TIMEOUT, Yii::$app->params['connectionTimeout']);
            $output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode === 200 ||
                    $httpcode === 202) {
                $resp['status'] = 1; //OK
                $resp['content'] = $output;
            }
        } catch (Exception $ex) {
            return $resp;
        }
        return $resp;
    }

}
