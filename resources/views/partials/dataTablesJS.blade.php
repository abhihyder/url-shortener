<script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')}}"></script>

<script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/jszip.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/buttons.print.min.js')}}"></script>

<script>
    const dataTableDom = '<"d-flex justify-content-between align-items-center mx-0 row"<"col-6 d-flex"l><"col-6"<"float-right"B>>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>';

    const dataTableDomWithFilter = '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6 d-flex"l<"ml-2 mt-1 dt-action-buttons text-right"B>><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>';

    const dataTableDisplayLength = localStorage.getItem('datatable_length');
    const dataTableLengthMenu = [10, 25, 50, 75, 100, 200];

    const dataTableButtons = [{
        extend: 'collection',
        className: 'btn btn-outline-secondary btn-sm dropdown-toggle',
        text: feather.icons['share'].toSvg({
            class: 'font-small-4 mr-50'
        }) + 'Export',
        buttons: [{
                extend: 'print',
                text: feather.icons['printer'].toSvg({
                    class: 'font-small-4 mr-50'
                }) + 'Print',
                className: 'dropdown-item',
            },
            {
                extend: 'csv',
                text: feather.icons['file-text'].toSvg({
                    class: 'font-small-4 mr-50'
                }) + 'Csv',
                className: 'dropdown-item',
            },
            {
                extend: 'excel',
                text: feather.icons['file'].toSvg({
                    class: 'font-small-4 mr-50'
                }) + 'Excel',
                className: 'dropdown-item',
            },
            {
                extend: 'pdf',
                text: feather.icons['clipboard'].toSvg({
                    class: 'font-small-4 mr-50'
                }) + 'Pdf',
                className: 'dropdown-item',
            },
            {
                extend: 'copy',
                text: feather.icons['copy'].toSvg({
                    class: 'font-small-4 mr-50'
                }) + 'Copy',
                className: 'dropdown-item',
            }
        ],
    }];
    const dataTableButtonsWhenHasAction = [{
        extend: 'collection',
        className: 'btn btn-outline-secondary btn-sm dropdown-toggle',
        text: feather.icons['share'].toSvg({
            class: 'font-small-4 mr-50'
        }) + 'Export',
        buttons: [{
                extend: 'print',
                text: feather.icons['printer'].toSvg({
                    class: 'font-small-4 mr-50'
                }) + 'Print',
                className: 'dropdown-item',
                exportOptions: {
                    columns: ':visible :not(:last-child)'
                }
            },
            {
                extend: 'csv',
                text: feather.icons['file-text'].toSvg({
                    class: 'font-small-4 mr-50'
                }) + 'Csv',
                className: 'dropdown-item',
                exportOptions: {
                    columns: ':visible :not(:last-child)'
                }
            },
            {
                extend: 'excel',
                text: feather.icons['file'].toSvg({
                    class: 'font-small-4 mr-50'
                }) + 'Excel',
                className: 'dropdown-item',
                exportOptions: {
                    columns: ':visible :not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                text: feather.icons['clipboard'].toSvg({
                    class: 'font-small-4 mr-50'
                }) + 'Pdf',
                className: 'dropdown-item',
                exportOptions: {
                    columns: ':visible :not(:last-child)'
                }
            },
            {
                extend: 'copy',
                text: feather.icons['copy'].toSvg({
                    class: 'font-small-4 mr-50'
                }) + 'Copy',
                className: 'dropdown-item',
                exportOptions: {
                    columns: ':visible :not(:last-child)'
                }
            }
        ],
    }];
</script>