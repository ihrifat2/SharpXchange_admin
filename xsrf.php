<?php

function checkToken( $user_token, $session_token) {  # Validate the given (CSRF) token

	if( $user_token !== $session_token || !isset( $session_token ) ) {
		return false;
	}
	else{
		return true;
	}
}

function generateSessionToken() {  # Generate a brand new (CSRF) token
	if( isset( $_SESSION[ 'session_token' ] ) ) {
		destroySessionToken();
	}
	$_SESSION[ 'session_token' ] = encrypt(md5(uniqid()));
}

function destroySessionToken() {  # Destroy any session with the name 'session_token'
	unset( $_SESSION[ 'session_token' ] );
}

function tokenField() {  # Return a field for the (CSRF) token
	return $_SESSION[ 'session_token' ];
}

function encrypt($value){
    $plaintext = $value;
    $key = "ImranNurRobin-1337";
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
    $ciphertext = substr($ciphertext, 0, -2);
    return $ciphertext;
}

?>