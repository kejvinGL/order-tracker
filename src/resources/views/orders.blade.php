<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}" data-theme='black'>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('/vendor/kejvingl/order-tracker/css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.7/b-3.0.2/b-html5-3.0.2/datatables.min.css"
          rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.7/b-3.0.2/b-html5-3.0.2/datatables.min.js"></script>

    <title>Laravel.Kejvin | Order List</title>
</head>
<body class="mt-16 min-h-screen">
<div class="error-message text-lg text-center">
    {{ session('error') }}
</div>
<table id="ordersTable" class="display w-full lg:text-lg">
    @include('vendor.order-tracker.header')
</table>

<script>
    $(document).ready(function () {
        $('#ordersTable').DataTable({
            info: false,
            ajax: {
                url: '{{route('get.orders.datatable')}}',
                type: 'get'
            },
            layout: {
                topStart: 'buttons'
            },
            buttons: [
                {
                    text: '<i class="fa-solid fa-rotate-right"></i>',
                    action: function (e, dt, node, config) {
                        dt.column(6).search("").draw();
                        dt.ajax.reload();
                    }
                },
                {
                    text: 'All',
                    action: function (e, dt, node, config) {
                        dt.column(6).search("").draw();
                    },
                    className: 'btn',
                },
                {
                    text: 'Completed',
                    action: function (e, dt, node, config) {
                        dt.column(6).search("Completed").draw();
                    },
                    className: 'btn',
                },
                {
                    text: 'Cancelled',
                    action: function (e, dt, node, config) {
                        dt.column(6).search("Cancelled").draw();
                    },
                    className: 'btn',
                },
                {
                    text: 'Failed',
                    action: function (e, dt, node, config) {
                        dt.column(6).search("Failed").draw();
                    },
                    className: 'btn',
                },
                {
                    text: 'Export as XLSX ',
                    action: function (e, dt, node, config) {
                        window.location.href = '/export/orders/xlsx';
                    },
                    className: 'btn',
                },
                {
                    text: 'Export as PDF ',
                    action: function (e, dt, node, config) {
                        window.open('/export/orders/pdf', '_blank').focus();
                    },
                    className: 'btn',
                },


            ],
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'product', name: 'product'},
                {data: 'external_id', name: 'external_id'},
                {data: 'price', name: 'price'},
                {data: 'status', name: 'status'},
                {data: 'error_message', name: 'error_message'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
            ],
            order: false,
            columnDefs: [
                {
                    targets: 5, // Targeting the 'status' column
                    createdCell: function (cell, cellData, rowData, row, col) {
                        switch (cellData) {
                            case 'Completed':
                                $(cell).addClass('bg-green-800')
                                break;
                            case 'Cancelled':
                                $(cell).addClass('bg-yellow-800');
                                break;
                            case 'Failed':
                                $(cell).addClass('bg-red-600');
                                break;
                            case 'Processing':
                                $(cell).addClass('bg-cyan-800');
                                break;
                            // Add more cases if needed
                        }
                    }
                }
            ]
        });
    });
</script>
</body>
</html>
