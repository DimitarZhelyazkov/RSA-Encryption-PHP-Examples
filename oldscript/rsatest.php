<?php
/*
	Автор: Димитър Желязков
	Autor: Dimitar Zhelyazkov
	Важно! - скриптът на PHP е примерен и с обучителна цел и не е подходящ за вашия сайт.
*/
/*  RSA е най-използвания алгоритъм за асиметрично криптиране създаден през 1977 от трима математици
	Ron Rivest, Adi Shamir и Leonard Adleman.
	Целта на този скрипт е да се покаже как действа в действителност Vanilla RSA криптиране
	Генерирането на сложна RSA изисква сериозен хардуер, но в този пример ще разгледаме елементарни прайм числа
	За да можете да разберете алгоритъма ви е нужно да знаете какво са:
	1. Прайм числа -> са числа които се делят единственно и само на 1 и себе си! Пример: 1,2,3,5,7,11 ...
	2. Фактори -> са всички чилса които делят друго число без остатък. Пример факторите на 12 са 1,2,4,6 и 12
	3. Супер Прайм -> то ва са зисла които всичките им фактори са прйм числа без 1 и себе си.
		Пример: 12 не е супер прайм защото един от неговите фактори (2,4,6) не прайм.
				21 е супер прайм защото неговите фактори са прайм (3,7).
		Важно: Произведението от две прайм чила винаги е супер прайм!
	4.Работа с остатъци след деление. 
	5.Ойлер тотиент функция -> https://en.wikipedia.org/wiki/Euler%27s_totient_function
*/

// Define 2 prime numbers
// Нека дефинираме 2 прайм числа

$primeNumberOne = 7;
$ptimeNumberTwo = 19;

// Define Semi Prime number as product of $primeNumberOne and $ptimeNumberTwo 
// Нека дефинираме Супер Прайм като произведение от двете прайм числа

$semiPrime = $primeNumberOne * $ptimeNumberTwo;

// Define Totient of Semi Prime
// Да дефинираме Тотиент
// Тотиент е Ойлер фунция -> https://en.wikipedia.org/wiki/Euler%27s_totient_function
// За по лесно обяснение ще приемем, че тотиентът е равен на прозиведението между прайм числата всеки по-отделно намалени с 1

$totient = ($primeNumberOne - 1)*($ptimeNumberTwo - 1);

// Find factors of the Totient 
// Функция която връща масив с факторите на тотиента

function returnTotientFactors($t) {
	$factors = [];
	for($i = 1 ; $i <= sqrt($t) ; $i++) {
		if($t % $i == 0) { $factors[] = $i; 
			if($i != $t / $i) { $factors[] = $t / $i; }
		}
	}
	sort($factors);
	return $factors;
}
/*
	Generate Public keys 
		1. Must be Prime
		2. Must be less thant the Totient 
		3. Must not be factor of the Totient
	Генериране на Публичен Ключ
		1. Трябва да е прайм
		2. Трябва да е по-малък от тотиента
		3. Не трябва да е фактор на тотиента	  
*/


// Get all primes that are not factors of the Totient.
// In order to save hardware resources id better to have prepared list with prime numbers instead of checking if prime
// Функция която връща всички прайм числа между 1 и тотиента.
// Не е нужно да е функция а предварително подготвен списък с прайм числа, но тъй като работим с малки праим това ще свърши работа

function getAllPrimes($p) { // get all primes between 1 and the Totient
	$primes = []; 			// all primes must be pre-defined in order to save resources
	for($i = 1; $i <= $p; $i++) {
		$counter = 0;
		for($k = 1; $k <= $i; $k++) {
			if($i % $k == 0) { $counter++; }
		}
		if(!($counter > 2)) { $primes[] = $i; }
	}
	return $primes;
}

// Compare if primes are totient factors and remove them 
// $a - totient factors 
// $b - primes between 1 and totient
// Сравняване на праймите дали са фактори на тотиента и ги премахваме
// $a - масив от фактори на тотиента
// $b - масив от прайми между 1 и тотиента
 
