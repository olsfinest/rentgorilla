<label for="cc-number" class="">Credit Card Number:
    <input type="text" id="cc-number" class="" data-stripe="number" placeholder="{{ is_null(Auth::user()->getLastFourCardDigits()) ? '' : '**** **** **** ' . Auth::user()->getLastFourCardDigits() }}" required>
</label>

<label class="half left">Expiration Month:
    {!! Form::selectMonth(null, null, ['class' => '', 'data-stripe' => 'exp-month']) !!}
</label>

<label class="half right">Expiration year:
    {!! Form::selectRange(null, date('Y'), date('Y') + 10, null, ['class' => '', 'data-stripe' => 'exp-year']) !!}
</label>
<!-- CVV Number -->
<label for="cvv" class="" for="cc-cvv">CVV Number:
    <input type="text" id="cvv" placeholder="" class="form-control" data-stripe="cvc" required>
</label>

<button type="submit" class="">{{ $submitButtonText }}</button>
