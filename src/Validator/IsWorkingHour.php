<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class IsWorkingHour extends Constraint
{
    public $message = 'The string "{{ string }}" contains an illegal character: it can only contain letters or numbers.';
    public $mode = 'strict'; // If the constraint has configuration options, define them as public properties


    public function validatedBy()
    {
        return parent::validatedBy(); // TODO: Change the autogenerated stub
    }
}