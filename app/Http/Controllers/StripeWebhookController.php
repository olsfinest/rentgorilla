<?php namespace RentGorilla\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Laravel\Cashier\WebhookController;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RentGorilla\Mailers\UserMailer;
use Log;

class StripeWebhookController extends WebhookController {


    /**
     * @var UserMailer
     */
    private $userMailer;

    function __construct(UserMailer $userMailer)
    {

        $this->userMailer = $userMailer;
    }

    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        $billable = $this->getBillable($payload['data']['object']['customer']);

        if ($billable && $billable->subscribed()) {

            $billable->subscription()->cancel();

            $this->userMailer->sendFailedSubscriptionPayment($billable);

            Log::info('Subscription payment failed and subscription was cancelled', ['user_id' => $billable->id]);
        }

        return new Response('Webhook Handled', 200);
    }

}
