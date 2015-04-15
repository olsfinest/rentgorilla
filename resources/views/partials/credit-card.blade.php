    <div class="form-group row">
        <label for="cc-number" class="col-md-3 control-label">Credit Card Number:</label>

        <div class="col-md-8">
            <input type="text" id="cc-number" class="form-control input-md cc-number" data-stripe="number" placeholder="{{ is_null(Auth::user()->getLastFourCardDigits()) ? '' : '**** **** **** ' . Auth::user()->getLastFourCardDigits() }}" required>
        </div>
    </div>

    <!-- Expiration Date -->
    <div class="form-group row">
        <label class="col-md-3 control-label">Expiration Date:</label>

        <div class="col-md-3">
            {!! Form::selectMonth(null, null, ['class' => 'form-control cc-expiration-month', 'data-stripe' => 'exp-month']) !!}
         </div>

        <div class="col-md-2">
            {!! Form::selectRange(null, date('Y'), date('Y') + 10, null, ['class' => 'form-control cc-expiration-year', 'data-stripe' => 'exp-year']) !!}
        </div>
    </div>

    <!-- CVV Number -->
    <div class="form-group row">
        <label for="cvv" class="col-md-3 control-label" for="cc-cvv">CVV Number:</label>

        <div class="col-md-3">
            <input type="text" id="cvv" placeholder="" class="form-control" data-stripe="cvc" required>
        </div>
    </div>

    <div class="form-group row">
        <button type="submit" class="btn btn-primary">{{ $submitButtonText }}</button>
    </div>
