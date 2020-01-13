$(document).ready(function() {
    // DATATABLE
    $.extend($.fn.dataTable.defaults, {
        searching: false,
        paging: false,
        info: false
    });

    var name = $("#search").val();
    var page = 1;
    var data = {
        'search': name,
        'page': page,
        'type': 'all'
    }
    var dataTableInitiated = false;
    var searchDtable;

    function initDataTable() {
        dataTableInitiated = true;
        $('#sectionTable').show();
        // $('#searchWidget').addClass('show');
        searchDtable = $('#searchDtable').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "columnDefs": [{
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        console.log(data);
                        return '<input type="checkbox" name="groups[]" value="' + $('<div/>').text(data).html() + '">';
                    }
                },
                { 'targets': 1, "data": "First_name" },
                { 'targets': 2, "data": "Last_name" },
                { 'targets': 3, "data": "Domain_name" }
            ],
            ajax: {
                // dataType: 'json',
                url: url + '/',
                "data": function(d) {
                    return $.extend(d, data);
                },
                dataSrc: function(json) {
                    $('.journalist-count').html(json.journalist_count);
                    return json.journalist
                }
            },
            'select': {
                'style': 'multi'
            },
            'order': [
                    [1, 'asc']
                ]
                // "columns": [
                //     { "data": "First_name" }

            // ]
        });
    }

    $(document).keypress(function(e) {
        if (e.which == 13) {
            name = $("#search").val();
            page = 1;
            data = {
                'search': name,
                'page': page,
                'type': 'all'
            }
            if (name == "") {
                return name
            } else {
                if (!dataTableInitiated) {
                    initDataTable()
                } else {
                    searchDtable.ajax.reload();
                }
            }

        }
    });


    $("#searchTableButton").click(function() {
        name = $("#search").val();
        page = 1;
        data = {
            'search': name,
            'page': page,
            'type': 'all'
        }
        if (name == "") {
            return name;
        } else {

            if (!dataTableInitiated) {
                initDataTable()
            } else {
                searchDtable.ajax.reload();
            }
        }


    });


    $('#select-all').on('click', function() {
        // Get all rows with search applied
        var rows = searchDtable.rows({ 'search': 'applied' }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    $('#searchDtable').on('change', 'input[type="checkbox"]', function() {
        // If checkbox is not checked
        if (!this.checked) {
            var el = $('#select-all').get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if (el && el.checked && ('indeterminate' in el)) {
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
            }
        }
    });

    // MULTI SELECT

    $('#example-getting-started').multiselect({
        includeSelectAllOption: true,
        selectAllValue: 'select-all-value'
    }); // TOOLTIP

    // $('[data-toggle="tooltip"]').tooltip(); // LIST(SEARCH>CREATELIST)

    $('#list_tags').selectize({
        // create: true,
        maxItems: 1,
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input
            };
        }
    });
}); // # sourceMappingURL=search.js.map
//# sourceMappingURL=search.js.ma