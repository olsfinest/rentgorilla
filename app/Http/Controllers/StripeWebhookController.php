<?php namespace RentGorilla\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Laravel\Cashier\WebhookController;
use RentGorilla\Rental\RentalService;
use Carbon\Carbon;
use Log;

class StripeWebhookController extends WebhookController {

    /**
     * @var RentalService
     */
    protected $rentalService;

    /**
     * StripeWebhookController constructor.
     * @param RentalService $rentalService
     */
    function __construct(RentalService $rentalService)
    {
        $this->rentalService = $rentalService;
    }

    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        $billable = $this->getBillable($payload['data']['object']['customer']);

        if ($billable) {

            // deactivate plan locally if it is still active
            // this might be necessary if the subscription is cancelled from Stripe's end due to non-payment or cancelling via Stripe's UI
            if($billable->stripeIsActive()) {
                $billable->deactivateStripe();
            }

            $billable->setSubscriptionEndDate(Carbon::now());
            $billable->saveBillableInstance();

            // deactivate rentals with the possibility of eligibility for free rental
            $this->rentalService->deactivateRentalsForUser($billable);

            Log::info('Stripe webhook: customer subscription deleted', ['user_id' => $billable->id]);
        }

        return new Response('Webhook Handled', 200);
    }
}