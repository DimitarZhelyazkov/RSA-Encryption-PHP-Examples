<html>
<head>
<title>RSA-Encryption-PHP-Examples</title>
</head>
<body>
<!-- Autor: Dimitar Zhelyazkov -->
<pre>
<?php
require_once "keysclas/PrimeGenerator.php"; // Mills Constant prime generator
require_once "keysclas/PrimeGeneratorTwo.php"; //Fermat test + genarator
require_once "keysclas/EncryptionKeysGenerator.php";

$fermat = new PrimeGeneratorTwo(3,20); // find primes between 3 - 20 using Fermat's Test 

print_r($fermat->getPrimes());

$primes = new PrimeGenerator(2,3); // This need serious computer power to compute the results.

print_r($primes->getPrimes()); // print two rows array with primes 

$keys = new EncryptionKeysGenerator(
									7, // Prime 1
									19, // Prime 2
									1, // Range from
									100 // Range to
									); 

print_r($keys->keyPairs()); // Print all key pairs - multidimentional array[EncryptionKey][Array of Decryption keys]
?>
</pre>
</body>
</html>