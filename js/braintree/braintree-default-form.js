
jQuery(document).ready(function ($) {
	var form = $('form');
  var CLIENT_TOKEN_FROM_SERVER = braintree_vars.source_key;
  var button = document.querySelector('#submit-button');
  stupBraintree();
  jQuery("#uwa_braintree_k_id").val("");
  
  function stupBraintree()
  {
    var bt = "";
    braintree.client.create({
      authorization: braintree_vars.source_key
    }, function(err, clientInstance) {
      if (err) {
        console.error(err);
        return;
      }
      console.log(clientInstance);
  
      braintree.hostedFields.create({
        client: clientInstance,
        styles: {
          'input': {
            'font-size': '16px',
            'font-family': 'roboto, verdana, sans-serif',
            'font-weight': 'lighter',
            'color': 'black',
          },
          ':focus': {
            'color': 'black'
          },
          '.valid': {
            'color': 'green'
          },
          '.invalid': {
            'color': 'red'
          }
        },
        fields: {
          number: {
            container: '#example3-card-number',
            placeholder: '1111 1111 1111 1111'
          },
          cvv: {
            container: '#example3-card-cvc',
            placeholder: '111'
          },
          expirationDate: {
            container: '#example3-card-expiry',
            placeholder: 'MM/YY'
          }
        }
      }, function(err, hostedFieldsInstance) {
        if (err) {
          return;
        }
        bt = hostedFieldsInstance;
  
        function createInputChangeEventListener(element) {
          return function () {
            validateInput(element);
          }
        }
  
        function setValidityClasses(element, validity) {
          if (validity) {
            element.removeClass('is-invalid');
            element.addClass('is-valid');  
          } else {
            element.addClass('is-invalid');
            element.removeClass('is-valid');  
          }    
        }
        
        function validateInput(element) {
          if (!element.val().trim()) {
            setValidityClasses(element, false);
            return false;
          }
          setValidityClasses(element, true);
          return true;
        }
        var ccName = $('#cc-name');

        hostedFieldsInstance.on('validityChange', function(event) {
          var field = event.fields[event.emittedBy];
          $(field.container).removeClass('is-valid');
          $(field.container).removeClass('is-invalid');
  
          if (field.isValid) {
            $(field.container).addClass('is-valid');
          } else if (field.isPotentiallyValid) {
          } else {
            $(field.container).addClass('is-invalid');
          }
        });
  
        hostedFieldsInstance.on('cardTypeChange', function(event) {
          var cardBrand = $('#card-brand');
          var cvvLabel = $('[for="example3-card-cvc"]');
  
          if (event.cards.length === 1) {
            var card = event.cards[0];
            cardBrand.text(card.niceType);
            cvvLabel.text(card.code.name);
          } else {
            cardBrand.text('Card');
            cvvLabel.text('CVV');
          }
        });
       
  
        $("form#registerform").submit(function(e) {
           var uwa_braintree_k_id_ =  jQuery("#uwa_braintree_k_id").val();
           if(uwa_braintree_k_id_ == ""){
               e.preventDefault();           
                var formIsInvalid = false;
                var state = hostedFieldsInstance.getState();
                var errorElement = document.querySelector('.status-reg');
                errorElement.textContent = "";
                Object.keys(state.fields).forEach(function(field) {
                    if (!state.fields[field].isValid) {
                    $(state.fields[field].container).addClass('is-invalid');
                    formIsInvalid = true;
                    }
                });
        
                if (formIsInvalid) {
                    errorElement.textContent = braintree_vars.invalid_card_details_msg;
                    e.preventDefault();
                    return false;
                }
        
                hostedFieldsInstance.tokenize(function(err, payload,e) {
                    if (err) {
                    return false;
                    }
                    var uwa_braintree_k_id = payload.nonce
                    jQuery("#uwa_braintree_k_id").val(uwa_braintree_k_id);
                    if(uwa_braintree_k_id == ""){
                    //   e.preventDefault();
                    errorElement.textContent = braintree_vars.invalid_card_details_msg;
                    return false;
                    }
                    var f =  $(this);
                    console.log(uwa_braintree_k_id)
                    $("form#registerform").off('submit').submit();
                    return false;
                
                });
            }
        });
      });
    });
  }
});