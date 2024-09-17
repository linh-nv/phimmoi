<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EpisodeRequest;
use App\Models\Episode;
use App\Services\Admin\EpisodeService;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EpisodeController extends Controller
{
    use ResponseHandler;

    protected $episodeService;

    public function __construct(EpisodeService $episodeService)
    {
        $this->episodeService = $episodeService;
    }

    /**
     * Display a listing of episodes by movie_id.
     */
    public function getByMovie(string $movieSlug): JsonResponse
    {
        try {
            $episodes = $this->episodeService->getEpisodesByMovie($movieSlug);

            return $this->responseSuccess(Response::HTTP_OK, $episodes);
        } catch (\Exception $e) {
            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $keyword = $request->query('keyword');

        try {
            $episodes = $this->episodeService->getPaginate($keyword);

            return $this->responseSuccess(Response::HTTP_OK, $episodes);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EpisodeRequest $request): JsonResponse
    {
        try {
            $episode = $this->episodeService->createEpisode($request->all());

            return $this->responseSuccess(Response::HTTP_CREATED, $episode);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Episode $episode): JsonResponse
    {
        try {
            $episode = $this->episodeService->getEpisodeById($episode);

            return $this->responseSuccess(Response::HTTP_OK, $episode);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EpisodeRequest $request, Episode $episode): JsonResponse
    {
        try {
            $episode = $this->episodeService->updateEpisode($episode, $request->all());

            return $this->responseSuccess(Response::HTTP_OK, $episode);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Episode $episode): JsonResponse
    {
        try {
            $this->episodeService->deleteEpisode($episode);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Remove the multi resource from storage.
     */
    public function destroyMultiple(Request $request): JsonResponse
    {
        $ids = $request->input('ids');

        try {
            $this->episodeService->destroyMultiple($ids);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }
}
