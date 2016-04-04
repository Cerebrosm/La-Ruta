<?php
// Variables
$ingredientes = trim($_POST['ingredientes']);
$preparacion = trim($_POST['preparacion']);
$rnombre = trim($_POST['rnombre']);
$rcorreo = trim($_POST['rcorreo']);
$rautor = trim($_POST['rautor']);

// Email address validation - works with php 5.2+
function is_email_valid($rcorreo) {
	return filter_var($rcorreo, FILTER_VALIDATE_EMAIL);
}


if( isset($ingredientes) && isset($preparacion) && isset($rnombre) && isset($rcorreo) && isset($rautor) && is_email_valid($rcorreo) ) {

	// Avoid Email Injection and Mail Form Script Hijacking
	$pattern = "/(content-type|bcc:|cc:|to:)/i";
	if( preg_match($pattern, $rnombre) || preg_match($pattern, $rcorreo) || preg_match($pattern, $preparacion) ) {
		exit;
	}

	// Email will be send
	$to = "contacto.comepesca@gmail.com"; // Change with your email address
	$sub = "no-replay@cerebrosm.com"; // You can define email subject
	// HTML Elements for Email Body
	$body = <<<EOD
	<strong>Nombre:</strong> $rnombre <br>
	<strong>Correo:</strong> <a href="mailto:$rcorreo">$rcorreo</a> <br> <br>
	<strong>Autor:</strong> $rautor <br>
	<strong>Ingredientes:</strong> $ingredientes <br>
	<strong>Preparación:</strong> $preparacion <br>
EOD;
//Must end on first column

	$headers = "From: $rnombre <$rcorreo>\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// PHP email sender
	mail($to, $sub, $body, $headers);
}


?>
