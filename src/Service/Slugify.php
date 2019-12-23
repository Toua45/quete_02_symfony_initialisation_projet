<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input) : string
    {
        setlocale(LC_CTYPE, 'fr_FR');
        $inputTransform = iconv('UTF-8','ASCII//TRANSLIT', strtolower(trim($input)));
        $slugNoSign = preg_replace('/\W/', ' ', $inputTransform);
        $slug = preg_replace('(\s+)', "-", $slugNoSign);
        return $slug;
    }
}