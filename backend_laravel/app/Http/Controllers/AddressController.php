<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Services\AddressService;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Messages\ResponseMessages;

class AddressController extends Controller
{
    use ResponseHandler;

    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');

        try {
            $addresss = $this->addressService->getPaginate($keyword);

            return $this->responseSuccess(Response::HTTP_OK, $addresss);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('RETRIEVE_ERROR'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request): JsonResponse
    {
        try {
            $address = $this->addressService->createAddress($request->all());

            return $this->responseSuccess(Response::HTTP_CREATED, $address);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('CREATE_ERROR'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address): JsonResponse
    {
        try {
            $address = $this->addressService->getAddressById($address);

            return $this->responseSuccess(Response::HTTP_OK, $address);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('RETRIEVE_ERROR'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressRequest $request, Address $address): JsonResponse
    {
        try {
            $address = $this->addressService->updateAddress($address, $request->all());

            return $this->responseSuccess(Response::HTTP_OK, $address);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('UPDATE_ERROR'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address): JsonResponse
    {
        try {
            $this->addressService->deleteAddress($address);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('DELETE_ERROR'));
        }
    }

    /**
     * Remove the multi resource from storage.
     */
    public function destroyMultiple(Request $request): JsonResponse
    {
        $ids = $request->input('ids');

        try {
            $this->addressService->destroyMultiple($ids);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {
            
            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('DELETE_ERROR'));
        }
    }
}
