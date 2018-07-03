<?php

namespace App\Controller\Extractors;

use App\Entity\District;
use DOMDocument;

class Krakow
{
    static $miasto = 'Krakow';
    static $liczbaDzielnic = 18;
    static $indexDzielnica = 0;
    static $indexPowierzhnia = 2;
    static $indexLudnosc = 4;

    static $address = 'http://appimeri.um.krakow.pl/app-pub-dzl/pages/DzlViewGlw.jsf?id=';

    public static function pobierz(): array {
        $dzielnice = array();

        for ($index = 1; $index <= self::$liczbaDzielnic; $index++) {

            $result = file_get_contents(self::$address . $index);

            $DOM = new DOMDocument;
            @$DOM->loadHTML($result);

            $dzielnica = $DOM->getElementsByTagName('h3');
            $dzielnica = $dzielnica->item(self::$indexDzielnica)->nodeValue;
            $dzielnica = trim($dzielnica);
            $dzielnica = preg_replace('~\xc2\xa0~', ':', $dzielnica);
            $dzielnica = explode(':', $dzielnica)[1];

            $ludnosc = $DOM->getElementsByTagName('td');
            $ludnosc = $ludnosc->item(self::$indexLudnosc)->nodeValue;

            $powierzchnia = $DOM->getElementsByTagName('td');
            $powierzchnia = $powierzchnia->item(self::$indexPowierzhnia)->nodeValue;
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