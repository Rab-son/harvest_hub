<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use AfricasTalking\SDK\AfricasTalking;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProductResource::collection(Product::query()->orderBy('id', 'desc')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);

        return response(new ProductResource($product), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param \App\Models\Product                     $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $product->update($data);
    
        // Check if phone_number exists on the form
        $phone_number = $request->input('phone_number');
        if ($phone_number) {
            // Initialize the SDK
            $username = env('AFRICASTALKING_USERNAME');
            $api_key = env('AFRICASTALKING_API_KEY');
            $AT = new AfricasTalking($username, $api_key);
    
            // Set the SMS service
            $sms = $AT->sms();
    
            // Set the message
            $message = "The status of your product has been updated. Please Check The Notification Section";
    
            // Set the recipients
            $recipients = [$phone_number];
    
            // Send the message
            $sms->send([
                'to'      => $recipients,
                'message' => $message,
                'from'    => 'HH'
            ]);
        }
    
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response("", 204);
    }
}
