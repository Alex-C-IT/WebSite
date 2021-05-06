<?php

namespace App\Validators;

use App\Repository\TicketRepository;

class TicketReplyValidator extends AbstractValidator {

    public function __construct(array $data)
    {
        parent::__construct($data);
        //Règles validation formulaire
        $this->validator->rule('required', ['contentAnswer']);
        $this->validator->rule('lengthBetween', 'contentAnswer', 0, 10000);
    }
}

?>