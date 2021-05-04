<?php

namespace App\Validators;

use App\Repository\TicketRepository;

class TicketValidator extends AbstractValidator {

    public function __construct(array $data, TicketRepository $table, ?int $ticketID = null)
    {
        parent::__construct($data);
        //Règles validation formulaire
        $this->validator->rule('required', ['object', 'content']);
        $this->validator->rule('lengthBetween', 'object', 10, 150);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule(function ($field, $value) use ($table, $ticketID) 
        {
            return !$table->exists($field, $value, $ticketID);
        }, ['slug'], 'Cette valeur est déjà utilisée');
    }

}

?>