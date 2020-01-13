$(document).ready(function() {
        // DATATABLE
        $.extend($.fn.dataTable.defaults, {
            searching: false,
            paging: false,
            info: false
        })

        $('#searchDtable').DataTable({
            responsive: true,
            'columnDefs': [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            'select': {
                'style': 'multi'
            },
            'order': [
                [1, 'asc']
            ]
        })

        $('#example-getting-started').multiselect({
                includeSelectAllOption: true,
                selectAllValue: 'select-all-value'
            }) // TOOLTIP

        $('[data-toggle="tooltip"]').tooltip() // LIST(SEARCH>CREATELIST)

        $('#list_tags').selectize({
            // create: true,
            maxItems: 1,
            delimiter: ',',
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input
                }
            },
            options: [{
                value: 'avenger',
                text: 'Forbes Journalists'
            }, {
                value: 'caliber',
                text: 'Life/Health Journalists'
            }, {
                value: 'caravan-grand-passenger',
                text: 'Tech News Journalists'
            }]
        })
    })
    // # sourceMappingURL=search.js.map