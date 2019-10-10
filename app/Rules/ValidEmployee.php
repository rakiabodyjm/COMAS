<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\SalaryDeductions;
use App\Employee;

class ValidEmployee implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */


    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        global $pogi;

        global $error;

        $pogi = $value;

        
        if(!empty($pogi)) 
        {
            $employeename = explode(", ", $pogi);

            if(!array_key_exists('1', $employeename))
            {
                $error = 'Please select from the suggestion';
                return false;

            }
            else
            {
                $elname = $employeename[0];
                $efname = $employeename[1];

                $eid = Employee::select('employeeid')
                        ->where('lname', $elname)
                        ->where('fname', $efname)
                        ->value('employeeid');

                if(empty($eid))
                {
                    $error ='Please select only from the suggestion';
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }

        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        global $pogi;

        global $error;

        return $error;



    }
}
