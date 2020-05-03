<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Products;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\BaseTest;

class ProductsControllerTest extends BaseTest
{
    /**
     * Test listing of all products
     */
    public function testListing()
    {
        $response = $this->json('GET', '/products');

        $response->seeStatusCode(Response::HTTP_OK);
        $response->seeJsonStructure([
            'data' => [],
            'success',
            'message',
        ]);

        $response->seeJsonContains([
            'success' => true,
            'message' => 'All products.',
        ]);
    }

    /**
     * Test adding new product when user is not authenticated
     */
    public function testAddingNewProductNonAuthenticated()
    {
        $data = [];
        $response = $this->json('PUT', '/products', $data);

        $response->seeStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test adding new product as regular user
     */
    public function testAddingNewProductAsRegularUser()
    {
        $data = [];
        $response = $this->actingAsUser()->json('PUT', '/products', $data);

        $response->seeStatusCode(Response::HTTP_FORBIDDEN);
    }

    /**
     * Test adding new product with invalid request
     */
    public function testAddingNewProductWithInvalidRequest()
    {
        $data = [];
        $response = $this->actingAsAdministrator()->json('PUT', '/products', $data);

        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->seeJsonStructure([
            'data',
            'errors',
            'success',
            'message',
        ]);

        $response->seeJsonContains([
            'success' => false,
            'message' => 'Invalid request has been sent.',
            'data' => [],
            'errors' => [
                'name' => ['The name field is required.'],
                'quantity' => ['The quantity field is required.']
            ]
        ]);
    }

    /**
     * Test adding new product in database
     */
    public function testAddingNewProduct()
    {
        $data = [
            'name' => 'Test product',
            'description' => 'Test product description',
            'quantity' => 10
        ];

        $response = $this->actingAsAdministrator()->json('PUT', '/products', $data);

        $response->seeStatusCode(Response::HTTP_CREATED);

        $response->seeJsonStructure([
            'data',
            'success',
            'message',
        ]);

        $response->seeJsonContains([
            'success' => true,
            'message' => 'Product has been successfully created.',
        ]);

        $this->seeInDatabase('products', [
            'name' => 'Test product',
            'description' => 'Test product description',
            'quantity' => 10
        ]);
    }

    /**
     * Test adding new product when user is not authenticated
     */
    public function testUpdatingProductNonAuthenticated()
    {
        $data = [];
        $product = Products::first();

        $response = $this->json('POST', '/products/' . $product->id, $data);

        $response->seeStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test adding new product as regular user
     */
    public function testUpdatingProductAsRegularUser()
    {
        $product = Products::first();
        $data = [];
        $response = $this->actingAsUser()->json('POST', '/products/' . $product->id, $data);

        $response->seeStatusCode(Response::HTTP_FORBIDDEN);
    }

    /**
     * Test update on non existing product
     */
    public function testNonExistingProduct()
    {
        $data = [
            'name' => 'Test product',
            'description' => 'Test product description',
            'quantity' => 10
        ];

        $response = $this->actingAsAdministrator()->json('POST', '/products/' . 1111, $data);

        $response->seeStatusCode(Response::HTTP_NOT_FOUND);
    }

    /**
     * Test adding new product with invalid request
     */
    public function testUpdatingProductWithInvalidRequest()
    {
        $product = Products::first();
        $data = [];
        $response = $this->actingAsAdministrator()->json('POST', '/products/' . $product->id, $data);

        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->seeJsonStructure([
            'data',
            'errors',
            'success',
            'message',
        ]);

        $response->seeJsonContains([
            'success' => false,
            'message' => 'Invalid request has been sent.',
            'data' => [],
            'errors' => [
                'name' => ['The name field is required.'],
                'quantity' => ['The quantity field is required.']
            ]
        ]);
    }

    /**
     * Test adding new product in database
     */
    public function testUpdatingProduct()
    {
        $product = Products::first();

        $data = [
            'name' => 'Test product',
            'description' => 'Test product description',
            'quantity' => 10
        ];

        $response = $this->actingAsAdministrator()->json('POST', '/products/' . $product->id, $data);

        $response->seeStatusCode(Response::HTTP_OK);

        $response->seeJsonStructure([
            'data',
            'success',
            'message',
        ]);

        $response->seeJsonContains([
            'success' => true,
            'message' => 'Product has been successfully updated.',
        ]);

        $this->seeInDatabase('products', [
            'id' => $product->id,
            'name' => 'Test product',
            'description' => 'Test product description',
            'quantity' => 10
        ]);
    }

    /**
     * Test removing product from database
     */
    public function testRemovingProduct()
    {
        $product = Products::first();

        $response = $this->actingAsAdministrator()->json('DELETE', '/products/' . $product->id);

        $response->seeStatusCode(Response::HTTP_OK);
    }

    /**
     * Test removing product from database
     */
    public function testRemovingNonExistingProduct()
    {
        $response = $this->actingAsAdministrator()->json('DELETE', '/products/' . 11111);

        $response->seeStatusCode(Response::HTTP_NOT_FOUND);
    }
}
