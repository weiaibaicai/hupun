<?php

namespace Weiaibaicai\Hupun;

use Illuminate\Support\Facades\Log;
use Weiaibaicai\Hupun\Exceptions\HttpException;
use Weiaibaicai\Hupun\Exceptions\RespondException;

class BaseClient
{
    protected $appKey;

    protected $secretKey;

    protected $gatewayUrl;

    protected $format = 'json';

    protected $connectTimeout;

    protected $readTimeout;

    protected $config;

    protected $logChannel = '';

    protected $isLogResult = false;

    protected $signMethod = 'md5';

    protected $apiVersion = 'v1';

    public function __construct(array $config = [])
    {
        empty($config) && $config = config('hupun');

        $this->setConfig($config);

        $this->useConfig('open');
    }

    public static function __callStatic($method, $arguments)
    {
        return (new static())->{$method}(...$arguments);
    }

    public static function make(array $config = []): BaseClient
    {
        return new static($config);
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function useConfig(string $key): void
    {
        $this->setAppKey($this->config[$key]['api_key']);
        $this->setSecretKey($this->config[$key]['api_secret']);
        $this->setGatewayUrl($this->config[$key]['api_url']);
        $this->setLogChannel($this->config[$key]['api_log_channel']);
        $this->setIsLogResult((bool)$this->config[$key]['api_is_log_result']);
    }

    public function setAppKey(string $appKey): void
    {
        $this->appKey = $appKey;
    }

    public function setSecretKey(string $secretKey): void
    {
        $this->secretKey = $secretKey;
    }

    public function setGatewayUrl(string $gatewayUrl): void
    {
        $this->gatewayUrl = $gatewayUrl;
    }

    public function setConnectTimeout($connectTimeout): void
    {
        $this->connectTimeout = $connectTimeout;
    }

    public function setReadTimeout($readTimeout): void
    {
        $this->readTimeout = $readTimeout;
    }

    public function setLogChannel(string $logChannel): void
    {
        $this->logChannel = $logChannel;
    }

    public function setIsLogResult($isLogResult): void
    {
        $this->isLogResult = $isLogResult;
    }


    public function generateSign($params, $isOpen = false): string
    {
        ksort($params);

        $stringToBeSigned = $this->secretKey;
        foreach ($params as $k => $v) {
            if (is_array($v)) {
                throw new \Exception('input param is error');
            }

            //跳过文件
            if (strpos($v, '@') === 0) {
                continue;
            }

            if ($isOpen) {
                $stringToBeSigned .= urlencode($k) . '=' . urlencode($v) . '&';
            } else {
                $stringToBeSigned .= $k . $v;
            }
        }

        $stringToBeSigned = rtrim($stringToBeSigned, '&');
        $stringToBeSigned .= $this->secretKey;

        return strtoupper(md5($stringToBeSigned));
    }

    public function curl($url, $postFields = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($this->readTimeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->readTimeout);
        }
        if ($this->connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        }

        // HTTPS 请求
        if (strlen($url) > 5 && 'https' == strtolower(substr($url, 0, 5))) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if (is_array($postFields) && count($postFields) > 0) {
            $postBodyString = '';
            $postMultipart  = false;

            foreach ($postFields as $k => $v) {
                if (is_array($v)) {
                    throw new \Exception('input param is error');
                }

                if (strpos($v, '@') === 0) {
                    $postMultipart = true;
                    if (class_exists('\CURLFile')) {
                        $postFields[$k] = new \CURLFile(substr($v, 1), '', '');
                    }
                } else {
                    $postBodyString .= urlencode($k) . '=' . urlencode($v) . '&';
                }
            }

            curl_setopt($ch, CURLOPT_POST, true);
            if ($postMultipart) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            } else {
                $header = ['content-type: application/x-www-form-urlencoded; charset=UTF-8'];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
            }
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch), 0);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                throw new \Exception($response, $httpStatusCode);
            }
        }

        curl_close($ch);

        return $response;
    }


    protected function logError($place, $requestUrl, $errorCode, $errorMsg): void
    {
        $localIp = $_SERVER['SERVER_ADDR'] ?? 'CLI';
        $logData = [
            'appKey'      => $this->appKey,
            'ip'          => $localIp,
            'php_os'      => PHP_OS,
            'api_version' => $this->apiVersion,
            'request_url' => $requestUrl,
            'error_code'  => $errorCode,
            'error_msg'   => $errorMsg,
        ];

        Log::channel($this->logChannel)->info('万里牛报错:' . $place, $logData);
    }

    protected function logResult($requestUrl, $curlParams, $result): void
    {
        if (!$this->isLogResult) {
            return;
        }

        Log::channel($this->logChannel)->info('万里牛请求结果:' . $requestUrl, ['curl_params' => $curlParams, 'respond'=>$result]);
    }

    /**
     * 执行
     *
     * @param string $request 接口路由
     * @param array  $params  接口参数
     * @param string $method  请求方法
     * @param bool   $isOpen  是否为开放接口，B2c的接口，填写 false
     *
     * @return mixed
     * * @throws HttpException
     * @throws HttpException
     * @throws RespondException
     */
    public function execute(string $request, array $params, $method = 'post', $isOpen = true)
    {
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $params[$key] = json_encode($value,JSON_UNESCAPED_UNICODE);
            }
        }

        $apiParams = $params;

        if ($isOpen) {
            $requestMethod = ltrim($request, '/');

            // 组装系统参数
            $sysParams['_app'] = $this->appKey;
            $sysParams['_s']   = '';
            $sysParams['_t']   = $this->getMillisecond();

            // 签名
            $sysParams['_sign'] = $this->generateSign(array_merge($sysParams, $apiParams), true);
        } else {
            //切换配置
            $this->useConfig('b2c');
            $requestMethod = $this->apiVersion . $request;

            // 组装系统参数
            $sysParams['app_key']   = $this->appKey;
            $sysParams['format']    = $this->format;
            $sysParams['timestamp'] = $this->getMillisecond();

            // 签名
            $sysParams['sign'] = $this->generateSign(array_merge($sysParams, $apiParams));
        }

        $requestUrl  = $this->gatewayUrl . '/' . $requestMethod . '?';
        $mergeParams = array_merge($sysParams, $apiParams);
        ksort($mergeParams);
        foreach ($mergeParams as $key => $value) {
            if ('get' === $method) {
                $requestUrl .= urlencode($key) . '=' . urlencode($value) . '&';
            }
        }
        $curlParams = $mergeParams;
        $requestUrl = substr($requestUrl, 0, -1);

        // 发起 HTTP 请求
        try {
            if ('get' === $method) {
                $resp = $this->curl($requestUrl);
            } else {
                $resp = $this->curl($requestUrl, $curlParams);
            }
        } catch (\Exception $e) {
            $this->logError('发请求', $requestUrl, 'HTTP_ERROR_' . $e->getCode(), $e->getMessage());

            throw new HttpException('万里牛接口发请求报错：' . $e->getMessage(), $e->getCode());
        }

        // 解析 HUPUN 返回结果
        $res = json_decode($resp, true);
        if (!$res && JSON_ERROR_NONE === json_last_error()) {
            $this->logError('响应体', $requestUrl, 'HTTP_RESPONSE_NOT_WELL_FORMED', $resp);

            throw new RespondException('万里牛接口响应体有误：');
        }

        //转义
        if (isset($res['response']) && !empty($res['response'])) {
            $res['response'] = json_decode($res['response'], true);
        }

        $this->logResult($requestUrl, $curlParams, $res);

        return $res;
    }

    public function getMillisecond(): int
    {
        [$microFirst, $microSecond] = explode(' ', microtime());

        return (int)sprintf('%.0f', ((float)$microFirst + (float)$microSecond) * 1000);
    }
}
