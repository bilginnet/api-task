<?php

class ValidatorCreate extends Validator
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'maxChar:255'],
            'startDate' => ['required', 'datetime', 'lowerThanDate:endDate'],
            'endDate' => ['datetime', 'higherThanDate:startDate'],
            'durationUnit' => ['in:HOURS,DAYS,WEEKS'],
            'color' => ['color'],
            'externalId' => ['maxChar:255'],
            'status' => ['in:NEW,PLANNED,DELETED'],
        ];
    }
}