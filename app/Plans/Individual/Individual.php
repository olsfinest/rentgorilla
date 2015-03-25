<?php namespace RentGorilla\Plans\Individual;

use RentGorilla\Plans\Plan;

abstract class Individual extends Plan {
	
	public function rentalPropertyTypes() {
		return ['House', 'Apartment', 'Roomate'];
	}

}