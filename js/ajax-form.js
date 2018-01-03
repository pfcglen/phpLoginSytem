jQuery(document).ready(function () {
    // Variable to hold request
    var request;

// Bind to the submit event of our form
    $(".register-form").submit(function (event) {

        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();

        //loading animation
        jQuery('<span id="submitloader"></span>').appendTo('.register-form');

        // Abort any pending request
        if (request) {
            request.abort();
        }
        // setup some local variables
        var $form = $(this);

        // Let's select and cache all the fields
        var $inputs = $form.find(".form-control");

        // Serialize the data in the form
        var serializedData = $form.serialize();

        // Let's disable the inputs for the duration of the Ajax request.
        // Note: we disable elements AFTER the form data has been serialized.
        // Disabled form elements will not be serialized.
        $inputs.prop("disabled", true);

        // Fire off the request to /register.php
        request = jQuery.ajax({
            url: jQuery(this).attr('action'),
            type: "POST",
            data: serializedData,
            processData: false,  // tell jQuery not to process the data
            contentType: false   // tell jQuery not to set contentType
        });

        // Callback handler that will be called on success
        request.done(function (response) {
            // Log a message to the console
            console.log("Hooray, it worked!");
            console.log(response);
            jQuery('#submitloader').remove();
            jQuery('.login-page').prepend('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Holy guacamole!</strong> You should check in on some of those fields below. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');

        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
                    "The following error occurred: " +
                    textStatus, errorThrown
                    );
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
    });
});//end of ready