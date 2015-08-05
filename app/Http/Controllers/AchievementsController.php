<?php namespace RentGorilla\Http\Controllers;

use Illuminate\Support\MessageBag;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Repositories\UserRepository;
use RentGorilla\User;
use Stripe\InvoiceItem;

class AchievementsController extends Controller {


    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var UserMailer
     */
    protected $mailer;

    function __construct(UserRepository $userRepository, UserMailer $mailer)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    public function showRedeemForm()
    {
        return view('rewards.show');
    }

    public function redeemPoints()
    {

        if( Auth::user()->points < User::POINT_REDEMPTION_THRESHOLD || ! Auth::user()->stripeIsActive()) {
            $messages = new MessageBag();
            $messages->add('Error', 'You must have earned at least ' . User::POINT_REDEMPTION_THRESHOLD . ' points and be an active subscriber to redeem them.');
            return redirect()->back()->withErrors($messages);
        }

        $points =  Auth::user()->getPointsReadyToRedeem();
        $credit =  Auth::user()->getPointsMonetaryValue();

        try {

            InvoiceItem::create([
                'customer' => Auth::user()->getStripeId(),
                'amount' => Auth::user()->getStripeDiscount(),
                'currency' => 'cad',
                'description' => 'Redeemed ' . $points . ' points'
            ]);

            $this->userRepository->redeemPoints(Auth::user());

            $this->mailer->sendPointsRedeemed(Auth::user(), $points, $credit);

        } catch (\Exception $e) {
            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);
        }

        return redirect()->back()->with('flash:success', 'Your points have been redeemed!');
    }

}
