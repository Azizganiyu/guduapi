<?php

use App\Models\Make;
use App\Models\Modell;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pull-vehicle-data', function () {
    $makes = Http::get('https://vpic.nhtsa.dot.gov/api/vehicles/getallmakes?format=json');
    if($makes->ok()){
        $data = $makes['Results'];
        foreach($data as $make){
            $newMake = new Make();
            $newMake->id = $make['Make_ID'];
            $newMake->name = $make['Make_Name'];
            $newMake->category_id = 1;
            $newMake->user_id = 1;
            $newMake->save();
            $models = Http::get('https://vpic.nhtsa.dot.gov/api/vehicles/GetModelsForMakeId/'.$make['Make_ID'].'?format=json');
            foreach($models['Results'] as $model){
                $newModel = new Modell();
                $newModel->id = $model['Model_ID'];
                $newModel->name = $model['Model_Name'];
                $newModel->make_id = $model['Make_ID'];
                $newModel->category_id = 1;
                $newModel->user_id = 1;
                $newModel->save();
            }
        }

        echo "done";
    }
    else{
        echo "error";
    }
});
