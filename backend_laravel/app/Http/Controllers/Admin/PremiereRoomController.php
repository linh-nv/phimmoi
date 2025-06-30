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
            $data = PremiereRoom::where('isPublic', true)->with(['movie', 'user', 'episode'])->latest()->get();

            return $this->responseSuccess(Response::HTTP_OK, $data);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function getPrivateRoom(int $id): JsonResponse
    {
        try {
            $data = PremiereRoom::where('user_id', $id)->with(['movie', 'user', 'episode'])->latest()->get();

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
            $isExist = PremiereRoom::where('user_id', $request->input('user_id'))->where('status', true)->exists();

            if ($isExist) {
                return $this->responseError(Response::HTTP_BAD_REQUEST, 'HTTP_BAD_REQUEST', 'Bạn đã có phòng đang công chiếu!');
            }
            $data = $this->premiereRoomRepository->create($request->all());

            return $this->responseSuccess(Response::HTTP_CREATED, $data);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function show(string $code): JsonResponse
    {
        try {

            $premiereRoom = PremiereRoom::where('code', $code)->with(['movie', 'user', 'episode'])->firstOrFail();

            return $this->responseSuccess(Response::HTTP_OK, $premiereRoom);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function end(string $code): JsonResponse
    {
        try {
            $premiereRoom = PremiereRoom::where('code', $code)->update(['status' => false]);

            return $this->responseSuccess(Response::HTTP_OK, $premiereRoom);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(PremiereRoom $premiereRoom): JsonResponse
    {
        try {
            $this->premiereRoomRepository->delete($premiereRoom);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }
}
