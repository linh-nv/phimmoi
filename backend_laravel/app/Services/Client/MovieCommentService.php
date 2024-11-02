<?php

namespace App\Services\Client;

use App\Models\MovieComment;
use App\Repositories\MovieComment\MovieCommentRepository;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class MovieCommentService
{
    protected MovieCommentRepository $movieCommentRepository;

    public function __construct(MovieCommentRepository $movieCommentRepository)
    {
        $this->movieCommentRepository = $movieCommentRepository;
    }

    public function getPaginate(string $slug): LengthAwarePaginator
    {

        return $comments = $this->movieCommentRepository->getComments($slug);
    }

    public function createComment(Collection $data): MovieComment
    {

        return $this->movieCommentRepository->create([
            'movie_id' => $data['movie_id'],
            'user_id' => $data['user_id'],
            'comment' => $data['comment'],
            'parent_id' => $data['parent_id'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function deleteComment(int $commentId): bool|null
    {
        $movieComment = $this->movieCommentRepository->find($commentId);
        $user = Auth::guard('api')->user();

        if ($movieComment->user_id === $user->id) {
            return $this->movieCommentRepository->deleteComment($movieComment);
        }

        return false;
    }
}
