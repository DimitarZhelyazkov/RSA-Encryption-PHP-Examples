<?php 

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
		$this->encryptionKeys = $this->findE();
		$this->encryptionKeysPairs = $this->findD();
	}	

	private function findE() { // Find Encription Keys return array of available public keys
		$hold = [];
		$n = $this->n;
		$fn = $this->fn;
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
	
	private function findD() { // Find Decryption Key for each public key given in a range
		$e = [];
		$e = $this->encryptionKeys;
		$rangeFrom = $this->rangeFrom;
		$rangeTo = $this->rangeTo;
		$fn = $this->fn;
		$hold = [[]];
		for($i = 0; $i < count($e); $i++ ){
			for($k = $rangeFrom; $k <= $rangeTo; $k++) {
		 
		  		if((($e[$i] * $k) % $fn ) === 1) { $hold[$e[$i]][] = $k; }
			}
		}	
		return $hold;
	}
	
	public function results() {
		return  "Prime 1: " . $this->p . 
				"<br>Prime 2: " . $this->q .
				"<br>N: " . $this->n . 
				"<br>Fn: " . $this->fn .
				"<br> ";
	}
	public function getE() {
		return $this->encryptionKeys;
	}
	public function keyPairs() {
		return $this->encryptionKeysPairs;
	}
}
?>