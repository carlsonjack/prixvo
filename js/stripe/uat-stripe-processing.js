var stripe = Stripe(stripe_vars.publishable_key);
function registerElements(elements, exampleName) {
  var formClass = '.' + exampleName;
  var example = document.querySelector(formClass);

  var form = example.querySelector('form');
  var resetButton = example.querySelector('a.reset');
  var error = form.querySelector('.error');
  var errorMessage = error.querySelector('.message');

  function enableInputs() {
    Array.prototype.forEach.call(
      form.querySelectorAll(
        "input[type='text'], input[type='email'], input[type='tel']"
      ),
      function(input) {
        // input.removeAttribute('disabled');
      }
    );
  }

  function disableInputs() {
    Array.prototype.forEach.call(
      form.querySelectorAll(
        "input[type='text'], input[type='email'], input[type='tel']"
      ),
      function(input) {
        // input.setAttribute('disabled', 'true');
      }
    );
  }

  function triggerBrowserValidation() {
    // The only way to trigger HTML5 form validation UI is to fake a user submit
    // event.
    var submit = document.createElement('input');
    submit.type = 'submit';
    submit.style.display = 'none';
    form.appendChild(submit);
    submit.click();
    submit.remove();
  }

  // Listen for errors from each Element, and show error messages in the UI.
  var savedErrors = {};
  elements.forEach(function(element, idx) {
    element.on('change', function(event) {
      if (event.error) {
        error.classList.add('visible');
        savedErrors[idx] = event.error.message;
        errorMessage.innerText = event.error.message;
      } else {
        savedErrors[idx] = null;

        // Loop over the saved errors and find the first one, if any.
        var nextError = Object.keys(savedErrors)
          .sort()
          .reduce(function(maybeFoundError, key) {
            return maybeFoundError || savedErrors[key];
          }, null);

        if (nextError) {
          // Now that they've fixed the current error, show another one.
          errorMessage.innerText = nextError;
        } else {
          // The user fixed the last error; no more errors.
          error.classList.remove('visible');
        }
      }
    });
  });

  // Listen on the form's 'submit' handler...
  form.addEventListener('submit', function(e) {
    e.preventDefault();
	   if (!jQuery(this).valid()){

		   return false;

	   }

    // Trigger HTML5 validation UI on the form if any of the inputs fail
    // validation.
    var plainInputsValid = true;
    Array.prototype.forEach.call(form.querySelectorAll('input'), function(
      input
    ) {
      if (input.checkValidity && !input.checkValidity()) {
        plainInputsValid = false;
        return;
      }
    });
    if (!plainInputsValid) {
      triggerBrowserValidation();
      return;
    }

    // Show a loading screen...
    example.classList.add('submitting');

    // Disable all inputs.
    disableInputs();

    // Gather additional customer data we may have collected in our form. 
  var name = jQuery('#signonname').val();
  var email = jQuery('#email').val();
	var address1 = jQuery('#billing_address_1').val();
	var city = jQuery('#billing_city').val();
	var state = jQuery('#billing_state').val();
	var zip = jQuery('#billing_postcode').val();
	var firstName = jQuery('#reg_billing_first_name').val();
	var lastName = jQuery('#reg_billing_last_name').val();

	
	var name = firstName+' '+lastName;
	
  var ownerInfo = {
    owner: {			
      name: name ? name.value : undefined,
      email: email ? email.value : undefined,
      address_line1: address1 ? address1.value : undefined,
      address_city: city ? city.value : undefined,
      address_state: state ? state.value : undefined,
      address_zip: zip ? zip.value : undefined,
    },
  };
    
	stripe.createSource(elements[0], ownerInfo).then(function(result) {
				if (result.error) {
				  var errorElement = document.getElementById('uwa-card-errors');
				  errorElement.textContent = result.error.message;
				} else {
					var username = email.replace(/[^a-zA-Z0-9]+/g, '-');

				
				    jQuery('p.status-reg').text(ajax_auth_object.loadingmessage);
            var switchPlan = jQuery("input[name='switchPlan']:checked").val();	
						var cardNumber = jQuery("input[name=cardNumber]").val();
						var cardExpiry = jQuery("input[name=cardExpiry]").val();
						var cardCvc = jQuery("input[name=cardCvc]").val();					
						var password = jQuery('#signonpassword').val();
						var email = jQuery('form#uat-user-register-form #email').val();
						var username = email.replace(/@.*$/, "").replace(/[^a-zA-Z0-9.-]+/g, '-');
						var fullName = jQuery('#signonname').val();						
						var firstName = jQuery('#reg_billing_first_name').val();
						var lastName = jQuery('#reg_billing_last_name').val();
						var billing_country = jQuery('#billing_country').val();
						var billing_address_1 = jQuery('#billing_address_1').val();
						var billing_address_2 = jQuery('#billing_address_2').val();
						var billing_city = jQuery('#billing_city').val();
						var billing_state = jQuery('#billing_state').val();
						var billing_postcode = jQuery('#billing_postcode').val();
						var billing_phone = jQuery('#billing_phone').val();
						var uwa_stripe_k_id = result.source.id;
						var ctrl = jQuery(this);
						if (firstName === undefined) {
							firstName = username;
						}
            if (switchPlan === undefined) {
              switchPlan = 'Buyer';
            }
					jQuery.ajax({
						type: 'POST',
						dataType: 'json',
						url: ajax_auth_object.ajaxurl,
						data: {
							'action': 'uat_theme_ajaxregister',
							'cardNumber': cardNumber,
							'cardExpiry': cardExpiry,
							'cardCvc': cardCvc,
							'username': username,
							'password': password,
							'billing_country': billing_country,
							'billing_address_1': billing_address_1,
							'billing_address_2': billing_address_2,
							'billing_city': billing_city,
							'billing_state': billing_state,
							'billing_postcode': billing_postcode,
							'billing_phone': billing_phone,
							'email': email,
							'firstName': firstName,
							'lastName': lastName,
							'security': security,
              'switchPlan': switchPlan,
							'uwa_stripe_k_id': uwa_stripe_k_id
						},
						success: function (data) {
							 jQuery("p.status-reg").html(data.message);
               e.preventDefault();	
               //alert('stripe');
							if (data.loggedin == true) {
								jQuery('#uat-register-form').hide();
                jQuery('#my-acc-btn').hide();
								jQuery('#uat-login-form-success').show();
                //document.location.href = ajax_auth_object.redirecturl;
								//window.location.reload(true)
							}
						}
					});
					e.preventDefault();
				}
			  });
  });

  resetButton.addEventListener('click', function(e) {
    e.preventDefault();
    // Resetting the form (instead of setting the value to `''` for each input)
    // helps us clear webkit autofill styles.
    form.reset();

    // Clear each Element.
    elements.forEach(function(element) {
      element.clear();
    });

    // Reset error state as well.
    error.classList.remove('visible');

    // Resetting the form does not un-disable inputs, so we need to do it separately:
    enableInputs();
    example.classList.remove('submitted');
  });
}



