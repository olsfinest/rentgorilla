<?php namespace RentGorilla\Plans;

class Plan {

    protected $planId;
    protected $planName;
    protected $maximumListings;
    protected $totalYearlyCost;
    protected $interval;
    protected $isLegacy;

    public function setPlanName($planName)
    {
        $this->planName = $planName;
    }

    public function setPlanId($planId)
    {
        $this->planId = $planId;
    }

    public function id()
    {
        return $this->planId;
    }

    public function setMaximumListings($maximumListings)
    {
        $this->maximumListings = $maximumListings;
    }

    public function setTotalYearlyCost($totalYearlyCost)
    {
        $this->totalYearlyCost = $totalYearlyCost;
    }

    public function setInterval($interval)
    {
        $this->interval = $interval;
    }

    public function planName()
    {
        return $this->planName;
    }

    public function maximumListings()
    {
        return $this->maximumListings;
    }

    public function isYearly()
    {
        return $this->interval() === 'year';
    }

    public function isMonthly()
    {
        return $this->interval() === 'month';
    }

    public function totalYearlyCost()
    {
        return $this->totalYearlyCost;
    }

    public function monthlyBilledPrice()
    {
        return round($this->totalYearlyCost() / 12);
    }

    public function unlimited()
    {
        return $this->maximumListings() === 'unlimited';
    }

    public function interval()
    {
        return $this->interval;
    }

    public function intervalSuffix()
    {
        return ucfirst($this->interval) . 'ly';
    }

    public static function toDollars($cents, $dollarSign = false)
    {
        $dollars = number_format($cents / 100, 2);
        return $dollarSign ? '$' . $dollars : $dollars;
    }

    public function getNameAndPrice()
    {
        return $this->planName() . ' ($' . static::toDollars($this->monthlyBilledPrice()) . '/month)';
    }

    public function getPriceWithTax($monthly = false, $suffix = false)
    {
        if($this->isMonthly() || $monthly) {
            $price = $this->monthlyBilledPrice() * 1.15;
        } else {
            $price = $this->totalYearlyCost() * 1.15;
        }

        if($suffix) {
            return static::toDollars($price, true) . (($this->isMonthly() || $monthly) ? '/month' : '/year');
        } else {
            return static::toDollars($price, true);
        }
    }

    /**
     * @return boolean
     */
    public function isLegacy()
    {
        return $this->isLegacy;
    }

    /**
     * @param boolean $isLegacy
     */
    public function setIsLegacy($isLegacy)
    {
        $this->isLegacy = $isLegacy;
    }
}