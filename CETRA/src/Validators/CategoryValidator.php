<?php

namespace App\Validators;

use App\Repository\CategoryRepository;

class CategoryValidator extends AbstractValidator {

    public function __construct(array $data, CategoryRepository $table, ?int $categoryID = null)
    {
        parent::__construct($data);
        //Règles validation formulaire
        $this->validator->rule('required', ['name', 'slug']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 150);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule(function ($field, $value) use ($table, $categoryID){
            return !$table->exists($field, $value, $categoryID);
        }, ['slug', 'name'], 'Cette valeur est déjà utilisée');
        $this->validator->rule('lengthBetween', 'color', 6, 6);
    }

}

?>