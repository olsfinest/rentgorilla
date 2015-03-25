<?php namespace RentGorilla\Plans\Company;

use RentGorilla\Plans\Plan;

abstract class Company extends Plan {
	
	public function rentalPropertyTypes() {
		return ['Commercial', 'House', 'Apartment'];
	}

}