<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieCommentRequest;
use App\Services\Client\MovieCommentService;
use App\Traits\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MovieCommentController extends Controller
{
    use ResponseHandler;

    protected $movieCommentService;

    public function __construct(MovieCommentService $movieCommentService)
    {
        $this->movieCommentService = $movieCommentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function getAll($slug): JsonResponse
    {
        try {
            $comments = $this->movieCommentService->getPaginate($slug);

            return $this->responseSuccess(Response::HTTP_OK, $comments);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(MovieCommentRequest $request): JsonResponse
    {
        try {
            $comment = $this->movieCommentService->createComment(collect($request->all()));

            return $this->responseSuccess(Response::HTTP_CREATED, $comment);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id): JsonResponse
    {
        try {
            if (!$delete = $this->movieCommentService->deleteComment($id)) {

                return $this->responseError(Response::HTTP_FORBIDDEN, 'FORBIDDEN', 'You do not have permission to delete this comment.');
            }

            return $this->responseSuccess(Response::HTTP_OK, $delete);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }
}
