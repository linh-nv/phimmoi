<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PremiereRoom;
use App\Repositories\PremiereRoom\PremiereRoomRepository;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PremiereRoomController extends Controller
{
    use ResponseHandler;

    protected $premiereRoomRepository;

    public function __construct(PremiereRoomRepository $premiereRoomRepository)
    {
        $this->premiereRoomRepository = $premiereRoomRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->premiereRoomRepository->getPaginate();

            return $this->responseSuccess(Response::HTTP_OK, $data);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $data = $this->premiereRoomRepository->create($request->all());

            return $this->responseSuccess(Response::HTTP_CREATED, $data);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function show(PremiereRoom $premiereRoom): JsonResponse
    {
        try {
            $premiereRoom->load(['movie', 'user', 'episode']);

            return $this->responseSuccess(Response::HTTP_OK, $premiereRoom);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PremiereRoom $premiereRoom): JsonResponse
    {
        try {
            $this->premiereRoomRepository->delete($premiereRoom);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }
}
