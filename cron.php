<?php

  
        $from_email = 'info@requiro.co'; //change this to yours
      
        $this->load->library('email');
			    $config['protocol'] = 'smtp';
                $config['smtp_crypto'] = 'ssl';
                $config['smtp_host'] = 'mail.requiro.co';
                $config['smtp_port'] = '465';
                $config['smtp_user'] = $from_email;
                $config['smtp_pass'] = 'inforequiro';
                $config['mailtype'] = 'html';
                $config['charset'] = 'utf-8';
                $config['newline'] = "\r\n";
                $config['wordwrap'] = TRUE;
                $config['smtp_timeout'] = 30;
                $this->email->initialize($config);
                $this->email->from($from_email, 'Car Rental');
                $this->email->to('arpitpanchal02@gmail.com');
                $this->email->subject('hi');
                $this->email->message('test');
                return $this->email->send();
  

?>