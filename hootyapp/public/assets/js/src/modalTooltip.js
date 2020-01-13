jQuery(document).ready(function() {
    // TOOLTIP



    $('#getstarted').click(function() {
        $('#wizardModal').modal('show');
        setTimeout(function() {
            $('#firstModal').modal('toggle');
        }, 50);
    });
    $('#secondModal').modalSteps({
        btnCancelHtml: 'Cancel',
        btnNextHtml: 'Next',
        btnLastStepHtml: 'Complete',
        disableNextButton: false,
        completeCallback: function() {
            // window.location.href = 'compose.html';
        },
        callbacks: {},
        getTitleAndStep: function() {}
    });

    $('[data-toggle="tooltip"]').tooltip();
});