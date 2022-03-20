<?php
class commonHook
{
    function formProtected(array $post)
    {
        if (SECURE_FORM) {
            $tokens = get_userdata("_token_");
            if($tokens === null) $tokens = [];
            $token = null;
            $valid = false;
            if (empty($post))
                response("JIKA MENGAKTIFKAN SECURE_FORM MAKA FORM HANYA BOLEH DIAKSES JIKA ADA TOKEN", 400);
            
                // foreach($post as $key => $p){
            //     var_dump($key);
            //     var_dump(password_verify("_token_", '$2y$10$TjXr3aajBzLVdYTs2bXkV_l2j93sD30Egdh5bhLzVrJXc4Q4b5Quq'));
            //     if(password_verify("_token_", $key)){
            //         $valid = true;
            //         $token = $p;
            //     }
            //     // if()
            // }
           

            if (/* !$valid */!isset($post[sandi('_token_')]))
                response("JIKA MENGAKTIFKAN SECURE_FORM MAKA FORM HANYA BOLEH DIAKSES JIKA ADA TOKEN", 400);
            else {
                $token = $post[sandi('_token_')];
                if(in_array($token, $tokens))
                    response("TOKEN SUDAH DIGUNAKAN", 400);
                $wrapped_data = get_userdata("_wrapped_data_");
                $form_data = $wrapped_data[$token];
                $jwt = new Token;
                if(empty($form_data) || !$jwt->decode($form_data, '_formtoken_'))
                    response("TOKEN INVALID");

                if (empty($tokens))
                    set_userdata("_token_", array($token));
                else {
                    $tokens[] = $token ;
                    set_userdata("_token_", $tokens);
                }
            }
        }
    }
}
