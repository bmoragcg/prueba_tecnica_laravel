<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ComidaTipicaController extends Controller
{
    //
    public function index()
    {
        try {
            $url =  "www.themealdb.com/api/json/v1/1/filter.php?a=Canadian";
            $data = Http::withOptions(['verify' => false, 'curl' => array(CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false)])->get($url)->json();

            return response()->json(
                $data,
            );
        } catch (\Throwable $th) {
            print_r($th->getMessage() . ' - ' . $th->getLine());
        }
    }

    public function getCategory()
    {
        try {
            $urlCategoria =  "www.themealdb.com/api/json/v1/1/categories.php";
            $dataCategoria = Http::withOptions(['verify' => false, 'curl' => array(CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false)])->get($urlCategoria)->json();

            return response()->json(
                $dataCategoria,
            );
        } catch (\Throwable $th) {
            print_r($th->getMessage() . ' - ' . $th->getLine());
        }
    }

    public function getMealsByName(Request $request)
    {
        try {

            $urlMeals = "www.themealdb.com/api/json/v1/1/search.php?s=$request->food";

            $dataMeals = Http::withOptions(['verify' => false, 'curl' => array(CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false)])->get($urlMeals)->json();
            return response()->json(
                $dataMeals,
            );
        } catch (\Throwable $th) {
            print_r($th->getMessage() . ' - ' . $th->getLine());
        }
    }

    public function getMealsByCategory(Request $request)
    {
        try {
            $urlMealsCategory = "www.themealdb.com/api/json/v1/1/filter.php?c=$request->category";

            $dataMealsCategory = Http::withOptions(['verify' => false, 'curl' => array(CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false)])->get($urlMealsCategory)->json();
            return response()->json(
                $dataMealsCategory,
            );
        } catch (\Throwable $th) {
            print_r($th->getMessage() . ' - ' . $th->getLine());
        }
    }

    public function saveTags(Request $request)
    {
        try {

            $tags = new Tags();

            $tags->nombre = $request->tag;

            $tags->save();

            return response()->json(['status' => true, "message" => $tags]);
        } catch (\Throwable $th) {
            print_r($th->getMessage() . ' - ' . $th->getLine());
        }
    }

    public function getTags()
    {
        try {

            $tags = DB::table('tags')->select('id_tags', 'nombre', DB::raw('COUNT(nombre) as cantidad'))->groupBy('nombre')->limit(5)->get();

            return response()->json(['status' => true, "message" => $tags]);
        } catch (\Throwable $th) {
            print_r($th->getMessage() . ' - ' . $th->getLine());
        }
    }
}
