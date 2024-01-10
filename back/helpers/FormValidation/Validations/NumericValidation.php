<?php

namespace Helpers\FormValidation\Validations;

class NumericValidation extends AbstractValidation
{
    private $message;

    public function validate()
    {
        $this->message = 'O campo %s deve conter apenas número';
        if ($this->value != '' && !is_numeric($this->value)) {
            throw new \Exception(sprintf($this->message, $this->description));
        }
    }
}