function getCoPrimes($a = [], $b = []) {
	for($i = 0; $i < count($a); $i++){
		for($k = 0; $k < count($b); $k++){
			if($a[$i] === $b[$k]) { unset($b[$k]); } // Премахване при съвпадение
		}
	}
	return $b; 
		// every number returned in the array can be your public key  
}

// Generate Private Keys
// Private key formula (<private key> * <public key>) % totient === 1 
// The result must be 1 for valid private key
// Генериране на Частен ключ
// Формула <публичен ключ> * <частен ключ> % тотиент === 1
// Задължително трябва да е 1 за да е валиден частен ключ 

function returnPrivateKeys($publicKey = [],$t,$looplimit){ // лимитираме цикъла
	$privateKeys = [];
	for($i = 0; $i < count($publicKey); $i++){
		$c=2;
		while(true){
			if((($c * $publicKey[$i]) % $t) === 1) { $privateKeys += [ $publicKey[$i] => $c ];   }
			if($c === $looplimit) { break; }
			$c++;
		}
	}
	return $privateKeys; //return array with key attributes 
} 


// do some test with encription/ dectription
$listKeys = [];
$listKeys = returnPrivateKeys(getCoPrimes(returnTotientFactors($totient),getAllPrimes($totient)),$totient,100);

function encriptUsingAllKeys($keys = [], $textToEncript , $sprime) {
	foreach ($keys as $key => $value) {
		$enc = bcmod(bcpow($textToEncript,$key),$sprime);
		$dec = bcmod(bcpow($enc,$key),$sprime);
		$pdec = bcmod(bcpow($enc,$value),$sprime);
		$penc = bcmod(bcpow($textToEncript,$value),$sprime);
		echo "<br><h1>Keys validating! " . $key . " - " . $value . "</h1>";
		echo "<br><b>Public Key [</b>" . $key . "<b>] text [</b>" 
			  . $textToEncript . "<b>] encryption: </b>" . $enc;
		echo " Try to decrypt itself result : " . $dec; 
		if ($enc == $dec) { echo "  <b> !!! </b> the key is not good!"; } // why ? strange results
		echo "<br> Private Key [" . $value ."] text [" . $enc . "] decryption: "
			  . $pdec;
		if ($pdec == $textToEncript) { echo " Private key decryption matched with the original text! "; }
			else { echo "<b> !!! </b> Private key is not good!"; }	
		echo "<br> Text encrypred with private key: " . $penc . " try to decrypt with public : " 
			 . bcmod(bcpow($penc,$key),$sprime)
			 . "Remember private key must be keep safe private to only dectrypt messages encrypted with public key";
	}
}

echo "Resuts: <br> Prime 1: " . $primeNumberOne . " <br> Prime 2: " . $ptimeNumberTwo . "<br> Semi Prime: " . $semiPrime . "<br> Totient : " . $totient;

echo "<br> Totient factors: "; print_r(returnTotientFactors($totient));

echo "<br> Prime numbers in Totient: "; print_r(getAllPrimes($totient));

echo "<br> co-Primes: (List of available Public Keys) "; print_r(getCoPrimes(returnTotientFactors($totient),getAllPrimes($totient)));

echo "<br> Private keys: "; print_r(returnPrivateKeys(getCoPrimes(returnTotientFactors($totient),getAllPrimes($totient)),$totient,100));

echo "<br> All available key pairs count: " . count($listKeys);

foreach ($listKeys as $key => $value) {
	echo "<br> Public key: => " . $key . " Private key => " . $value;
}

echo "<br> Function test: "; encriptUsingAllKeys($listKeys,99, $semiPrime);

//echo "<br> Encruption of 99 with public key 29 : => " . bcmod(bcpow(99,97),$semiPrime);

//https://www.practicalnetworking.net/series/cryptography/rsa-example/



 ?>