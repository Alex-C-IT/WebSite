<?php

namespace App\Validators;

use App\Repository\PartnerRepository;

class PartnerValidator extends AbstractValidator {

    public function __construct(array $data, PartnerRepository $table, ?int $partnerID = null)
    {
        parent::__construct($data);
        //Règles validation formulaire
        $this->validator->rule('required', ['name', 'slug', 'webSite', 'street', 'city', 'postalCode']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 150);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule('image', 'image');
        $this->validator->rule('googlemap', 'mapGoogle');
        $this->validator->rule(function ($field, $value) use ($table, $partnerID){
            return !$table->exists($field, $value, $partnerID);
        }, ['slug', 'name'], 'Cette valeur est déjà utilisée');
    }

}

?>