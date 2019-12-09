<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input) : string
    {
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
        $input= str_replace(' ', '-', $input); // Remplace les ' ' par des '-'
        $input= str_replace($search, $replace, $input);
        $input = preg_replace('/--+/', '-', $input);
        $input = strtolower($input);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $input); // Supprime les caractères spéciaux

        /*$text = trim(iconv('utf-8', 'ascii//TRANSLIT', $input));
        $slug = preg_replace('/[^a-z0-9 ]+/i', '', $text);
        return preg_replace('/\s+/', '-', strtolower($slug));*/
    }
}