<?php 

namespace App;

use Valitron\Validator as ValitronValidator;

class Validator extends ValitronValidator
{
    protected static $_lang = 'fr';
    
    public function __construct($data = array(), $fields = array(), $lang = null, $langDir = null)
    {
        parent::__construct($data, $fields, $lang, $langDir);

        // Règle : IMAGE
        self::addRule('image', function($field, $value, array $params, array $fields) {
            // 1er cas : On accepte qu'il n'y a pas d'image.
            if($value['size'] === 0) return true;
            // 2ème cas : On accepte que certains types d'image (jpeg, png)
            $validFormats = ['image/jpeg', 'image/png'];
            return in_array($value['type'], $validFormats);
        }, "Le fichier n'est pas une image valide.");

        // Règle : MAP
        self::addRule('googlemap', function($field, $value, array $params, array $fields) {
            // 1er cas : On accepte qu'il n'y a pas de map
            if(strlen($value) === 0) return true;
            // 2ème cas : On accepte que des liens google. Vérification simpiste en vérifiant si l'adresse est composée de "https://www.google.com/maps/embed"
            if(stristr($value, "https://www.google.com/maps/embed") !== false ) {
                return true;
            }
            return false;
        }, "Cette carte Google n'est pas une carte valide.");
    }

    /**
     * @param  string $field
     * @param  string $message
     * @param  array  $params
     * @return array
     */
    protected function checkAndSetLabel($field, $message, $params)
    {
            return str_replace('{field}', '', $message);
    }
}

?>