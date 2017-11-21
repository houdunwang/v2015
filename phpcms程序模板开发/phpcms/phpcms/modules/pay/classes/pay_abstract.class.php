<?php
abstract class paymentabstract
{
	protected $config = array();
	protected $product_info = array();
	protected $customter_info = array();
	protected $order_info = array();
	protected $shipping_info = array();

	public function set_config($config)
	{
		foreach ($config as $key => $value) $this->config[$key] = $value;
		return $this;
	}

	public function set_productinfo($product_info)
	{
		$this->product_info = $product_info;
		return $this;
	}

	public function set_customerinfo($customer_info)
	{
		$this->customer_info = $customer_info;
		return $this;
	}

	public function set_orderinfo($order_info)
	{
		$this->order_info = $order_info;
		return $this;
	}

	public function set_shippinginfo($shipping_info)
	{
		$this->shipping_info = $shipping_info;
		return $this;
	}

	public function get_code($button_attr = '')
	{
		if (strtoupper($this->config['gateway_method']) == 'POST') $str = '<form action="' . $this->config['gateway_url'] . '" method="POST" target="_blank">';
		else $str = '<form action="' . $this->config['gateway_url'] . '" method="GET" target="_blank">';
		$prepare_data = $this->getpreparedata();
		foreach ($prepare_data as $key => $value) $str .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
		$str .= '<input type="submit" ' . $button_attr . ' />';
		$str .= '</form>';
		return $str;
	}

	protected function get_verify($url,$time_out = "60") {
        $urlarr     = parse_url($url);
        $errno      = "";
        $errstr     = "";
        $transports = "";
        if($urlarr["scheme"] == "https") {
            $transports = "ssl://";
            $urlarr["port"] = "443";
        } else {
            $transports = "tcp://";
            $urlarr["port"] = "80";
        }
        $fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
        if(!$fp) {
            die("ERROR: $errno - $errstr<br />\n");
        } else {
            fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
            fputs($fp, "Host: ".$urlarr["host"]."\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $urlarr["query"] . "\r\n\r\n");
            while(!feof($fp)) {
                $info[]=@fgets($fp, 1024);
            }
            fclose($fp);
            $info = implode(",",$info);
            return $info;
        }
    }


	abstract public function receive();

	abstract public function notify();

	abstract public function response($result);

	abstract public function getPrepareData();
}