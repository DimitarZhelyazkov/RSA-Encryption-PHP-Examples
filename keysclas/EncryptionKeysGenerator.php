<?php 
// Autor: Dimitar Zhelyazkov
class EncryptionKeysGenerator 

{

	private $p; // Prime 1
	private $q; // Prime 2
	private $n; // Must hold the product of (p * q)
	private $fn; // F function of N -> (p -1) * (q - 1)
	private $encryptionKeys = []; // Array that hold all prime nuumbers that are not common factors of N and Fn and also all of them are prime. Hold Public Encryption Keys
	private $encryptionKeysPairs = [[]]; // Array that hold private decryption keys. Every array key respond to encryption key [ encryption key => decryption key ]
	private $rangeFrom; // hold ranged to generate decryption key
	private $rangeTo;

	public function __construct($p,$q,$rangeFrom,$rangeTo) {
		$this->p = $p;
		$this->q = $q;
		$this->rangeFrom = $rangeFrom;
		$this->rangeTo = $rangeTo;
		$this->n = $p * $q;
		$this->fn = ( $p - 1 ) * ( $q - 1 );
		$this->encryptionKeys = $this->findE($this->n , $this->fn );
		$this->encryptionKeysPairs = $this->findD($this->encryptionKeys , $this->rangeFrom , $this->rangeTo , $this->fn );
	}	

	private function findE($n , $fn ) { // Find Encription Keys return array of available public keys
		$hold = [];
		for($i = 2; $i < $fn; $i++ ){
			if($n % $i != 0 && $fn % $i != 0 ) { $hold[] = $i; }	
		}
		// find all primes in hold 
		$holdprimes = [];
		$holdprimes = $hold;
		for($i = 0; $i < count($hold); $i++) {
			for($k = 2; $k < $hold[$i]; $k++) {
				if($hold[$i] % $k == 0) { unset($holdprimes[$i]); break; }
			}
		}
		sort($holdprimes);
		return $holdprimes;
	}
	
	private function findD($e = [], $rangeFrom, $rangeTo , $fn) { // Find Decryption Key for each public key given in a range
		$hold = [[]];
		for($i = 0; $i < count($e); $i++ ){
			for($k = $rangeFrom; $k <= $rangeTo; $k++) {
		 
		  		if((($e[$i] * $k) % $fn ) === 1) { $hold[$e[$i]][] = $k; }
			}
		}	
		return $hold;
	}

	public function keyPairs() {
		return $this->encryptionKeysPairs; // Return multidimentional array of key pairs [Encryption key][Array of decryption keys]
	}
}
?>