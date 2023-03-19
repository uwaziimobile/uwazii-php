<?php
namespace Uwazii;
class UwaziiClient{
    private $username;
    private $password;
    private $auth_code;
    private $access_token;
    private $api_authorize_path = "https://restapi.uwaziimobile.com/v1/authorize";
    private $api_access_token_path = "https://restapi.uwaziimobile.com/v1/accesstoken";
    private $send_message_path = "https://restapi.uwaziimobile.com/v1/send";

    // constructor
    public function __construct(){}
    
    /*** Send a message
        Method - POST
        Params - Access token, senderid, phone = array(), message
    ***/
    public function sendMessage($token,$from,$phone,$message){
        if($token != $this->access_token){
            throw new Exception('Invalid access token');
        }
    	$data = json_encode(array (
            array (
                'number' => array($phone),
                'senderID' => $from,
                'text' => $message,
                'type' => 'sms'
            ),
        ));
    
        $url = $this->send_message_path;
        $curl = curl_init($url); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $headers = array();
        $headers[] = "Content-Type: application/json";
        $headers[] = "X-Access-Token: ".$token;  
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /*** Get authorization token
        No Params
    ***/
    private function authorize(){
        $response = $this->curl_request('auth_code');
        $result = json_decode($response,true);

        if(array_key_exists('error_code', $result)){
            $error_message = "";
            $errors = $result['errors'];
            foreach ($errors as $key => $value) {
                $error_message .= $value[0]. ' ';
            }
            throw new Exception($error_message);
        }
      
        $auth_code = trim($result['data']['authorization_code']);
        return $auth_code;
           
    }
    /*** Get access token
        Params -USERNAME, PASSWORD
        Returns access token
    ***/
    public function accessToken($username,$password){
        $this->username = $username;
        $this->password = $password;

        try{
           $this->auth_code = $this->authorize(); 
        }
        catch(Exception $e){
            return $e->getMessage();
        }
        
        $response = $this->curl_request('access_token');
        $result = json_decode($response,true);

        if(array_key_exists('error_code', $result)){
            $error_message = "";
            $errors = $result['errors'];
            throw new Exception($errors);
        }
        
        $access_token = trim($result['data']['access_token']);
        $this->access_token = $access_token;
        return $access_token;   
    }
    private function curl_request($function,$parameters=array(),$resource_id=''){
        $curl_handle = curl_init();
        switch($function){
            case 'auth_code':
                curl_setopt($curl_handle, CURLOPT_URL, $this->api_authorize_path);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_POST, 1);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS,
                    json_encode(
                        array(
                            'username' => $this->username,'password' => $this->password
                        )
                    )
                );
                break;
            case 'access_token':
                curl_setopt($curl_handle, CURLOPT_URL, $this->api_access_token_path);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_POST, 1);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS,
                    json_encode(
                        array('authorization_code' => $this->auth_code)
                    )
                );
                break;
            
            default:
                return 'Method not given';
        }  
        $headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($curl_handle);
		if (curl_errno($curl_handle)) {
		    return 'Error:' . curl_error($curl_handle);
		}
        $output = curl_exec($curl_handle);
        curl_close($curl_handle); 
        return $output;
    } 
}
?>