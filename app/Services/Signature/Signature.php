<?php namespace RentGorilla\Services\Signature;

class Signature
{
    public function sign(array $data)
    {
        return hash_hmac('sha256', $this->concatenateData($data), config('app.key'));
    }

    public function validate(array $data, $signature)
    {
        return hash_equals($this->sign($data), $signature);
    }

    private function concatenateData(array $data)
    {
        return implode('', $data);
    }
}