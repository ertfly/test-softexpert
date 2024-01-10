<?php

namespace Helpers\FormValidation\Validations;

class EmailValidation extends AbstractValidation
{
    private $message;

    public function validate()
    {
        $this->message = 'O %s esta inválido';

        if ($this->value != '' && !filter_var(trim($this->value), FILTER_VALIDATE_EMAIL)) {
            throw new \Exception(sprintf($this->message, $this->description));
        }
    }
}
