<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}" data-theme="{{session('theme')}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('/vendor/kejvingl/order-tracker/src/resources/css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.7/b-3.0.2/b-html5-3.0.2/datatables.min.css"
          rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.7/b-3.0.2/b-html5-3.0.2/datatables.min.js"></script>
</head>
<body class="overflow-hidden p-10">
<h1>Orders Report ({{ now()->format('d/m/y') }})</h1>
@foreach($orders->chunk(40) as $chunk)
    <table class="table table-auto table-xs text-xs">
        <thead>
        <tr>
            <th class="text-[10px]">{{'Name'}}</th>
            <th class="text-[10px]">{{'Email'}}</th>
            <th class="text-[10px]">{{'Product'}}</th>
            <th class="text-[10px]">{{'External ID'}}</th>
            <th class="text-[10px]">{{'Price'}}</th>
            <th class="text-[10px]">{{'Status'}}</th>
            <th class="text-[10px]">{{'Error Message'}}</th>
            <th class="text-[10px]">{{'Created At'}}</th>
            <th class="text-[10px]">{{'Last Updated'}}</th>
        </tr>
        </thead>

        <tbody>
        @foreach($chunk as $order)
            @include('components.order-list.row', $order)
        @endforeach
        </tbody>
    </table>
    @if (!$loop->last)
        @pageBreak
    @endif
@endforeach
</body>
</html>
