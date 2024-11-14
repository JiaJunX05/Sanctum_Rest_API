<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Products;
use Validator;
use App\Http\Resources\ProductsResource;
use Illuminate\Http\JsonResponse;

class ProductsController extends BaseController
{
    public function index(): JsonResponse {

        $products = Products::all();
        return $this->sendResponse(ProductsResource::collection($products), 'Products retrieved successfully.');
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
        $products = Products::find($id);
  
        if (is_null($products)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse(new ProductsResource($products), 'Product retrieved successfully.');
    }

    public function update(Request $request, Products $product): JsonResponse {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product->name = $input['name'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->quantity = $input['quantity'];
        $product->save();

        return $this->sendResponse(new ProductsResource($product), 'Product updated successfully.');
    }

    public function destroy($id): JsonResponse {
        $product = Products::find($id);
    
        if (!$product) {
            return $this->sendResponse([], 'Product not found.', 404);
        }
    
        $product->delete();
        return $this->sendResponse([], 'Product deleted successfully.', 204);
    }   
}
