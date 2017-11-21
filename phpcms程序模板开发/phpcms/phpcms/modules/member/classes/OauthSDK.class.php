<?php
if (! function_exists('curl_init')) {
    throw new Exception('Snda needs the CURL PHP extension.');
}
if (! function_exists('json_decode')) {
    throw new Exception('Snda needs the JSON PHP extension.');
}

class OauthSDK
{
    /** 
     * Contains the last HTTP status code returned.  
     * 
     * @ignore 
     */
    public $http_code;
    /** 
     * Contains the last API call. 
     * 
     * @ignore 
     */
    public $url;
    /** 
     * Set timeout default. 
     * 
     * @ignore 
     */
    public $timeout = 30;
    /**  
     * Set connect timeout. 
     * 
     * @ignore 
     */
    public $connecttimeout = 30;
    /** 
     * Verify SSL Cert. 
     * 
     * @ignore 
     */
    public $ssl_verifypeer = FALSE;
    /** 
     * Respons format. 
     * 
     * @ignore 
     */
    public $format = 'json';
    /** 
     * Decode returned json data. 
     * 
     * @ignore 
     */
    public $decode_json = TRUE;
    /** 
     * Contains the last HTTP headers returned. 
     * 
     * @ignore 
     */
    public $http_info;
    /** 
     * Set the useragnet. 
     * 
     * @ignore 
     */
    public $useragent = 'SNDA OAuth 2.0';
    /* Immediately retry the API call if the response was not successful. */
    //public $retry = TRUE; 
    

    /**
     * The Application ID.
     */
    protected $appId;
    
    /**
     * The Application API Secret.
     */
    protected $appSecret;
    
    /**
     * app callback url
     */
    protected $redirectURI;
    
    protected $lastErrorCode;
    protected $lastErrorMsg;
    
    protected $systemParam = array(
        'connectTimeout' => 5 , 
        'timeout' => 3 , 
        'gatewayUrl' => 'http://api.snda.com' , 
        'authorizeURL' => 'http://oauth.snda.com/oauth/authorize' , 
        'accessTokenURL' => 'http://oauth.snda.com/oauth/token' , 
        'systemTokenURL' => 'http://oauth.snda.com/oauth/token' , 
        'gatewayHost' => 'api.snda.com' , 
        'gatewayPort' => 8888
    );
    
    protected $params = array();
    
    private $oauth_debug = FALSE;
    private $apiStartTime = 0;
    private $apiStopTime = 0;
    private $execTime = 0;
    
    /**
     * User Authorization url
     */
    function authorizeURL ()
    {
        return $this->systemParam['authorizeURL'];
    }
    
    /**
     * Get User Authorization url
     */
    function accessTokenURL ()
    {
        return $this->systemParam['accessTokenURL'];
    }
    
    /**
     * Get System Authorization url
     */
    function systemTokenURL ()
    {
        return $this->systemParam['systemTokenURL'];
    }
    
    /**
     *  ApiPool GateWay Url
     */
    function apiPoolURL ()
    {
        return $this->systemParam['gatewayUrl'];
    }
    
    function __construct ($apiKey, $appSecret, $redirectURI)
    {
        
        $this->appId = $apiKey;
        
        $this->appSecret = $appSecret;
        
        $this->redirectURI = $redirectURI;
    
    }
    
    function setOption ($key, $value)
    {
        $this->systemParam[$key] = $value;
    }
    
    /**
     * Set the Application ID.
     *
     * @param String $appId the Application ID
     */
    public function setAppId ($appId)
    {
        $this->appId = $appId;
    }
    
    /**
     * Get the Application ID.
     *
     * @return String the Application ID
     */
    public function getAppId ()
    {
        return $this->appId;
    }
    
    public function setRedirectURI ($redirectURI)
    {
        $this->redirectURI = $redirectURI;
    }
    
    public function getRedirectURI ()
    {
        return $this->redirectURI;
    }
    
    /**
     * Set the API Secret.
     *
     * @param String $appId the API Secret
     */
    public function setApiSecret ($apiSecret)
    {
        $this->apiSecret = $apiSecret;
    }
    
    /**
     * Get the API Secret.
     *
     * @return String the API Secret
     */
    public function getApiSecret ()
    {
        return $this->apiSecret;
    }
    
    //Get accesstoken
    public function getAccessToken ($code)
    {
        $this->_clearError();
        $clientID = $this->appId;
        $redirectURI = $this->redirectURI;
        $clientSecret = $this->appSecret;
        $accessTokenURL = self::accessTokenURL();
        $url = "{$accessTokenURL}?code={$code}&client_id={$clientID}&client_secret={$clientSecret}&redirect_uri={$redirectURI}";
        
        $result = self::http($url);
        $access_token = json_decode($result, TRUE);
        if (empty($access_token) || isset($access_token['error'])) {
            $this->_setOAuthError($access_token);
            return FALSE;
        } else {
            return $access_token;
        }
    }
    