/*3*/

(function() {
  'use strict';

  var elements = stripe.elements({
    fonts: [
      {
        cssSrc: 'https://fonts.googleapis.com/css?family=Quicksand',
      },
    ],
    // Stripe's examples are localized to specific languages, but if
    // you wish to have Elements automatically detect your user's locale,
    // use `locale: 'auto'` instead.
    locale: window.__exampleLocale,
  });

  var elementStyles = {
    base: {
      color: '#000',
      fontWeight: 600,
      fontFamily: 'Quicksand, Open Sans, Segoe UI, sans-serif',
      fontSize: '16px',
      fontSmoothing: 'antialiased',

      ':focus': {
        color: '#424770',
      },

      '::placeholder': {
        color: '#9BACC8',
      },

      ':focus::placeholder': {
        color: '#CFD7DF',
      },
    },
    invalid: {
      color: '#000',
      ':focus': {
        color: '#FA755A',
      },
      '::placeholder': {
        color: '#FFCCA5',
      },
    },
  };

  var elementClasses = {
    focus: 'focus',
    empty: 'empty',
    invalid: 'invalid',
  };

  var cardNumber = elements.create('cardNumber', {
    style: elementStyles,
    classes: elementClasses,
  });
  cardNumber.mount('#example3-card-number');

  var cardExpiry = elements.create('cardExpiry', {
    style: elementStyles,
    classes: elementClasses,
  });
  cardExpiry.mount('#example3-card-expiry');

  var cardCvc = elements.create('cardCvc', {
    style: elementStyles,
    classes: elementClasses,
  });
  cardCvc.mount('#example3-card-cvc');

  registerElements([cardNumber, cardExpiry, cardCvc], 'example3');
})();