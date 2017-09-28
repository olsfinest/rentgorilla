(function(){
    var StripeBilling = {
        init: function() {
            this.form = $('#cc-form');
            this.submitButton = this.form.find('button[type=submit]');
            this.submitButtonText = this.submitButton.html();
            var stripeKey = $('meta[name="publishable-key"]').attr('content');
            Stripe.setPublishableKey(stripeKey);

            this.bindEvents();
        },

        bindEvents: function() {
            this.form.on('submit', $.proxy(this.sendToken, this));
        },

        sendToken: function(event) {
            event.preventDefault();
            this.submitButton.html('One Moment').prop('disabled', true);
            Stripe.createToken(this.form, $.proxy(this.stripeResponseHandler, this));
        },

        stripeResponseHandler: function(status, response) {

            if(response.error){
                $('.payment-errors').show().text(response.error.message);
                return this.submitButton.prop('disabled', false).html(this.submitButtonText);
            }

            $('<input>', {
                type: 'hidden',
                name: 'stripe_token',
                value: response.id
            }).appendTo(this.form);


            this.form[0].submit();

        }


    };


    StripeBilling.init();


})();