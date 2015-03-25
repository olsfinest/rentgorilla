<?php namespace RentGorilla\Composers;

class SearchFormComposer {

    public function compose($view)
    {
       $searchOptions = [

           'availability' =>

               ['' => 'Availability',
                '0-2' => '0-2 Months',
                '2-4' => '2-4 Months',
                '4-6' => '4-6 Months',
                '6plus' => '6+ Months'],

           'type' =>

               ['' => 'Type',
                'house' => 'House',
                'apartment' => 'Apartment',
                'room' => 'Room'],

           'beds' =>

               ['' => 'Beds',
                '1' => '1 Bedroom',
                '2' => '2 Bedroom',
                '3' => '3 Bedroom',
                '4' => '4 Bedroom',
                '5plus' => '5+ Bedrooms'],

           'price' =>

               ['' => 'Price',
               'tier1' => '$0 - $299',
               'tier2' =>'$300 - $699',
               'tier3' =>'$700 - $999',
               'tier4' =>'$1000 - $1399',
               'tier5' =>'$1400+']
       ];

        $view->with(compact('searchOptions'));
    }

}