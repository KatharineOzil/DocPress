<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Mailer {
    var $mail;

    public function __construct()
    {
        require_once('phpmailer/class.phpmailer.php');

        // the true param means it will throw exceptions on errors, which we need to catch
        $this->mail = new PHPMailer(true);

        $this->mail->IsSMTP(); // telling the class to use SMTP

        $this->mail->CharSet = "utf-8";
        $this->mail->SMTPDebug  = 0;
        $this->mail->SMTPAuth   = true;
        //$this->mail->SMTPSecure   = "ssl";
        $this->mail->Host       = "";
        $this->mail->Port       = 25;
        $this->mail->Username       = '';
        $this->mail->Password       = '';
        //$this->mail->SetFrom('test@mail.com', 'test');
    }

    public function sendmail($to, $to_name, $subject, $body){
        try{
            $this->mail->AddAddress($to, $to_name);

            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;

            $this->mail->Send();
        } catch (phpmailerException $e) {
		echo $e;
        } catch (Exception $e) {
		echo $e;
        }
    }
}

/* End of file mailer.php */
