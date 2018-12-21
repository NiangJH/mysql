<?php
class Curl
{
    private static $_obj;
    private $ch;

    private function __construct() {
        $this->ch = curl_init();
    }
    
    public function __destruct() {
        curl_close($this->ch);
    }

    private function __clone() {}

    public static function &Instance() {
        if(is_null(self::$_obj))
            self::$_obj = new Curl();
        return self::$_obj;
    }

	public function reset(){
		curl_reset($this->ch);
	}

    public function get($url,&$outContent,$timeout,$header) {
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        if(isset($header)) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
        }

		$outContent = curl_exec($this->ch);
		return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
    }

    public function post($url,&$outContent,$timeout,$data,$header) {
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        if(isset($header)) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
        }
		if (isset($data)) {
			curl_setopt($this->ch, CURLOPT_POST, 1);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        }
        
		$outContent = curl_exec($this->ch);
		return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
    }

}
?>