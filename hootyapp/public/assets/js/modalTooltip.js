jQuery(document).ready(function() {
    // TOOLTIP

    $('[data-toggle="tooltip"]').tooltip();

    $('#getstarted').click(function() {
        $('#wizardModal').modal('show');
        setTimeout(function() {
            $('#firstModal').modal('toggle');
        }, 50);
    });
    $('#secondModal').modalSteps({
        btnCancelHtml: 'Cancel',
        btnNextHtml: 'Next',
        btnLastStepHtml: 'Skip',
        disableNextButton: false,
        completeCallback: function() {
            var cname = $('#campaignName').val()
            window.location.href = '/message/create?title=' + cname + '';
        },
        callbacks: {
            '2': function() {
                FxoMessenger.create();
                let counter = 0;
                setTimeout(function() {
                    console.log($('#campaignName').val());
                    $('#fxo-messenger-iframe').parent().hide();
                    FxoMessenger.on('stateChanged', function(state) {
                        if (state === 'connected' && counter == 0) {
                            FxoMessenger.sendMessage("Start chat", {
                                userName: userName,
                                user_id: user_id,
                                campaignName: $('#campaignName').val()
                            });
                            counter++;
                        }
                    });
                })
            }
        },
        getTitleAndStep: function() {

        }
    });
});