    //Generate User Authorization url
    public function getAuthorizeURL ()
    {
        $clientID = $this->appId;
        $redirectURI = $this->redirectURI;
        $authorizeURL = self::authorizeURL();
        return "{$authorizeURL}?response_type=code&client_id={$clientID}&redirect_uri={$redirectURI}";
    }
    
    //Generate System Authorization  token
    public function getSystemToken ()
    {
        $this->_clearError();
        
        $clientID = $this->appId;
        $redirectURI = $this->redirectURI;
        $clientSecret = $this->appSecret;
        $accessTokenURL = self::accessTokenURL();
        $url = "{$accessTokenURL}?grant_type=client_credentials&client_id={$clientID}&client_secret={$clientSecret}";
        
        $result = self::http($url);
        $access_token = json_decode($result, TRUE);
        if (empty($access_token) || isset($access_token['error'])) {
            $this->_setOAuthError($access_token);
            return FALSE;
        } else {
            return $access_token;
        }
    }
    
    public static function generate_nonce ()
    {
        $mt = microtime();
        $rand = mt_rand();
        
        return md5($mt . $rand); // md5s look nicer than numbers 
    }
    
    /**
     * request apipool
     */
    public function request ($method = 'TCP')
    {
        static $tcpField = array(
            'method' => 1 , 
            'oauth_consumer_key' => 1 , 
            'oauth_token' => 1 , 
            'oauth_nonce' => 1 , 
            'oauth_timestamp' => 1 , 
            'oauth_version' => 1 , 
            'oauth_signature_method' => 1 , 
            'oauth_signature' => 1 , 
            'call_id' => 1 , 
            'version' => 1
        );
        
        $this->_clearError();
        $param = $this->params;
        $this->params = array();
        
        $url = self::apiPoolURL();
        
        $parameters['oauth_token'] = 'null';
        $parameters['oauth_consumer_key'] = $this->appId;
        $parameters['oauth_nonce'] = self::generate_nonce();
        $parameters['oauth_timestamp'] = (string) time();
        $parameters['oauth_version'] = '2.0';
        $parameters['oauth_signature_method'] = 'HMAC-SHA1';
        
        if ($method == 'TCP') {
            $parameters['call_id'] = 0;
        }
        
        // data merging
        foreach ($parameters as $key => $value) {
            if (! isset($param[$key])) {
                $param[$key] = $parameters[$key];
            }
        }
        if ($method == 'TCP') {
            $tcpParams = array();
            foreach ($param as $key => $value) {
                if (! isset($tcpField[$key])) {
                    $tcpParams[$key] = $value;
                    unset($param[$key]);
                }
            }
            $param['params'] = $tcpParams;
        }
        
        if (! isset($param['oauth_signature'])) {
            $param['oauth_signature'] = self::generateSig($param);
        }
        
        $result = '';
        
        if ($this->oauth_debug) {
            $this->apiStart();
        }
        switch ($method) {
            case 'TCP':
                $result = self::tcp($param);
                break;
            case 'GET':
                $url = $url . '?' . http_build_query($param);
                $result = self::http($url, $method);
                break;
            
            case 'POST':
                $postdata = http_build_query($param);
                $result = self::http($url, $method, $postdata);
                break;
            
            default:
                return FALSE;
                break;
        }
        
        if ($this->oauth_debug) {
            $this->apiStop();
            $this->apiSpent($this->appId, $param['method']);
        }
        
        $result = json_decode($result, TRUE);
        if (empty($result)) {
            $this->_setGWError();
            return FALSE;
        }
        
        $response = array();
        if ($method == 'TCP') {
            $response = $result['response'];
        } else {
            $response = $result;
        }
        //check error
        if (! isset($response['return_code']) || $response['return_code'] != 0) {
            $this->_setGWError($response);
            return FALSE;
        }
        return $response;
    }
    
    private function generateSig ($params, $secret = '')
    {
        if (empty($secret)) {
            $secret = $this->appSecret;
        }
        $str = '';
        ksort($params);
        foreach ($params as $k => $v) {
            if (! is_array($v)) {
                $str .= "$k=$v";
            } else {
                ksort($v);
                $str .= "$k=" . json_encode($v);
            }
        }
        return bin2hex(hash_hmac('sha1', $str, $secret, TRUE));
    }
    
    public function setParam ($key, $value)
    {
        $this->params[$key] = $value;
    }
    
