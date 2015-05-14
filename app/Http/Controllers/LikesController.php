<?php namespace RentGorilla\Http\Controllers;

use RentGorilla\Commands\ToggleLikeCommand;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RentGorilla\Http\Requests\LikeRequest;
use RentGorilla\Repositories\LikeRepository;
use Auth;

class LikesController extends Controller {

    /**
     * @var LikeRepository
     */
    private $likeRepository;

    public function __construct(LikeRepository $likeRepository)
    {
        $this->middleware('auth');
        $this->likeRepository = $likeRepository;
    }

    public function toggleLike(LikeRequest $likeRequest)
    {
        $like = $this->dispatchFrom(ToggleLikeCommand::class, $likeRequest, ['user_id' => Auth::id()]);

        return response()->json($like);

    }

}
