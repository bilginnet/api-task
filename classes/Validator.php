<?php

class Validator
{
    public function rules()
    {
        return [                
        ];
    }

    public function required($field, $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException("$field is required.");
        }
    }

    public function string($field, $value)
    {
        if (!empty($value) && !is_string($value)) {
            throw new InvalidArgumentException("$field must be a string.");
        }
    }

    public function maxChar($field, $value, $max)
    {
        if (!empty($value) && strlen($value) > $max) {
            throw new InvalidArgumentException("$field exceeds maximum character limit.");
        }
    }

    public function datetime($field, $value)
    {
        if (!empty($value) && !strtotime($value)) {
            throw new Exception("$field must be a valid date and time.");
        }
    }

    public function lowerThanDate($field, $value, $compareField)
    {
        if (!empty($compareField) && !empty($value) && strtotime($value) >= strtotime($compareField)) {
            throw new Exception("$field must be lower than $compareField.");
        }
    }
    
    public function higherThanDate($field, $value, $compareField)
    {
        if (!empty($compareField) && !empty($value) && strtotime($value) <= strtotime($compareField)) {
            throw new Exception("$field must be higher than $compareField.");
        }
    }

    public function color($field, $value)
    {
        if (!empty($value) && !preg_match('/^#[0-9a-fA-F]{6}$/', $value)) {
            throw new InvalidArgumentException("$field must be a valid HEX color code.");
        }
    }

    public function in($field, $value, $in)
    {
        $array = explode(',', $in);
        if (!in_array($value, $array)) {
            throw new InvalidArgumentException("$field must be one of: $in");
        }
    }
}
