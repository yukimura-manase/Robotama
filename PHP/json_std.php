
<?php

// 1度、JSON化すると、private, protected, メソッドは消えるので注意すること

class Robotama{
    private $id = 1;
    public $name = "ロボ玉";
    public $like = "ひまたね";
    private $puru = true;
    public $from = "グンマー帝国";
    protected $rival = "白桃さん";
    public $cost = 5000;

    public function getId () {
        return $this->id;
    }

    public function getRival () {
        return $this->rival;
    }

    public function getPuru () {
        return $this->puru;
    }
}
 
$robotama = new Robotama();

// Robotama-インスタンス
var_dump($robotama);
echo "\n";

echo $robotama->getRival();
echo "\n";

// JSON-String
$json_tama = json_encode($robotama, JSON_UNESCAPED_UNICODE);
var_dump($json_tama);
echo "\n";


// stdClass
$new_tama = json_decode($json_tama, false);
var_dump($new_tama);
echo "\n";


// Error-発生
echo $new_tama->getRival();
echo "\n";







