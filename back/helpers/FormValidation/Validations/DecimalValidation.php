<?php

namespace Helpers\FormValidation\Validations;

use Helpers\NumberHelper;

class DecimalValidation extends AbstractValidation
{
    private $message;

    public function validate()
    {
        $this->message = 'O campo %s deve ser informado um valor decimal válido';
        if (!isset($this->options['dec'])) {
            throw new \Exception('Informe as casas decimais');
        }

        $decimal = NumberHelper::toDecimal($this->value, $this->options['dec']);
        if ($this->value != '' && !is_numeric($decimal)) {
            throw new \Exception(sprintf($this->message, $this->description));
        }

        $this->value = doubleval($decimal);
    }
}
