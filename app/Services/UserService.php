<?php
namespace App\Services;
use App\Models\User;

class UserService{

    //create your class
    // create a facade class which extends Facade (wuth getFacadeAccessor method which returns Service container key)
    // Bind that key in your App service provider which returns a callback(call back returns your main class)
    // Facade class is ready to call your main class methods statically. You can create allias in your config/app.php for faster access to facade

    public function getUsers(){
        return User::all()->modelKeys();
    }


}



?>
