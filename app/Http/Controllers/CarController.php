<?php

namespace App\Http\Controllers;


class CarController extends Controller {

public function Testme() {

return view("Test")->with("name", "Zura")
->with("lastname","Akbari")->with('color','Brown');

}

public function GG() {
return view("Test1")->with("country", "ge");
}

}









?>
