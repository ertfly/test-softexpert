<?php

namespace Helpers\FormValidation\Validations;

class RequiredValidation extends AbstractValidation
{
    private $message;

    public function validate()
    {
        $this->message = 'O campo %s é obrigatório';
        if ($this->value == '') {
            throw new \Exception(sprintf($this->message, $this->description));
        }
    }
}
