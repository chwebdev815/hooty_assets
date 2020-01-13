// summernote
jQuery(document).ready(function() {
        $('#list-tags').selectize({
            plugins: ['remove_button'],
            delimiter: ',',
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input
                }
            }
        })

        var HelloButton = function(context) {
            var ui = $.summernote.ui;

            // create button
            var button = ui.button({
                contents: '<i class="fa fa-star"/> Hello',
                tooltip: 'hello',
                click: function() {
                    // invoke insertText method with 'hello' on editor module.
                    context.invoke('editor.insertText', 'hello');
                }
            });

            return button.render(); // return button as jquery object
        }

        $('#summernote').summernote({
            placeholder: 'Type here',
            tabsize: 2,
            height: 80,
            toolbar: [
                ['mybutton', ['hello']]
            ],
            buttons: {
                hello: HelloButton
            }
        });

    })
    // # sourceMappingURL=compose.js.map