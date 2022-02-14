<?php
    use Firebase\JWT\JWT;

    class Token {
    private $used_token = [];
    private $jwt;
        public function __construct() {
            require_once DEPENDENCIES_PATH . "firebase". DIRECTORY_SEPARATOR ."php-jwt". DIRECTORY_SEPARATOR ."src". DIRECTORY_SEPARATOR ."JWT.php";
            require_once DEPENDENCIES_PATH . "firebase". DIRECTORY_SEPARATOR ."php-jwt". DIRECTORY_SEPARATOR ."src". DIRECTORY_SEPARATOR ."SignatureInvalidException.php";
            require_once DEPENDENCIES_PATH . "firebase". DIRECTORY_SEPARATOR ."php-jwt". DIRECTORY_SEPARATOR ."src". DIRECTORY_SEPARATOR ."BeforeValidException.php";
            require_once DEPENDENCIES_PATH . "firebase". DIRECTORY_SEPARATOR ."php-jwt". DIRECTORY_SEPARATOR ."src". DIRECTORY_SEPARATOR ."ExpiredException.php";
            $this->jwt = new JWT;
        }
        function encode($key, $data, $alg = "HS256"){
            $tipe = gettype($data);
            if($tipe == 'array')
                $data['data_payload_type'] = $tipe;
            else    
                $data->data_payload_type = $tipe;
                
            $token = $this->jwt->encode($data, $key, $alg);
            return $token;
        }

        function decode($token, $key, $allowed_alg = ["HS256"]){
            $data = null;
            try {
                $data = $this->jwt->decode($token, $key, $allowed_alg);
                if(isset($data->data_payload_type)){
                    switch($data->data_payload_type){
                        case "array":
                            $data = (array) $data;
                            unset($data['data_payload_type']);
                        break;
                        case "object":
                            $data = (object) $data;
                            unset($data->data_payload_type);
                        break;
                    }
                }
            } catch (\Throwable $th) {
                return false;
            }

            return $data;            
        }

        function minta_token($id){            
            $token_akses = random(15);
            // TODO LOAD DATA AND STORE TO SESSION [$token_akses => $jwt->encode($data)]
            $data = array("waktu_akses" => waktu(), 'idakses' => $id);
            set_userdata("_wrapped_data_", array($token_akses => $this->encode("_formtoken_", $data)));
            return $token_akses;
        }
    }