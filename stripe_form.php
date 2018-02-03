<html><head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet">
<style media="screen">
body, html {
  height: 100%;
  background-color: #f7f8f9;
  color: #6b7c93;
}

*, label {
  font-family: "Helvetica Neue", Helvetica, sans-serif;
  font-size: 16px;
  font-variant: normal;
  padding: 0;
  margin: 0;
  -webkit-font-smoothing: antialiased;
}

button {
  border: none;
  border-radius: 4px;
  outline: none;
  text-decoration: none;
  color: #fff;
  background: #32325d;
  white-space: nowrap;
  display: inline-block;
  height: 40px;
  line-height: 40px;
  padding: 0 14px;
  box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
  border-radius: 4px;
  font-size: 15px;
  font-weight: 600;
  letter-spacing: 0.025em;
  text-decoration: none;
  -webkit-transition: all 150ms ease;
  transition: all 150ms ease;
  float: left;
  margin-left: 12px;
  margin-top: 28px;
}

button:hover {
  transform: translateY(-1px);
  box-shadow: 0 7px 14px rgba(50, 50, 93, .10), 0 3px 6px rgba(0, 0, 0, .08);
  background-color: #43458b;
}

form {
  padding: 30px;
  height: 120px;
}

label {
  font-weight: 500;
  font-size: 14px;
  display: block;
  margin-bottom: 8px;
}

#card-errors {
  height: 20px;
  padding: 4px 0;
  color: #fa755a;
}

.form-row {
  width: 70%;
  float: left;
}

.token {
  color: #32325d;
  font-family: 'Source Code Pro', monospace;
  font-weight: 500;
}

.wrapper {
  width: 670px;
  margin: 0 auto;
  height: 100%;
}

#stripe-token-handler {
  position: absolute;
  top: 0;
  left: 25%;
  right: 25%;
  padding: 20px 30px;
  border-radius: 0 0 4px 4px;
  box-sizing: border-box;
  box-shadow: 0 50px 100px rgba(50, 50, 93, 0.1),
    0 15px 35px rgba(50, 50, 93, 0.15),
    0 5px 15px rgba(0, 0, 0, 0.1);
  -webkit-transition: all 500ms ease-in-out;
  transition: all 500ms ease-in-out;
  transform: translateY(0);
  opacity: 1;
  background-color: white;
}

#stripe-token-handler.is-hidden {
  opacity: 0;
  transform: translateY(-80px);
}