    public function tcp ($param)
    {
        $sock = socket_create(AF_INET, SOCK_STREAM, 0);
        if (FALSE === $sock) {
            return FALSE;
        }
        
        socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array(
            'sec' => $this->systemParam['timeout'] , 
            'usec' => 0
        ));
        socket_set_option($sock, SOL_SOCKET, SO_SNDTIMEO, array(
            'sec' => $this->systemParam['timeout'] , 
            'usec' => 0
        ));
        
        $result = socket_connect($sock, $this->systemParam['gatewayHost'], $this->systemParam['gatewayPort']);
        if (FALSE === $result) {
            socket_close($sock);
            return FALSE;
        }
        
        $data = json_encode($param);
        $len = dechex(strlen($data));
        $data = sprintf('%06s%s', $len, $data);
        
        $result = socket_write($sock, $data);
        if (FALSE === $sock) {
            socket_close($sock);
            return FALSE;
        }
        
        $data = socket_read($sock, 6);
        if (FALSE === $data) {
            socket_close($sock);
            return FALSE;
        }
        
        $len = hexdec($data);
        $data = socket_read($sock, $len);
        if (FALSE === $data) {
            socket_close($sock);
            return FALSE;
        }
        
        socket_close($sock);
        return $data;
    }
    
    /** 
     * Make an HTTP request 
     * 
     * @return string API results 
     */
    public function http ($url, $method = 'GET', $postfields = FALSE)
    {
        $this->http_info = array();
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->systemParam['connectTimeout']);
        curl_setopt($ci, CURLOPT_TIMEOUT, $this->systemParam['timeout']);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
        curl_setopt($ci, CURLOPT_HEADERFUNCTION, array(
            $this , 
            'getHeader'
        ));
        curl_setopt($ci, CURLOPT_HEADER, FALSE);
        
        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, TRUE);
                if (! empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                    //echo "=====post data======\r\n";
                //echo $postfields;
                }
                break;
            case 'DELETE':
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (! empty($postfields)) {
                    $url = "{$url}?{$postfields}";
                }
                break;
        }
        
        $header_array = array();
        $header_array2 = array();
        foreach ($header_array as $k => $v)
            array_push($header_array2, $k . ': ' . $v);
        
        curl_setopt($ci, CURLOPT_HTTPHEADER, $header_array2);
        curl_setopt($ci, CURLINFO_HEADER_OUT, FALSE);
        
        //echo $url."<hr/>"; 
        

        curl_setopt($ci, CURLOPT_URL, $url);
        
        $response = curl_exec($ci);
        $this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $this->http_info = array_merge($this->http_info, curl_getinfo($ci));
        $this->url = $url;
        curl_close($ci);
        return $response;
    }
    
    /** 
     * Get the header info to store. 
     * 
     * @return int 
     */
    public function getHeader ($ch, $header)
    {
        $i = strpos($header, ':');
        if (! empty($i)) {
            $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
            $value = trim(substr($header, $i + 2));
            $this->http_header[$key] = $value;
        }
        return strlen($header);
    }
    
    private function _setOAuthError ($err = null)
    {
        if (empty($err)) {
            $this->lastErrorCode = 'unknow';
            $this->lastErrorMsg = 'unkonw';
        } else {
            $this->lastErrorCode = @$err['error'];
            $this->lastErrorMsg = @$err['error_description'];
        }
    }
    
    private function _setGWError ($response = null)
    {
        if (empty($response)) {
            $this->lastErrorCode = 'unknow';
            $this->lastErrorMsg = 'unkonw';
        } else {
            $this->lastErrorCode = @$response['return_code'];
            $this->lastErrorMsg = @$response['return_message'];
        }
    }
    
    private function _clearError ()
    {
        $this->lastErrorCode = 0;
        $this->lastErrorMsg = '';
    }
    
    public function getLastErrCode ()
    {
        return $this->lastErrorCode;
    }
    
    public function getLastErrMsg ()
    {
        return $this->lastErrorMsg;
    }
    
    public function getExecTime ()
    {
        return $this->execTime;
    }
    
    private function apiStart ()
    {
        $this->apiStartTime = microtime(TRUE);
    }
    
    private function apiStop ()
    {
        $this->apiStopTime = microtime(TRUE);
    }
    
    private function apiSpent ($appid, $api)
    {
        $url = 'http://log.ibw.sdo.com/apipool.jpg?';
        $spent = round(($this->apiStopTime - $this->apiStartTime) * 1000, 1);
        $this->execTime = $spent;
        $params = array();
        $params['appid'] = $appid;
        $params['api'] = $api;
        $params['time'] = $spent;
        $url .= http_build_query($params);
        @file_get_contents($url);
    }

}
?>
