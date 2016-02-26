<?php namespace RentGorilla\Composers;

use Carbon\Carbon;
use Input;
use RentGorilla\Rental;
use Session;
use DB;

class SearchFormComposer {

    //availability drop down shows max months that have active rentals in them
    const DROP_DOWN_MAX_MONTHS = 12;

    protected function getAvailability()
    {
        $query = DB::table('rentals')
            ->select(DB::raw('YEAR(available_at) as year, MONTH(available_at) as month_num, DATE_FORMAT(available_at, \'%b\') as month, count(*) as total'))
            ->where('active', 1)
            ->whereRaw('available_at >= DATE_FORMAT(NOW(), \'%Y-%m-01\')')
            ->where('location_id', session('location_id'))
            ->groupBy(DB::raw('YEAR(available_at), MONTH(available_at)'))
            ->skip(0)->take(self::DROP_DOWN_MAX_MONTHS + 1)
            ->get();

        $currentCount = Rental::where('available_at', '<=', Carbon::today())
            ->where('location_id', session('location_id'))
            ->where('active', 1)
            ->count();

        $availability = [];
        $availability[''] = 'Any Availability';
        $availability['current'] = sprintf('Today (%s)', $currentCount);

        foreach ($query as $index => $column) {
            if($index === self::DROP_DOWN_MAX_MONTHS) {
                $key = sprintf('%s-%s+', $column->month_num, $column->year);
                $value = sprintf('%s %s +', $column->month, $column->year, $column->total);
            } else {
                $key = sprintf('%s-%s', $column->month_num, $column->year);
                $value = sprintf('%s %s (%s)', $column->month, $column->year, $column->total);
            }
            $availability[$key] = $value;
        }

        return $availability;
    }

    public function compose($view)
    {
        $searchOptions = [

            'availability' => $this->getAvailability(),

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