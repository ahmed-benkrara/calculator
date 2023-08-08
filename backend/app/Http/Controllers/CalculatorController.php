<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function calculate(Request $req){
        try{
            return response()->json(['result' => eval('return ' . $req->expression . ';')]);
        }catch(\Throwable $e){
            return response()->json(['result' => 'infinity']);
        }
    }
}
