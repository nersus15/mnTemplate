<!-- DEFAULT LIBRAY FOR LOGIN, LOGOUT, REGISTER -->
<?php
    class auth_lib {
        private $db, $tabel_profile, $tabel_user, $pakai_login_email;
    
        function _init_($tabel_user, $tabel_profile = null, $pakai_login_email = false)
        {            
            $this->db = new qbuilder();
            $this->tabel_profile = $tabel_profile;
            $this->tabel_user = $tabel_user;
            $this->pakai_login_email = $pakai_login_email;
        }
        function prepare($post, $func = "login", $config_form = 'login'){
            $new_input = [];
            if(empty($config_form))
                return $post;

            $input = fieldmapping($post, $config_form);
            switch($func){
                case "login":
                    // Sanitasi data login
                break;
                case "register":
                    // Sanitasi data registrasi
                break;
            }

            return $new_input;
        }

        function login($input){
            $query = $this->db->select('*')
                ->from($this->tabel_user)
                ->where($this->tabel_user . ".username", $input['user']);
            
            if(!empty($this->tabel_profile))
                $query->join($this->tabel_profile, $this->tabel_profile . ".username = " . $this->tabel_user . ".username");

            if($this->pakai_login_email)
                $query->or_where($this->tabel_profile . ".email", $input['user']);
            
            $data = $query->result_object();
            if(empty($data))
                response("Username " . $this->pakai_login_email ? "/ Email" : null . $input['user'] . " Tidak Ditemukan", 403);
            if(count($data) > 1)
                response("Username tidak valid", 403);

            $data = $data[0];
            if(password_verify($input['password'], $data->password)){
                unset($data->password);
                set_userdata("login", $data);
                response("Login Berhasil");
            }else
                response("Password Untuk " . $input['username'] . " Salah", 403);

        }

        function register($input){
            try {
                $this->db->insert($this->tabel_user, $input);
                response("Berhasil Register");
            } catch (\Throwable $th) {
                response(["status" => "Register Gagaal", "err" => $th], 403);
            }
        }

        function logout(){
            unset_userdata("login");
        }
    }