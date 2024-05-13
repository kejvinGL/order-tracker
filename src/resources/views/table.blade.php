<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}" data-theme='black'>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('/vendor/kejvingl/order-tracker/src/resources/css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <title>Laravel.Kejvin | Order List</title>
</head>
<body class="mt-16 min-h-screen">

<table id="ordersTable" class="display w-full lg:text-lg">
    @include('vendor.order-tracker.header')
</table>

<script>
    $(document).ready(function () {
        $('#ordersTable').DataTable({
            info: false,
            ajax: {
                url: 'orders/datatable',
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
                        dt.column(5).search("").draw();
                    },
                    className: 'btn',
                },
                {
                    text: 'Completed',
                    action: function (e, dt, node, config) {
                        dt.column(5).search("Completed").draw();
                    },
                    className: 'btn',
                },
                {
                    text: 'Cancelled',
                    action: function (e, dt, node, config) {
                        dt.column(5).search("Cancelled").draw();
                    },
                    className: 'btn',
                },
                {
                    text: 'Failed',
                    action: function (e, dt, node, config) {
                        dt.column(5).search("Failed").draw();
                    },
                    className: 'btn',
                },
                {
                    text: 'Processing',
                    action: function (e, dt, node, config) {
                        dt.column(5).search("Processing").draw();
                    },
                    className: 'btn',
                },
                {
                    text: 'Export as XLSX ',
                    action: function (e, dt, node, config) {
                        window.location.href = '/export/orders';
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
            order: false
        });
    });
</script>
</body>
</html>
