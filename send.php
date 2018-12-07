<?php

function validateTypes($type='', $text='') {
	if($type=='email'){
		$v = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
		return preg_match($v, $text)===1;
	}elseif($type=='txt'){
		if(trim($text)){
			return true;
		}else{
			return false;
		}
	}elseif($type=='country'){
		if(($text>1&&$text<=250)){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function mailsend($txt='', $header='' , $mail='danielopic@gmail.com'){
        // Naglowki mozna sformatowac tez w ten sposob.
        $naglowki = "From: Geek Factory <info@geekfactory.pl>".PHP_EOL;
        $naglowki .= "MIME-Version: 1.0".PHP_EOL;
        $naglowki .= "Content-type: text/html; charset=utf-8".PHP_EOL; 

        //Wiadomość najczęściej jest generowana przed wywołaniem funkcji
        $wiadomosc = '<html> 
        <head> 
           <title>'.$header.'</title> 
        </head>
        <body>
           '.$txt.'
        </body>
        </html>';
        if(!$header){
            $header='No title';
        }

        return mail($mail, $header, $wiadomosc, $naglowki, 'info@geekfactory.pl');
        
}

	$errors = array();
        
	$name = trim($_POST['name']);
	$email = trim($_POST['email']);
	$text  = trim($_POST['text']);


	if(!validateTypes('txt', $name)){
		$errors['name'] = 'Prosze podać imię';
	}
	if(!validateTypes('email', $email)){
		$errors['email'] = 'Nieprawidłowy format adresu email';
	}
	if(!validateTypes('txt', $text)){
		$errors['text'] = 'Prosze podać treść wiadomości';
	}
	if(count($errors)>0){
		$result = array( 'type' => 'error', 'code' => $errors);
	}else{
		$result = array( 'type' => 'success', 'code' => 'Dziękujemy za wysłanie wiadomości');
		
		$txt  = '<b>name:</b> '.$name.'<br>';
		$txt .= '<b>email:</b> '.$email.'<br>';
		$txt .= '<b>text:</b> '.$text.'<br>';
		mailsend($txt, "Wiadomość ze strony Geek Factory" , "marcinurban560@gmail.com");
	}

	$result = json_encode($result);
	echo $result;
	die();  
 
?>