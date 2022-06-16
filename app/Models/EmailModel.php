<?php namespace App\Models;

class EmailModel extends Model{

    function EmailModel(){
        parent::Model();
        $this->load->library('email');
       }



    function sendVerificationEmail(){
        $email = \Config\Services::email();
    
        
        $this->$email->set_newline("\r\n");
        $this->$email->from('admin@yourdomain.com', "Admin Team");
        $this->$email->to('nadeemsani786@gmail.com');  
        $this->$email->subject("Email Verification");
        $this->$email->message("Dear User,\nPlease click on below URL or paste into your browser to verify your Email Address\n\n http://www.yourdomain.com/verify/".$verificationText."\n"."\n\nThanks\nAdmin Team");
        $this->$email->send();
       }
}
?>