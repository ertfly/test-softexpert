<?php

namespace Helpers\FormValidation\Validations;

abstract class AbstractValidation
{
    protected $value;
    protected $description;
    protected $options;

    public function __construct(&$value, $description, array $options = null)
    {
        $this->value = trim($value);
        $this->description = $description;
        $this->options = $options;
    }

    abstract public function validate();

    public function getValue()
    {
        return $this->value;
    }
}
