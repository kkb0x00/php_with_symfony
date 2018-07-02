<?php

namespace App\Controller\Extractors;

use App\Entity\District;
use DOMDocument;

class Gdansk
{
    private $miasto = 'Gdansk';
    private $liczbaDzielnic = 34;
    private $indexDzielnica = 1;
    private $indexPowierzchnia = 2;
    private $indexLudnosc = 3;

    private $address = 'http://www.gdansk.pl/subpages/dzielnice/[dzielnice]/html/dzielnice_mapa_alert.php?id=';

    public function pobierz(): array {
        $dzielnice = array();

        for($index = 1; $index <= $this->liczbaDzielnic; $index ++) {
            $result = file_get_contents($this->address . $index);

            $DOM = new DOMDocument;
            $DOM->loadHTML(mb_convert_encoding($result, 'HTML-ENTITIES', 'UTF-8'));
            $items = $DOM->getElementsByTagName('div');

            $dzielnica = $items->item($this->indexDzielnica)->nodeValue;

            $ludnosc = $items->item($this->indexLudnosc)->nodeValue;
            $ludnosc = (int) explode(':', $ludnosc)[1];

            $powierzchnia = $items->item($this->indexPowierzchnia)->nodeValue;
            $powierzchnia = explode(':', $powierzchnia)[1];
            $powierzchnia = str_replace(',', '.', $powierzchnia);
            $powierzchnia = (float) $powierzchnia;


            $district = new District();
            $district->setMiasto($this->miasto);
            $district->setDzielnica($dzielnica);
            $district->setLudnosc($ludnosc);
            $district->setPowierzchnia($powierzchnia);

            array_push($dzielnice, $district);
        }

        return $dzielnice;
    }


}