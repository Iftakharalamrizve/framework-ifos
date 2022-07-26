<?php

namespace app\request;

use e2c\mvc\Request;

class RegistrationRequest extends Request
{

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'first_name'=>'required|max:256',
            'last_name'=>'required|max:256',
            'email'=>'required|email',
            'password'=>'required|max:6|min:1',
            'c_password'=>'match:password',
        ];
    }


    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [

            'first_name'=>'First Name Is required',
            'first_name.max'=>'First Name length is gather than {max} length ',
            'last_name'=>'Last name is required',
            'last_name.max'=>'Last length is gather than {max} length ',
            'email'=>'Email Is Required',
            'email.email'=>'Email Is not valid',
            'password'=>'Password Is required',
            'password.max'=>'Password length is gather than {max}',
            'password.min'=>'Password length is less than {min}',
            'c_password.match'=>'Password is not match with Confirm Password'

        ];
    }
}