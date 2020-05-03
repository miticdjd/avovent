<?php

namespace App\Http\Controllers;

use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessfulResponse;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Products controller
 */
class ProductsController
{
    /**
     * Return list of all products
     */
    public function list(): JsonResponse
    {
        $products = Products::all();

        return (new SuccessfulResponse($products))
            ->setMessage('All products.')
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Insert new product in database
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return (new ErrorResponse())
                ->setErrors($validator->errors())
                ->setMessage('Invalid request has been sent.')
                ->response()
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product = Products::create($request->all());

        return (new SuccessfulResponse($product))
            ->setMessage('Product has been successfully created.')
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Updated existing product in database
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return (new ErrorResponse())
                ->setErrors($validator->errors())
                ->setMessage('Invalid request has been sent.')
                ->response()
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product = Products::findOrFail($id);
        $product->update($request->all());

        return (new SuccessfulResponse($product))
            ->setMessage('Product has been successfully updated.')
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove existing product from database
     * @param int $id
     * @return JsonResponse|object
     */
    public function remove(int $id)
    {
        Products::findOrFail($id)->delete();

        return (new SuccessfulResponse())
            ->setMessage('Product is successfully deleted.')
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Validate request
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validateRequest(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'quantity' => 'required|int'
        ]);
    }
}
