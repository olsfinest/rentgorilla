<?php namespace RentGorilla\Tasks\Daily;

use DB;
use RentGorilla\Rewards\PowerPromoter;
use Log;

class ClearPromotionsHistory {

    public function clear(){

       if($result = DB::table('promotions')
           ->whereRaw('DATEDIFF(NOW(), created_at) > ' . PowerPromoter::MIN_DAYS)
           ->delete()) {
           Log::info('Promotions table cleared.');
       }

        return $result;

    }

}