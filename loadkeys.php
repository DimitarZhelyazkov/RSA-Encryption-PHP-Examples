<?php
/*todo:  Add some check of keys are they valid?  */


require_once "keysclas/EncryptionKeysGenerator.php";

$keys = new EncryptionKeysGenerator(7,19,100,1000); // 7 19 // send 0 for random key generation Example (0,0,rangeFrom,rangeTo) => 0,0,100,1000

echo $keys->results();
print_r($keys->getE());

echo "<br><br><br>";

print_r($keys->keyPairs());


 
?>