<?php

namespace App\Helpers;

class PhoneHelper
{
    public function __construct(public $phones)
    {
        $this->country_codes = config('country_codes');
    }

    public function getParsedPhones()
    {
        $parsedPhones = [];
        foreach ($this->phones as $phone) {
            $parsedPhones[] = $this->parsePhone($phone);
        }
        return $parsedPhones;
    }

    public function parsePhone($phone): array
    {
        $country_code = substr($phone, 1, 3);
        $number = substr($phone, 5);
        $regex = $this->country_codes[$country_code]['regex'];
        $valid = preg_match("/$regex/", $phone);
        return [
            'country_code' => $country_code,
            'number' => $number,
            'valid' => $valid,
            'country' => $this->country_codes[$country_code]['name']
        ];
    }


}
