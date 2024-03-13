<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function applyFilters(Request $request, $model, $with = [])
    {
        $model = new $model;
        $model = $model->with($with)->search($request->search);
        if ($request->has('sortBy')) {
            foreach ($request->sortBy as $valeu) {
                $model->orderBy($valeu['key'], $valeu['order']);
            }
        }

        if ($request->has('value') && $request->value) {
            $model->priceGreaterThan($request->value);
        }

        if ($request->itemsPerPage && $request->itemsPerPage != -1) {
            return $model->paginate($request->itemsPerPage);
        } else {
            $all = $model->get();
            return ['data' => $all, 'total' => $all->count()];
        }
    }

    public function isPrime($number){
        if(!is_numeric($number) || $number <= 1){
            return ['message' => 'Por favor enviar um valor numerico > 1'];
        }

        $number = abs($number);
        if($number == 2){
            return ['message' => 'É primo'];
        }
        for($i = 2; $i <= sqrt($number); $i++){
            if($number % $i == 0){
                return ['message' => 'Não é primo'];
            }
        }
        return ['message' => 'É primo'];
    }
}
