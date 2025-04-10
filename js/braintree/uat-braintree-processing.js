
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
            'color': 'black'
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
        $(document).on("click","form#uat-user-register-form .reset",function(e){
          e.preventDefault();
          $("form#uat-user-register-form")[0].reset();
          hostedFieldsInstance.clear('number');
          hostedFieldsInstance.clear('cvv');
          hostedFieldsInstance.clear('expirationDate');
        });
  
        $("form#uat-user-register-form").submit(function(e) {
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
              e.preventDefault();
              errorElement.textContent = braintree_vars.invalid_card_details_msg;
              return false;
            }
            console.log(uwa_braintree_k_id)
            if(uwa_braintree_k_id != ""){
             
            jQuery("p.status-reg").text(ajax_auth_object.loadingmessage);
            var password = jQuery('#signonpassword').val();
            var email = jQuery('form#uat-user-register-form #email').val();
            var username = email.replace(/@.*$/,"");
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
            var ctrl = jQuery(this);
			if (firstName === undefined) {
				firstName = username;
			}
            jQuery.ajax({
              type: 'POST',
              dataType: 'json',
              url: ajax_auth_object.ajaxurl,
              data: {
                'action': 'uat_theme_ajaxregister',
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
                'uwa_braintree_k_id': uwa_braintree_k_id
              },
              success: function (data) {
                jQuery("p.status-reg").html(data.message);
                //alert('brain');
                if (data.loggedin == true) {
                  
                  jQuery('#uat-register-form').hide();
                  jQuery('#my-acc-btn').hide();
                  jQuery('#uat-login-form-success').show(); 
                  /*document.location.href = ajax_auth_object.redirecturl;
                  window.location.reload(true)*/
                }
              }
              
            });
            
          }
          });
        });
      });
    });
    console.log(bt);
  }
});
