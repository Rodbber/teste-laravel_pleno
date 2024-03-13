<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        return $this->applyFilters($request, Product::class);
    }

    public function getAllPriceGreaterThan($price){
        return Product::priceGreaterThan(floatval($price))->get();
    }

    public function store(ProductRequest $request){
        try {
            Product::create($request->all());
            return response()->json(['message' => "Produto criado com sucesso"]);
        } catch (\Throwable $th) {
            return response()->json(['message' => "erro ao tentar criar novo produto"], 500);
        }
    }

    public function update(ProductRequest $request, $id){
        try {
            Product::find($id)->update($request->all());
            return response()->json(['message' => "Produto atualizado com sucesso"]);
        } catch (\Throwable $th) {
            return response()->json(['message' => "erro ao tentar atualizar novo produto"], 500);
        }
    }

    public function destroy($id){
        try {
            Product::find($id)->delete();
            return response()->json(['message' => "Produto excluido com sucesso"]);
        } catch (\Throwable $th) {
            return response()->json(['message' => "erro ao tentar excluir novo produto"], 500);
        }
    }
}
