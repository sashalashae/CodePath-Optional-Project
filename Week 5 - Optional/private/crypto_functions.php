<?php

// Symmetric Encryption

// Cipher method to use for symmetric encryption
const CIPHER_METHOD = 'AES-256-CBC';

function key_encrypt($string, $key, $cipher_method=CIPHER_METHOD) {
  
   $key = str_pad($key, 32, '*');

   $iv_length = openssl_cipher_iv_length(CIPHER_METHOD);
   $iv = openssl_random_pseudo_bytes($iv_length);

   $encrypted = openssl_encrypt($string, CIPHER_METHOD, $key, OPENSSL_RAW_DATA, $iv);

   $message = $iv . $encrypted;

   return base64_encode($message);

}

function key_decrypt($string, $key, $cipher_method=CIPHER_METHOD) {

// Needs a key of length 32 (256-bit)
  $key = str_pad($key, 32, '*');

  // Base64 decode before decrypting
  $iv_with_ciphertext = base64_decode($string);
  
  // Separate initialization vector and encrypted string
  $iv_length = openssl_cipher_iv_length(CIPHER_METHOD);
  $iv = substr($iv_with_ciphertext, 0, $iv_length);
  $ciphertext = substr($iv_with_ciphertext, $iv_length);

  // Decrypt
  $plaintext = openssl_decrypt($ciphertext, CIPHER_METHOD, $key, OPENSSL_RAW_DATA, $iv);

  return $plaintext;
}


// Asymmetric Encryption / Public-Key Cryptography

function generate_keys() {
  
  

  // Create a private/public key pair
  $config = array(
      "digest_alg" => "sha512",
      "private_key_bits" => 2048,
      "private_key_type" => OPENSSL_KEYTYPE_RSA,
  );

  $resource = openssl_pkey_new($config);
   
  // Extract private key from the pair
  openssl_pkey_export($resource, $private_key);

  // Extract public key from the pair
  $key_details = openssl_pkey_get_details($resource);
  $public_key = $key_details["key"];
   
  return array('private' => $private_key, 'public' => $public_key);
}

function pkey_encrypt($string, $public_key) {
  
  openssl_public_encrypt($string, $encrypted, $public_key);

  // Use base64_encode to make contents viewable/sharable
  $message = base64_encode($encrypted);

  return $message;
  
}

function pkey_decrypt($string, $private_key) {
  // Unformatted key error
  error_reporting(0);

  $ciphertext = base64_decode($string);
  
  openssl_private_decrypt($ciphertext, $decrypted, $private_key);

  return $decrypted;

}


// Digital signatures using public/private keys

function create_signature($data, $private_key) {
  // A-Za-z : ykMwnXKRVqheCFaxsSNDEOfzgTpYroJBmdIPitGbQUAcZuLjvlWH
  
  openssl_sign($data, $raw_signature, $private_key);

  return $signature = base64_encode($raw_signature);

}

function verify_signature($data, $signature, $public_key) {
  //Unformatted key error
  error_reporting(0);

  // Vigenère
  $raw_signature = base64_decode($signature);
  $result = openssl_verify($data, $raw_signature, $public_key);
  
  return $result;
  // returns 1 if data and signature match
  //return 'RK, pym oays onicvr. Iuw bkzhvbw uedf pke conll rt ZV nzxbhz.';
}

?>
