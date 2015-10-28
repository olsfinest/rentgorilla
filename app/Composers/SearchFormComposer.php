<?php namespace RentGorilla\Composers;

use Carbon\Carbon;
use Input;
use Session;

class SearchFormComposer {

    private function addMonths($monthsToAdd)
    {
        return Carbon::today()->addMonths($monthsToAdd)->format('M d');
    }

    public function compose($view)
    {
        $searchOptions = [

            'availability' =>

                ['' => 'Any Availability ',
                    '0-2' => 'Now - ' . $this->addMonths(2),
                    '2-4' => $this->addMonths(2) . ' - ' . $this->addMonths(4),
                    '4-6' => $this->addMonths(4) . ' - ' . $this->addMonths(6),
                    '6plus' => $this->addMonths(6) . ' +'],

            'type' =>

                ['' => 'Any Type',
                    'house' => 'House',
                    'apartment' => 'Apartment',
                    'room' => 'Room(s)'],

            'beds' =>

                ['' => 'Any Beds',
                    '1' => '1 Bedroom',
                    '2' => '2 Bedroom',
                    '3' => '3 Bedroom',
                    '4' => '4 Bedroom',
                    '5plus' => '5+ Bedrooms'],

            'price' =>

                ['' => 'Any Price',
                    'tier1' => '$0 - $299',
                    'tier2' => '$300 - $699',
                    'tier3' => '$700 - $999',
                    'tier4' => '$1000 - $1399',
                    'tier5' => '$1400+']
        ];

        $view->with(compact('searchOptions'));
    }

}