<?php

namespace App\Repositories\MovieComment;

use App\Models\MovieComment;
use App\Repositories\BaseRepository;
use App\Util\Constants;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieCommentRepository extends BaseRepository implements MovieCommentRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return MovieComment::class;
    }

    public function getComments(int $movieId): LengthAwarePaginator
    {
        return $this->_model->where('movie_id', $movieId)
            ->with(relations: 'user')
            ->paginate(perPage: Constants::PER_PAGE);
    }

    public function deleteComment(MovieComment $movieComment): bool|null
    {

        return $movieComment->delete();
    }
}
