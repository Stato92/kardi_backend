<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Pesel implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $reg = '/^[0-9]{11}$/';
        if(preg_match($reg, $value)==false)
            return false;
        else
        {
            $digits = str_split($value);
            if ((intval(substr($value, 4, 2)) > 31)||(intval(substr($value, 2, 2)) > 12))
                return false;
            $checksum = (1*intval($digits[0]) + 3*intval($digits[1]) + 7*intval($digits[2]) + 9*intval($digits[3]) + 1*intval($digits[4]) + 3*intval($digits[5]) + 7*intval($digits[6]) + 9*intval($digits[7]) + 1*intval($digits[8]) + 3*intval($digits[9]))%10;
            if($checksum == 0)
                $checksum = 10;
            $checksum = 10 - $checksum;

            return (intval($digits[10]) == $checksum);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Nieprawidłowy numer pesel';
    }
}
