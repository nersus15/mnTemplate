<?php
class commonHook
{
    function formProtected(array $post)
    {
        if (SECURE_FORM) {
            $tokens = get_userdata("_token_");
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
           

            if (/* !$valid */!isset($post['_token_']))
                response("JIKA MENGAKTIFKAN SECURE_FORM MAKA FORM HANYA BOLEH DIAKSES JIKA ADA TOKEN", 400);
            else {
                $token = $post['_token_'];
                if(in_array($token, $tokens))
                    response("TOKEN SUDAH DIGUNAKAN", 400);
                $wrapped_data = get_userdata("_wrapped_data_");
                $form_data = $wrapped_data[$post['_token_']];
                $jwt = new Token;
                if(!$jwt->decode($form_data . 'ada', '_formtoken_'))
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
