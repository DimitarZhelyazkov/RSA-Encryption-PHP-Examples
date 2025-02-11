<?php
require_once "keysclas/EncryptionKeysGenerator.php";

$keys = new EncryptionKeysGenerator(
									7, // Prime 1
									19, // Prime 2
									100, // Range from
									1000 // Range to
									); 

print_r($keys->keyPairs()); // Print all key pairs multidimentional array[EncryptionKey][Array of Decryption keys]


 
?>