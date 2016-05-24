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
        $this->mail->SMTPSecure   = "ssl";           
        $this->mail->Host       = "stu.cqupt.edu.cn";      
        $this->mail->Port       = 465;                   
        $this->mail->Username       = '2013212075@stu.cqupt.edu.cn'; 
        $this->mail->Password       = 'uuu-4BF-ZwY-tfA';                   
        $this->mail->SetFrom('2013212075@stu.cqupt.edu.cn', 'ibi');
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
