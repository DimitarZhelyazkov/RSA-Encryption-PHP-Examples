<?php

class PrimeGeneratorTwo 
{
	/*
		Autor: Dimitar Zhelyazkov
		Prime generator using Fermat's test 
		Resource: https://en.wikipedia.org/wiki/Fermat_primality_test
	
		Warning! This script check every number in a range and return ony primes 
		
		Your compiter might not be able to compite large numbers. 
	*/
	 
	private $primes = [];
	
	public function __construct($rangeFrom, $rangeTo) {
		$this->primes = $this->fermat($rangeFrom, $rangeTo);
	}

	private function fermat($rF, $rT) {
		$p = [];
		for($i = $rF; $i < $rT; $i++) {
			for($k = 1; $k < $i; $k++) {
				$holder = intval(bcpow($k , $i )) - $k;
				if( intval(bcmod($holder, $i)) !== 0 ) { break; }
				if( $i - 1 == $k ) { $p[] = $i; }
			}
		}
		return $p;
	}	
	
	public function getPrimes() {
		return $this->primes;
	}


}

?>