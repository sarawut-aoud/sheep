<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// สำหรับส่งอีเมลผ่านบริการของ Gmail

$config = array(

                    'protocol'  => 'smtp',

                    'smtp_host' => 'ssl://smtp.googlemail.com',

                    'smtp_port' => 465,

                    'smtp_user' => 'xxxxxx@gmail.com',//Your Gmail 

                    'smtp_pass' => 'xxxxxxxxxxxx',//Your Gmail Password

                    'mailtype'  => 'html',

                    'charset'   => 'utf-8',

					'from_mail' => 'xxxxxx@gmail.com',

					'from_name' => 'YOUR NAME'

                );

?>