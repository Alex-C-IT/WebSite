<?php

namespace App\Validators;

use App\Repository\PostRepository;

class PostValidator extends AbstractValidator {

    public function __construct(array $data, PostRepository $table, ?int $postID = null, array $categories)
    {
        parent::__construct($data);
        //Règles validation formulaire
        $this->validator->rule('required', ['name', 'slug', 'content']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 150);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule('image', 'image');
        $this->validator->rule('subset', 'categories_ids', array_keys($categories));
        $this->validator->rule(function ($field, $value) use ($table, $postID){
            return !$table->exists($field, $value, $postID);
        }, ['slug', 'name'], 'Cette valeur est déjà utilisée');
        $this->validator->rule('lengthBetween', 'content', 50, 10000);
        $this->validator->rule('dateFormat', 'createdAt', 'Y-m-d H:i:s');
    }

}

?>