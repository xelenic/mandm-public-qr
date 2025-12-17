
$(document).ready(function () {

    toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "timeOut": "3000"
    };

    const input = document.querySelector("#mobile_number");
    let iti;

      // Skip intlTelInput for plain inputs (e.g., Personal Details box wants no country selector UI)
      if (input && input.getAttribute('data-no-iti') === '1') {
        iti = null;
      } else if (input) {
        iti = window.intlTelInput(input, {
          initialCountry: "sg",
          // Remove country code dropdown / flag UI
          allowDropdown: false,
          showFlags: false,
          separateDialCode: false,
          formatOnDisplay: true,
          nationalMode: false,
           autoPlaceholder: "off",
          utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js"
        });
      }


  // Generate years dynamically
  const startYear = 1950;
  const currentYear = new Date().getFullYear();

  for (let y = currentYear; y >= startYear; y--) {
    $("#year").append(new Option(y, y));
  }


    const savedDob = getCookie("dob");
    if (savedDob) {
        var dobField = document.getElementById("dob");
        if (dobField) {
            dobField.value = savedDob;
        }
    }

    function getCookie(name) {
        const value = "; " + document.cookie;
        const parts = value.split("; " + name + "=");
        if (parts.length === 2) return parts.pop().split(";").shift();
        return null;
    }


    $('#detail-form').on('submit', function(e) {
        e.preventDefault();

        let valid = true;
        $(this).find('.error-message').remove();
        $(this).removeClass('invalid');

        // define addError function
        function addError($field, message) {
            $field.addClass('invalid');
            $field.next('.error-message').remove();
            $field.after('<span class="error-message">' + message + '</span>');
        }

        $(this).find('input[type="text"], input[type="email"], input[type="tel"], textarea, input[type="checkbox"]').each(function() {
            let $field = $(this);
            let fieldName = $field.attr('name');
            let value = $field.val().trim();
            $('.form-error-message').remove();
            // Required check
            if (
                ($field.is(':checkbox') && !$field.is(':checked')) ||
                (!$field.is(':checkbox') && !value)
            ) {
                valid = false;
                addError($field.parent(), 'This field is required');
                return;
            }

            if ($field.attr('type') === 'email') {
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    valid = false;
                    addError($field, 'Please enter a valid email address');
                }
            }

            if (fieldName === 'number' || fieldName === 'mobile_number') {
                let mobileRegex = /^[0-9]{8,12}$/;
                if (!mobileRegex.test(value)) {
                    valid = false;
                    addError($field, 'Please enter a valid mobile number (8-12 digits)');
                }
            }
        });

        if (!valid) {
            return false;
        }

        let $form = $(this);
        let $button = $form.find('button[type="submit"]');
        $button.find('#step1_text').hide();
        $button.find('#step1_spinner').show();
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'save_details',
                form_data: $(this).serialize(),
                full_number: iti.getNumber(),
                _ajax_nonce: ajax_object.nonce
            },
            beforeSend: function() {
                $('.error-text').remove();
                $('.error-message').remove();
                $('#form-messages').remove();
                $button.find('#step1_text').hide();
                $button.find('#step1_spinner').show();
            },
            success: function(response) {
                $button.find('#step1_text').show();
                $button.find('#step1_spinner').hide();

               if (response.success) {
                   // Clear stored values for #detail-form
                    $('#detail-form')[0].reset();
                    // document.cookie = "dob=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

                    document.querySelectorAll('#detail-form input').forEach(function(input) {

                         localStorage.removeItem(input.name);
                     });

                     //Optional: clear checkboxes if you used them
                     document.querySelectorAll('#detail-form input[type=checkbox]').forEach(function(input) {
                        localStorage.removeItem(input.name);
                     });
                    var successHtml = '<div id="form-messages" class="alert alert-success text-left">' +
                                        (response.data.message || "Details saved successfully!") +
                                      '</div>';
                    $('#detail-form').prepend(successHtml);

                     var $msg = $('#form-messages');
                    if ($msg.length) {
                        $('html, body').animate({
                            scrollTop: $msg.offset().top - 100
                        }, 1000);
                    }

                    setTimeout(function() {
                       window.location.reload();
                    }, 2000);

                } else if (response.data && response.data.errors) {
                    $.each(response.data.errors, function(field, message) {
                        var $input = $('[name="' + field + '"]');
                        if ($input.length) {
                            $input.after('<span class="error-message text-danger">' + message + '</span>');
                        }
                    });

                     var $msg = $('#form-messages');
                    if ($msg.length) {
                        $('html, body').animate({
                            scrollTop: $msg.offset().top - 100 // adjust offset for fixed headers
                        }, 1000); // 600ms = smooth speed
                    }
                } else {
                    var errorHtml = '<div id="form-messages" class="alert alert-danger text-left">' +
                                      (response.data && response.data.message ? response.data.message : "Unable to save details. Please check your input.") +
                                    '</div>';
                    $('#detail-form').prepend(errorHtml);
                     var $msg = $('#form-messages');
                    if ($msg.length) {
                        $('html, body').animate({
                            scrollTop: $msg.offset().top - 100 // adjust offset for fixed headers
                        }, 1000); // 600ms = smooth speed
                    }
                }
            },
            error: function() {
                $button.find('#step1_text').show();
                $button.find('#step1_spinner').hide();
                $button.find('#step1_text').show();
                $button.find('#step1_spinner').hide();

                // Show generic error row
                $('#form-messages').remove();
                var errorHtml = '<div id="form-messages" class="alert alert-danger text-left">' +
                                  "Something went wrong. Please try again." +
                                '</div>';
                $('#detail-form').prepend(errorHtml);
                var $msg = $('#form-messages');
                if ($msg.length) {
                    $('html, body').animate({
                        scrollTop: $msg.offset().top - 100 // adjust offset for fixed headers
                    }, 1000); // 600ms = smooth speed
                }
            }
        });

    });

    $('#redemption-form').on('submit', function(e) {
        e.preventDefault();

        let valid = true;
        $('#redemption-message').text(''); // clear old error

        // Simple validation
        if ($('#redemption').val().trim() === '') {
            $('#redemption-message').text('This field is required.');
            valid = false;
        }

        if (!valid) {
            return false;
        }

        let $form = $(this);
        let $button = $form.find('button[type="submit"]');
        $button.find('#setp2_text').hide();
        $button.find('#setp2_spinner').show();

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'submit_redemption',
                form_data: $form.serialize(),
                _ajax_nonce: ajax_object.nonce
            },
            beforeSend: function() {
                $button.find('#setp2_text').hide();
                $button.find('#setp2_spinner').show();
                $('#form-messages').remove(); // remove old general messages
            },
            success: function(response) {
                $button.find('#setp2_text').show();
                $button.find('#setp2_spinner').hide();

                if (response.success) {
                    // ✅ Success message above form
                    $form.prepend('<div id="form-messages" class="alert alert-success text-left">Redemption submitted successfully!</div>');

                    // Redirect after short delay
                    setTimeout(function() {
                        window.location.href = response.data.redirect_url;
                    }, 1200);

                } else {
                    // ❌ Error message above form
                    $form.prepend('<div id="form-messages" class="alert alert-danger text-left">' +
                        (response.data.message || "Something went wrong!") +
                    '</div>');
                }

                // Scroll to message
                let $msg = $('#form-messages');
                if ($msg.length) {
                    $('html, body').animate({
                        scrollTop: $msg.offset().top - 80
                    }, 600);
                }
            },
            error: function() {
                $button.find('#setp2_text').show();
                $button.find('#setp2_spinner').hide();

                $form.prepend('<div id="form-messages" class="alert alert-danger text-left">Server error! Please try again later.</div>');
            }
        });
    });


    $('#redemption').on('change keyup', function(){
        var code = $(this).val();
        var $input = $(this);
        var $status = $('#redemption-status');
        var $message = $('#redemption-message');
        $('#form-messages').remove();
        if(code.length === 0){
          $input.removeClass('valid invalid');
          $status.html('');
          $message.text('');
          return;
        }

        $.ajax({
          url: ajax_object.ajax_url,
          type: 'POST',
          data: {
            action: 'check_redemption_code',
            code: code
          },
          success: function(response){
            if(response.success){
              $input.removeClass('invalid').addClass('valid');
              $status.html('✔️'); // green check
              $message.removeClass('error').addClass('success');
            } else {
              $input.removeClass('valid').addClass('invalid');
              $status.html('❌'); // red cross
              $message.removeClass('success').addClass('error');
            }
          }
        });
      });



    $('#checkAge').on('click', function(){

        $('.error-msg').remove();
        let error = false;
        $('#month').next("label.text-danger").remove();
        $('#year').next("label.text-danger").remove();

        const month = document.getElementById("month").value;
        const year = document.getElementById("year").value;

        if (!month) {
            $('#month').after('<label class="text-danger error-msg">Choose a valid month!</label>');
            error = true;
        }

        if (!year) {
            $('#year').after('<label class="text-danger error-msg">Choose a valid year!</label>');
            error = true;
        }

        if (error) {
            return false;
        }

        const today = new Date();
        const birthDate = new Date(year, month - 1); // day not needed for age check
        let age = today.getFullYear() - birthDate.getFullYear();

        // Adjust if birthday hasn't occurred yet this year
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < 1)) {
          age--;
        }

        if (age < 14) {
          // Show modal
          const ageModal = new bootstrap.Modal(document.getElementById("ageModal"));
          ageModal.show();
        } else {
            var dob = month+'/'+year;
           setCookie('dob', dob, 1);


          window.location.href = base_url+'/campaign-details';
        }
    });

    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        startDate: new Date(),
        endDate: new Date('2026-01-15'),
        daysOfWeekDisabled: [0,6], // 0 = Sunday, 6 = Saturday
        beforeShowDay: function(date) {

            var today = new Date();
            // Disable today if time >= 5 PM

            if (
                date.getFullYear() === today.getFullYear() &&
                date.getMonth() === today.getMonth() &&
                date.getDate() === today.getDate() &&
                today.getHours() >= 17
            ) {
                return false; // disables the date
            }
            return true; // enables the date
        }
    });



    // Timepicker
   $('.timepicker').timepicker({
        timeFormat: 'h:mm p',   // 12-hour format with AM/PM
        interval: 30,           // steps of 30 minutes
        dynamic: false,
        dropdown: true,
        scrollbar: true,
        minTime: '10:00am',      // earliest time
        maxTime: '5:00pm'       // latest time
    });


     $("#pickup_form").on("submit", function (e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        // Remove old messages
        $("#pickup_form #form-messages").remove();

        $.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: formData + "&action=save_pickup_details",
            beforeSend: function () {
                form.find("button[type=submit]").prop("disabled", true);
                $('#pickup_text').hide();
                $('#pickup_spinner').show();
            },
            success: function (response) {
                if (response.success) {
                    // ✅ Show success message above form
                    form.prepend('<div id="form-messages" class="alert alert-success text-left">' +
                                 (response.data.message || "Data saved successfully!") +
                                 '</div>');
                    form[0].reset();

                    // Optional redirect after short delay
                    if (response.data.redirect_url) {
                        setTimeout(function() {
                            window.location.href = response.data.redirect_url;
                        }, 1200);
                    }

                } else {
                    // ❌ Show error message above form
                    form.prepend('<div id="form-messages" class="alert alert-danger text-left">' +
                                 (response.data.message || "Something went wrong!") +
                                 '</div>');
                }

                // Scroll to the message
                let $msg = $("#pickup_form #form-messages");
                if ($msg.length) {
                    $('html, body').animate({
                        scrollTop: $msg.offset().top - 80
                    }, 600);
                }
            },
            error: function () {
                form.prepend('<div id="form-messages" class="alert alert-danger text-left">Server error! Please try again later.</div>');
            },
            complete: function () {
                form.find("button[type=submit]").prop("disabled", false);
                $('#pickup_text').show();
                $('#pickup_spinner').hide();
            }
        });
    });


    $("#delivery_form").on("submit", function (e) {
        e.preventDefault(); // stop immediate submit
        $('.error-message').remove();
        let form = $(this);
        // Open confirmation modal
        var error = false;
        if($('#address').val() == ''){
            $('#address').after('<label class="error-message">Address field is required.</label>');
            error = true;
        }

        if($('#postal_code').val() == ''){
            $('#postal_code').after('<label class="error-message">Postal code field is required.</label>');
            error = true;
        }
        else if (!/^[0-9]{6}$/.test($('#postal_code').val())) {
            $('#postal_code').after('<label class="error-message">Postal code must be exactly 6 numbers.</label>');
            error = true;
        }

        if(error){
            return;
        }

        $('#confirm_address').text($('#address').val()+', '+$('#postal_code').val())
        $("#confirmSubmitModal").modal("show");

        // Handle confirmation
        $("#confirmSubmitBtn").off("click").on("click", function () {
            $("#confirmSubmitModal").modal("hide"); // close modal

            let formData = form.serialize();

            // Remove any previous messages
            $("#delivery_form #form-messages").remove();

            $.ajax({
                url: ajax_object.ajax_url,
                type: "POST",
                data: formData + "&action=save_delivery_details",
                beforeSend: function () {
                    form.find("button[type=submit]").prop("disabled", true);
                    $('#delivery_text').hide();
                    $('#delivery_spinner').show();
                },
                success: function (response) {
                    if (response.success) {
                        form.prepend('<div id="form-messages" class="alert alert-success text-left">' +
                            (response.data.message || "Data saved successfully!") +
                            '</div>');
                        form[0].reset();

                        if (response.data.redirect_url) {
                            setTimeout(function () {
                                window.location.href = response.data.redirect_url;
                            }, 1200);
                        }
                    } else {
                        form.prepend('<div id="form-messages" class="alert alert-danger text-left">' +
                            (response.data.message || "Something went wrong!") +
                            '</div>');
                    }

                    let $msg = $("#delivery_form #form-messages");
                    if ($msg.length) {
                        $('html, body').animate({
                            scrollTop: $msg.offset().top - 80
                        }, 600);
                    }
                },
                error: function () {
                    form.prepend('<div id="form-messages" class="alert alert-danger text-left">Server error! Please try again later.</div>');
                },
                complete: function () {
                    form.find("button[type=submit]").prop("disabled", false);
                    $('#delivery_text').show();
                    $('#delivery_spinner').hide();
                }
            });
        });
    });


    // $(document).on('keyup', '#redemption', function () {
    //     let val = $(this).val();
    //     if (val.length > 0) {
    //         $(this).val(val.charAt(0).toLowerCase() + val.slice(1));
    //     }
    // });

     $('#redeem_another_btn').on('click', function(e){
        e.preventDefault();

        var $btn = $(this);
        var winnerId = $btn.data('id');

        // Show spinner, disable button
        $btn.find('.spinner').show();
        $btn.prop('disabled', true);
        $('#form-messages').remove();
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url, // Localize this via wp_localize_script
            data: {
                action: 'redeem_another_code',
                winner_id: winnerId
            },
            success: function(response){
                if(response.success) {
                   window.location.href = response.data.redirect_url;
                } else {
                    $btn.after('<div id="form-messages" class="alert alert-danger text-left mt-3">' +
                                 (response.data.message || "Something went wrong!") +
                                 '</div>');
                }
            },
            error: function(){
                $btn.after('<div id="form-messages" class="alert alert-danger text-left mt-3">Server error! Please try again later.</div>');

            },
            complete: function(){
                // Hide spinner, re-enable button
                $btn.find('.spinner').hide();
                $btn.prop('disabled', false);
            }
        });
    });


        $('#utilise-later-btn').on('click', function() {
            var $btn = $(this);
            $('#form-messages').remove();
            // Toggle UI
            $btn.prop('disabled', true);
            $btn.find('.btn-text').hide();
            $btn.find('.spinner').show();
            var id = $btn.data('id');

            // AJAX request
            $.ajax({
              url: ajax_object.ajax_url, // WP Ajax endpoint
              type: 'POST',
              data: {
                action: 'utilize_later', // must match your PHP handler
                id: id
              },
              success: function(response) {
                console.log('Success:', response);
                // Restore button
                $btn.prop('disabled', false);
                $btn.find('.spinner').hide();
                $btn.find('.btn-text').show();


                if(response.success) {
                    $('.voucher-card').hide();
                    $('#voucher-message').show();
                } else {
                    $btn.after('<div id="form-messages" class="alert alert-danger text-left" style="float: left;width: 100%;">' +
                                 (response.data.message || "Something went wrong!") +
                                 '</div>');
                }
              },
              error: function(xhr, status, error) {
                $btn.prop('disabled', false);
                $btn.find('.spinner').hide();
                $btn.find('.btn-text').show();
                $btn.after('<div id="form-messages" class="alert alert-danger text-left mt-3">Server error! Please try again later.</div>');

              }
            });
          });
});

