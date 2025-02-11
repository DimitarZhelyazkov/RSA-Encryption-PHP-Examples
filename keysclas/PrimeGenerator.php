<?php
class PrimeGenerator 
{
	/*
		Autor: Dimitar Zhelyazkov 
		Prime Generator using Mills prime formula
		Resource: https://en.wikipedia.org/wiki/Mills%27_constant
		
		Warning: Your computer might not compute the result.
		
		For this example is better to use numbers between 1 and 4 in the constructor
		
	*/
	
	private $millsConstant = 1.3063778838630806904686144926; // Mills Constant
	private $prime = [2]; // array of 2 to hold the two primes needed to construct keys in EncryptionKeyGenerator
	
	public function __construct($p, $q) { // $p and $q can be any positive number
		$this->prime[0] = $this->primeGenerator($p);
		$this->prime[1] = $this->primeGenerator($q);
	}
	
	private function primeGenerator($n) {
		return floor( bcpow( $this->millsConstant , bcpow( 3 , $n ) ) ); // formula: M to power of 3 to power of N - where N can e any positive number > 0
	}
	public function getPrimes() {
		return $this->prime;
	}
}
?>