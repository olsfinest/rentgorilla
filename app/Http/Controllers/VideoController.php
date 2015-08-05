<?php namespace RentGorilla\Http\Controllers;

use RentGorilla\Commands\ShowEmbeddedVideoCommand;
use RentGorilla\Commands\ToggleVideoLikeCommand;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;

use RentGorilla\Http\Requests\EmbeddedVideoRequest;
use RentGorilla\Http\Requests\FavouriteRequest;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Repositories\VideoLikesRepository;
use Auth;

class VideoController extends Controller {


    /**
     * @var VideoLikesRepository
     */
    private $likeRepository;

    public function __construct(VideoLikesRepository $likeRepository, RentalRepository $rentalRepository)
    {
        $this->middleware('auth', ['except' => 'getEmbeddedVideo']);
        $this->likeRepository = $likeRepository;
    }

    public function toggleLike(FavouriteRequest $favouriteRequest)
    {
        $like = $this->dispatchFrom(ToggleVideoLikeCommand::class, $favouriteRequest, ['user_id' => Auth::id()]);

        return response()->json($like);
    }

    public function getEmbeddedVideo(EmbeddedVideoRequest $embeddedVideoRequest)
    {
        $video = $this->dispatchFrom(ShowEmbeddedVideoCommand::class, $embeddedVideoRequest);

        if(Auth::check()) {
            $liked = $this->likeRepository->isLikedByUser(Auth::id(), $video['id']);
        } else {
            $liked = false;
        }

        $html = view('rental.video-player')->with('video', $video)->with('liked', $liked)->render();

        return response()->json(compact('html'));
    }
}
