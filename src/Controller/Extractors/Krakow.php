<?php

namespace App\Controller\Extractors;

use App\Entity\District;
use DOMDocument;

class Krakow
{
    private $miasto = 'Krakow';
    private $liczbaDzielnic = 18;
    private $indexDzielnica = 0;
    private $indexPowierzhnia = 2;
    private $indexLudnosc = 4;

    private $address = 'http://appimeri.um.krakow.pl/app-pub-dzl/pages/DzlViewGlw.jsf?id=';

    public function pobierz(): array {
        $dzielnice = array();

        for ($index = 1; $index <= $this->liczbaDzielnic; $index++) {

            $result = file_get_contents($this->address . $index);

            $DOM = new DOMDocument;
            @$DOM->loadHTML($result);

            $dzielnica = $DOM->getElementsByTagName('h3');
            $dzielnica = $dzielnica->item($this->indexDzielnica)->nodeValue;
            $dzielnica = trim($dzielnica);
            $dzielnica = preg_replace('~\xc2\xa0~', ':', $dzielnica);
            $dzielnica = explode(':', $dzielnica)[1];

            $ludnosc = $DOM->getElementsByTagName('td');
            $ludnosc = $ludnosc->item($this->indexLudnosc)->nodeValue;

            $powierzchnia = $DOM->getElementsByTagName('td');
            $powierzchnia = $powierzchnia->item($this->indexPowierzhnia)->nodeValue;
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