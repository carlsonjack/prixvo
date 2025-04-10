var stripe = Stripe(stripe_vars.publishable_key);
function registerElements(elements, exampleName) {
  var form = document.querySelector('#uat-user-add-card');
  var error = form.querySelector('.error');
  var errorMessage = error.querySelector('.message');




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
  elements.forEach(function (element, idx) {
    element.on('change', function (event) {
      if (event.error) {
        error.classList.add('visible');
        savedErrors[idx] = event.error.message;
        errorMessage.innerText = event.error.message;
      } else {
        savedErrors[idx] = null;

        // Loop over the saved errors and find the first one, if any.
        var nextError = Object.keys(savedErrors)
          .sort()
          .reduce(function (maybeFoundError, key) {
            return maybeFoundError || savedErrors[key];
          }, null);

        if (nextError) {
          // Now that they've fixed the current error, show another one.
          errorMessage.innerText = nextError;
        } else {
          console.log('remove');
          console.log(error);
          // The user fixed the last error; no more errors.
          error.classList.remove('visible');
        }
      }
      console.log(savedErrors);
    });
  });

  // Listen on the form's 'submit' handler...
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    //  if (!jQuery(this).valid()){

    //    return false;

    //  }

    // Trigger HTML5 validation UI on the form if any of the inputs fail
    // validation.
    var plainInputsValid = true;
    Array.prototype.forEach.call(form.querySelectorAll('input'), function (
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


    var ownerInfo = {
      owner: {

      },
    };

    stripe.createSource(elements[0], ownerInfo).then(function (result) {
      console.log(result)
      if (result.error) {
        var errorElement = document.getElementById('uwa-card-errors');
        errorElement.textContent = result.error.message;
      } else {
        var uwa_stripe_k_id = result.source.id;

        jQuery.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajaxurl,
          data: {
            'action': 'uat_theme_ajaxregister_acount',
            'uwa_stripe_k_id': uwa_stripe_k_id
          },
          success: function (data) {
            console.log(data)
            error.classList.add('visible');
            errorMessage.innerText = data.message;
            if (data.card_added) {
              window.location.reload(true)
              
            } 
            //  jQuery("p.status-reg").html(data.message);
          }
        });
        e.preventDefault();
      }
    });
  });


}



/*3*/

(function () {
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