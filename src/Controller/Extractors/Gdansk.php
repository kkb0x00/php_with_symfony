<?php

namespace App\Controller\Extractors;

use App\Entity\District;
use DOMDocument;

class Gdansk
{
    static $miasto = 'Gdansk';
    static $liczbaDzielnic = 34;
    static $indexDzielnica = 1;
    static $indexPowierzchnia = 2;
    static $indexLudnosc = 3;

    static $address = 'http://www.gdansk.pl/subpages/dzielnice/[dzielnice]/html/dzielnice_mapa_alert.php?id=';

    public static function pobierz(): array {
        $dzielnice = array();

        for($index = 1; $index <= self::$liczbaDzielnic; $index ++) {
            $result = file_get_contents(self::$address . $index);

            $DOM = new DOMDocument;
            $DOM->loadHTML(mb_convert_encoding($result, 'HTML-ENTITIES', 'UTF-8'));
            $items = $DOM->getElementsByTagName('div');

            $dzielnica = $items->item(self::$indexDzielnica)->nodeValue;

            $ludnosc = $items->item(self::$indexLudnosc)->nodeValue;
            $ludnosc = (int) explode(':', $ludnosc)[1];

            $powierzchnia = $items->item(self::$indexPowierzchnia)->nodeValue;
            $powierzchnia = explode(':', $powierzchnia)[1];
            $powierzchnia = str_replace(',', '.', $powierzchnia);
            $powierzchnia = (float) $powierzchnia;


            $district = new District();
            $district->setMiasto(self::$miasto);
            $district->setDzielnica($dzielnica);
            $district->setLudnosc($ludnosc);
            $district->setPowierzchnia($powierzchnia);

            array_push($dzielnice, $district);
        }

        return $dzielnice;
    }

}