/**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  background-color: white;
  height: 40px;
  padding: 10px 12px;
  border-radius: 4px;
  border: 1px solid transparent;
  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
</style>
</head>

<body>
  <div class="wrapper">
  <script src="https://js.stripe.com/v3/"></script>

  <form action="process_appointment_fee.php" method="post" id="payment-form">
    <div class="form-row">
      <label for="card-element">
        Credit or debit card
      </label>
      <div id="card-element" class="StripeElement StripeElement--empty"><div class="__PrivateStripeElement" style="margin: 0px !important; padding: 0px !important; border: none !important; display: block !important; background: transparent !important; position: relative !important; opacity: 1 !important;"><iframe frameborder="0" allowtransparency="true" scrolling="no" name="__privateStripeFrame3" allowpaymentrequest="true" src="https://js.stripe.com/v3/elements-inner-card-8f705a784c63da95d56e72ed5e7fb263.html#style[base][color]=%2332325d&amp;style[base][lineHeight]=18px&amp;style[base][fontFamily]=%22Helvetica+Neue%22%2C+Helvetica%2C+sans-serif&amp;style[base][fontSmoothing]=antialiased&amp;style[base][fontSize]=16px&amp;style[base][::placeholder][color]=%23aab7c4&amp;style[invalid][color]=%23fa755a&amp;style[invalid][iconColor]=%23fa755a&amp;componentName=card&amp;wait=false&amp;rtl=false&amp;features[noop]=false&amp;origin=https%3A%2F%2Fstripe.com&amp;referrer=https%3A%2F%2Fstripe.com%2Fdocs%2Fstripe-js%2Felements%2Fquickstart&amp;controllerId=__privateStripeController0" title="Secure payment input frame" style="border: none !important; margin: 0px !important; padding: 0px !important; width: 1px !important; min-width: 100% !important; overflow: hidden !important; display: block !important; height: 18px;"></iframe><input class="__PrivateStripeElement-input" aria-hidden="true" style="border: none !important; display: block !important; position: absolute !important; height: 1px !important; top: 0px !important; left: 0px !important; padding: 0px !important; margin: 0px !important; width: 100% !important; opacity: 0 !important; background: transparent !important;"></div></div>

      <!-- Used to display form errors -->
      <div id="card-errors" role="alert"></div>
    </div>

    <button>Submit Payment</button>
  </form>
  </div>
  <div id="stripe-token-handler" class="is-hidden">Success! Got token: <span class="token"></span></div>


<script type="text/javascript">
  // Create a Stripe client
  var stripe = Stripe('pk_test_bsurFIJUqWZllRz2lqjTcwKq');

  // Create an instance of Elements
  var elements = stripe.elements();

  // Custom styling can be passed to options when creating an Element.
  // (Note that this demo uses a wider set of styles than the guide below.)
  var style = {
    base: {
      color: '#32325d',
      lineHeight: '18px',
      fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
      fontSmoothing: 'antialiased',
      fontSize: '16px',
      '::placeholder': {
        color: '#aab7c4'
      }
    },
    invalid: {
      color: '#fa755a',
      iconColor: '#fa755a'
    }
  };

  // Create an instance of the card Element
  var card = elements.create('card', {style: style});

  // Add an instance of the card Element into the `card-element` <div>
  card.mount('#card-element');

  // Handle real-time validation errors from the card Element.
  card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
      displayError.textContent = event.error.message;
    } else {
      displayError.textContent = '';
    }
  });

  // Handle form submission
  var form = document.getElementById('payment-form');
  var ownerInfo = {
  owner: {
    // name: 'Jenny Rosen',
    // address: {
    //   line1: 'Nollendorfstraße 27',
    //   city: 'Berlin',
    //   postal_code: '10777',
    //   country: 'DE',
    // },
    // email: 'jenny.rosen@example.com'
  },
};
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createSource(card, ownerInfo).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the source to your server
      stripeSourceHandler(result.source);
    }
  });
});

  var successElement = document.getElementById('stripe-token-handler');
  document.querySelector('.wrapper').addEventListener('click', function() {
    successElement.className = 'is-hidden';
  });

    function stripeSourceHandler(source) {
        var form = document.getElementById('payment-form');
          var hiddenInput = document.createElement('input');
          hiddenInput.setAttribute('type', 'hidden');
          hiddenInput.setAttribute('name', 'stripeSource');
          hiddenInput.setAttribute('value', source.id);
          form.appendChild(hiddenInput);

          var hiddenInput = document.createElement('input');
          hiddenInput.setAttribute('type', 'hidden');
          hiddenInput.setAttribute('name', 'stripeFunding');
          hiddenInput.setAttribute('value', source.card.funding);
          form.appendChild(hiddenInput);
          
          // successElement.className = '';
          // successElement.querySelector('.token').textContent = source.card.funding;
          form.submit();
    }

</script><iframe frameborder="0" allowtransparency="true" scrolling="no" name="__privateStripeController0" allowpaymentrequest="true" src="https://js.stripe.com/v3/controller-5b824584ba2135d3f6205672405446a4.html#apiKey=pk_test_bsurFIJUqWZllRz2lqjTcwKq&amp;stripeJsId=ffb3e0ff-fe01-4451-b93b-ab2e55e5e2ab&amp;features[noop]=false&amp;origin=https%3A%2F%2Fstripe.com&amp;referrer=https%3A%2F%2Fstripe.com%2Fdocs%2Fstripe-js%2Felements%2Fquickstart&amp;controllerId=__privateStripeController0" aria-hidden="true" tabindex="-1" style="border: none !important; margin: 0px !important; padding: 0px !important; width: 1px !important; min-width: 100% !important; overflow: hidden !important; display: block !important; visibility: hidden !important; position: fixed !important; height: 1px !important; pointer-events: none !important;"></iframe>


  <iframe frameborder="0" allowtransparency="true" scrolling="no" name="__privateStripeMetricsController4" allowpaymentrequest="true" src="https://js.stripe.com/v2/m/outer.html#url=https%3A%2F%2Fstripe.com%2Fdocs%2Fstripe-js%2Felements%2Fquickstart&amp;title=&amp;referrer=&amp;muid=0a29787c-d902-49c9-8838-bc51c6fbf1fe&amp;sid=54b96f84-4404-46ce-9ccd-3ae9a0bb2185&amp;preview=true" aria-hidden="true" tabindex="-1" style="border: none !important; margin: 0px !important; padding: 0px !important; width: 1px !important; min-width: 100% !important; overflow: hidden !important; display: block !important; visibility: hidden !important; position: fixed !important; height: 1px !important; pointer-events: none !important;"></iframe></body></html>