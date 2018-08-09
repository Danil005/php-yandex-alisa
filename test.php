<?php include("vendor/autoload.php");

//$m = new \yandex\alisa\Alisa();
//echo $m->printVars("Привет [ome]");

$a = [
	"buttons"=>[
		"question"=>[
			"title" => "Привет",
			"hide"=> true,
			"payload"=> [],
			"url"=> "https=>//vixed.ru/"
        ],
        "prepare"=> [
          [
          	"title"=> "Привет1",
            "hide"=> false,
            "payload"=> [],
            "url"=> null
          ]
        ]
      ]
	];

$c = count($a['send']['buttons']['question']);
for($i=0;$i<$c;$i++) {
	echo $value['buttons']['question']['title'];
	$this->addButton($value['buttons']['question']['title'],
		$value['buttons']['question']['hide'],
		$value['buttons']['question']['payload'],
		$value['buttons']['question']['url']);
}


//
//echo preg_match($math, 'Забронируй мне дом на 15=>40 в пятнцу');