$(function () {
    // Toggle SMS Gateway Settings Form
    $(document).on("click", '[data-bb-toggle="toggle-setting-form"]', function (t) {
        t.preventDefault();
        $(t.currentTarget)
            .closest(".sms-gateway")
            .find(".sms-gateway-content")
            .slideToggle(); // Toggle visibility of the settings form
    });

    // Change SMS Gateway Status
    $(document).on("click", '[data-bb-toggle="change-status"]', function (t) {
        t.preventDefault();
        var button = $(t.currentTarget);

        $httpClient
            .make()
            .withButtonLoading(button)
            .post(button.data("url")) // Send POST request to the URL in data-url
            .then(function (response) {
                var data = response.data;

                // Show success message
                Botble.showSuccess(data.message);

                if (data.data.activated) {
                    // If gateway is activated:
                    button.hide(); // Hide the current button
                    button.siblings('[data-bb-toggle="toggle-setting-form"]').show(); // Show the toggle button
                    button.closest(".sms-gateway").find(".sms-gateway-content").slideDown(); // Show the settings form
                } else {
                    // If gateway is deactivated:
                    button.closest(".sms-gateway").find('[data-bb-toggle="toggle-setting-form"]').hide(); // Hide the toggle button
                    button.closest(".sms-gateway").find('[data-bb-toggle="change-status"]').show(); // Show the current button
                    button.closest(".sms-gateway").find(".sms-gateway-content").slideUp(); // Hide the settings form
                }
            });
    });

    // Submit SMS Gateway Form
    $(document).on("submit", ".sms-gateway-form", function (t) {
        t.preventDefault();
        var form = $(t.currentTarget);
        var submitButton = $(t.originalEvent.submitter);

        $httpClient
            .make()
            .withButtonLoading(submitButton)
            .post(form.prop("action"), form.serialize()) // Send form data via POST
            .then(function (response) {
                var data = response.data;
                Botble.showSuccess(data.message); // Show success message
            });
    });

    // Handle Test SMS Modal
    $(document).on("show.bs.modal", "#test-sms-modal", function (t) {
        var modal = $(t.currentTarget);
        var triggerButton = $(t.relatedTarget);

        // Set the gateway value in the modal form
        modal.find('[name="gateway"]').val(triggerButton.data("gateway"));
    });

    // Submit Test SMS Modal Form
    $(document).on("submit", "#test-sms-modal form", function (t) {
        t.preventDefault();
        var form = $(t.currentTarget);
        var modal = form.closest(".modal");
        var submitButton = form.find('button[type="submit"]');

        $httpClient
            .make()
            .withButtonLoading(submitButton)
            .post(form.prop("action"), form.serialize()) // Send form data via POST
            .then(function (response) {
                var data = response.data;
                Botble.showSuccess(data.message); // Show success message
                modal.modal("hide"); // Hide the modal
            })
            .catch(function (error) {
                if (error.response.status === 200) {
                    modal.modal("hide"); // Hide the modal if the response status is 200
                }
            });
    });
});