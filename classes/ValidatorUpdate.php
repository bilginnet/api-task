<?php

class ValidatorUpdate extends Validator
{
    public function rules()
    {
        return [
            'name' => ['string', 'maxChar:255'],
            'startDate' => ['datetime', 'lowerThanDate:endDate'],
            'endDate' => ['datetime', 'higherThanDate:startDate'],
            'durationUnit' => ['in:HOURS,DAYS,WEEKS'],
            'color' => ['color'],
            'externalId' => ['maxChar:255'],
            'status' => ['required', 'in:NEW,PLANNED,DELETED'],
        ];
    }
}