<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    // TODO :: This Method (first|find) return Single Row  OR (value) method return a single value
    public function first()
    {
        // TODO:: etrieve a single row from a database table
        $user = User::selection()->first();
        dd($user);
    }

    public function value()
    {
        //TODO :: extract a single value from a record using the value method.
        // TODO:: This method will return the value of the column directly
        $user = User::where('id', 2)->value('name');
        dd($user);
    }

    public function find()
    {
        // TODO:: retrieve a single row from a database table
        $user = User::find(2);
        dd($user);
    }

    public function findORFail()
    {
        // TODO:: retrieve a single row from a database table or fail
        $user = User::findOrFail(2);
        dd($user);
    }


}
