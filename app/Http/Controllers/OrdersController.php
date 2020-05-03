<?php

namespace App\Http\Controllers;

use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessfulResponse;
use App\Mail\OrderAccepted;
use App\Models\DeliveryAddress;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Orders controller
 */
class OrdersController
{
    /**
     * Get all orders
     * @param string|null $status
     * @return JsonResponse|object
     */
    public function list(string $status = 'all'): JsonResponse
    {
        if ($status != 'all') {
            // In reality we should validate that we have status defined
            $orders = Orders::where('status', $status)->get();
        } else {
            $orders = Orders::all();
        }


        return (new SuccessfulResponse($orders))
            ->setMessage('All orders.')
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Create new order in a system
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function new(Request $request): JsonResponse
    {
        $products = $request->get('products');
        $validator = $this->validProducts($products);

        if ($validator && $validator->fails()) {
            return (new ErrorResponse())
                ->setErrors($validator->errors())
                ->setMessage('Invalid request has been sent.')
                ->response()
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $deliveryAddress = $request->get('delivery_address');
        $validator = $this->validDeliveryAddress($deliveryAddress);

        if ($validator && $validator->fails()) {
            return (new ErrorResponse())
                ->setErrors($validator->errors())
                ->setMessage('Invalid request has been sent.')
                ->response()
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $request->user();
        $deliveryAddress = DeliveryAddress::create($deliveryAddress);

        $order = new Orders();
        $order->user_id = $user->id;
        $order->delivery_address = $deliveryAddress->id;
        $order->status = 'pending';
        $order->save();

        $order->products()->attach($this->prepareProducts($products));

        return (new SuccessfulResponse($order))
            ->setMessage('Your order has been successfully created.')
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Accept order
     * @param int $id
     * @return JsonResponse|object
     */
    public function accept(int $id): JsonResponse
    {
        $order = Orders::findOrFail($id);
        $order->status = 'accepted';
        $order->save();

        $orderAccepted = new OrderAccepted($order->user);
        Mail::to($order->user->email)->send($orderAccepted);

        return (new SuccessfulResponse($order))
            ->setMessage('Your have successfully accepted order.')
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareProducts(array $data)
    {
        $products = [];
        foreach ($data as $product) {
            $products[$product['id']] = ['quantity' => $product['quantity']];
        }

        return $products;
    }

    /**
     * Validate all products
     * @param array $products
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validProducts(array $products): ?\Illuminate\Contracts\Validation\Validator
    {
        Validator::extend('quantitySize', function ($attribute, $value, $parameters, $validator) {
            return Products::where(['id' => $parameters[0]])->where('quantity', '>=', $value)->first() ? true : false;
        }, 'Product quantity is bigger then product is available.');

        foreach ($products as $product) {
            $validator = Validator::make($product, [
                'id' => 'required|exists:products',
                'quantity' => 'required|quantitySize:' . $product['id']
            ]);



            if ($validator->fails()) {
                return $validator;
            }
        }

        return null;
    }

    /**
     * Validate delivery address
     * @param array $deliveryAddress
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validDeliveryAddress(array $deliveryAddress): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($deliveryAddress, [
            'name' => 'required|max:255',
            'city' => 'required|max:255',
            'postcode' => 'required|max:255',
            'street' => 'required|max:255',
        ]);
    }
}
