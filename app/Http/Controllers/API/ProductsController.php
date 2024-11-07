<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Products;
use Validator;
use App\Http\Resources\Products as ProductsResource;
use App\Http\Resources\ProductsCollection;
use Illuminate\Http\JsonResponse;

class ProductsController extends BaseController
{
    public function index(): JsonResponse {
        $products = Products::all();
        return $this->sendResponse(ProductsCollection::collection($products), 'Products retrieved successfully.');
    }

    public function store(Request $request): JsonResponse {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $products = Products::create($input);
        return $this->sendResponse(new ProductsResource($products), 'Product created successfully.');
    }

    public function show($id): JsonResponse {
        $product = Product::find($id);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    public function update(Request $request, $id): JsonResponse {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();
   
        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }

    public function destroy(Products $products): JsonResponse {
        $product->delete();
   
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
