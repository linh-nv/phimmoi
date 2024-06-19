<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EpisodeRequest;
use App\Messages\ResponseMessages;
use App\Models\Episode;
use App\Services\EpisodeService;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EpisodeController extends Controller
{
    use ResponseHandler;

    protected $episodeService;

    public function __construct(EpisodeService $episodeService)
    {
        $this->episodeService = $episodeService;
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

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('RETRIEVE_ERROR'));
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

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('CREATE_ERROR'));
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

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('RETRIEVE_ERROR'));
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

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('UPDATE_ERROR'));
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
            $this->episodeService->destroyMultiple($ids);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('DELETE_ERROR'));
        }
    }
}
