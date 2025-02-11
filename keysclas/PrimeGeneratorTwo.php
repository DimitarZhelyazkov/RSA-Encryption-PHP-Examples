<?php

// Generate Primes using Fermat's test

class PrimeGeneratorTwo 
{

	private $primes = [];
	
	public function __construct($rangeFrom, $rangeTo) {
		$this->primes = $this->fermat($rangeFrom, $rangeTo);
	}

	private function fermant($rF, $rT) {
		$p = [];
		for($i = $rF; $i <= $rT; $++) {
			for($k = 1; $k < $i; $k++) {
				if((bcpow($k,$i) - $k) % $i != 0 ) { break; }
				if($k == $i - 1) { $p[] = $i; }
			}
		}
	
	}	
	
	public function getPrimes() {
		return $this->primes;
	}


}

?>