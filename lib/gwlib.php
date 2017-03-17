<?php

class gw {
    public $host;
    public $port;
    public $gwadmin;
    public $gwpass;
    public $baseurl;

    public function __construct($appdir) {
        $db = new SQLite3($appdir . '/db/config.db') or die("Unable to open DB");
        $result = $db->query('SELECT * FROM gw');
        While ($row = $result->fetchArray())
        {
            $this->gwhost = "{$row['GWHOST']}";
            $this->gwport = "{$row['GWPORT']}";
            $this->gwadmin = "{$row['GWADMIN']}";
            $this->gwpass = "{$row['GWPASS']}";
        }
        $this->baseurl = "https://$this->gwhost:$this->gwport";
        $db->close();
    }

    function checkLdap($po){
        $url = $this->baseurl . "/gwadmin-service/list/post_office?name=" . $po;
        $podata = $this->gwGet($url);
                if ($podata[0]['securitySettings'][1] == 'LDAP') {
            return 1;
        }
        else {
            return 0;
        }
    }
	
	function getUsers($gwid){
            $url = $this->baseurl . "/gwadmin-service/system/search?text=" . $gwid;
	    $userdata = $this->gwGet($url);
		foreach($userdata as $user) {
                    $userUrl = $this->baseurl . $user['@url'];
                    $data = $this->gwGet($userUrl);
                    if (strpos($user['id'], 'USER') !== false){
                        if ($data['externalRecord'] != 'true') {
                            $userlist[] = $data;
                        }
                    }
                }
		return $userlist;
	}

    function gwGet($uri) {
        $opts = array(
            CURLOPT_HTTPHEADER => array(
                'Content-type: application/json',
                'Accept: application/json'
                ),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 1,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => "$this->gwadmin:$this->gwpass",
            CURLOPT_CONNECTTIMEOUT_MS => 5000,
            CURLOPT_TIMEOUT => 5000,
            CURLOPT_SSL_VERIFYPEER => FALSE
            );

        $curl = curl_init($uri);
        curl_setopt_array($curl, $opts);
        $results = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($results, 0, $header_size);
        $body = substr($results, $header_size);
        $data = json_decode($body, true);
		if(isset($data['object'])){
            return $data['object'];
        }
		elseif(isset($data['name'])){
			return $data;
		}
        else{
			
			return 1;
        }
    }

    function changePwd($uri, $pwd){
        $url = $this->baseurl . $uri . "/clientoptions";
        $value['value'] = $pwd;
        $data['userPassword'] = $value;
        $options = array(
        CURLOPT_HTTPHEADER => array(
            'Content-type: application/json',
            'Accept: application/json'
            ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => "$this->gwadmin:$this->gwpass",
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_HEADER => 1,
        );
        $uch = curl_init($url);
        curl_setopt_array($uch, $options);
        curl_setopt($uch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($uch,CURLOPT_POSTFIELDS, json_encode($data));
        $results = curl_exec($uch);
        if (strpos($results, "200 OK") == true) {
            return 0;
        }
        else {
            return 1;
        }
    }
        
    function login() {

        $opts = array(
            CURLOPT_HTTPHEADER => array(
                'Content-type: application/json',
                'Accept: application/json'
                ),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 1,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => "$this->gwadmin:$this->gwpass",
            CURLOPT_CONNECTTIMEOUT_MS => 5000,
            CURLOPT_TIMEOUT => 5000,
            CURLOPT_SSL_VERIFYPEER => FALSE
            );
		
        $loginurl = "$this->baseurl/gwadmin-service/system/whoami";
        $curl = curl_init($loginurl);
        curl_setopt_array($curl, $opts);
        $results = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($results, 0, $header_size);
        $body = substr($results, $header_size);
        $data = json_decode($body, true);
        if(curl_errno($curl) OR in_array("error",$data)) {
            if (curl_errno($curl) == 3) {
            }
            else {
                return 1;
                session_unset();
            }
        }
        foreach (range(0, count($data['roles']) -1)  as $i) {
            $roles = $data['roles'];
            if (in_array('SYSTEM_RECORD', $roles) !== false) {
                return 0;
            }
            else {
                return 1;
            }
        }
    }
}

?>
