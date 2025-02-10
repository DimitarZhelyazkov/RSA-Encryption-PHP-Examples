<?php
/*todo:  Add some check of keys are they valid?  */


require_once "keysclas/EncryptionKeysGenerator.php";

$keys = new EncryptionKeysGenerator(7,19); // 7 19

echo "Test :";
echo (41*29) % 108;

echo $keys->results();
print_r($keys->getE());

echo "<br><br><br>";

print_r($keys->findD($keys->getE(),1,100,108));


 
?>