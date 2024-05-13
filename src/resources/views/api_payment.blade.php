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

    <title>Laravel.Kejvin | Create Order</title>
</head>
<body class="mt-16 min-h-screen">F


<div class="h-1/5 w-1/2 mt-16">
    <div class="success-message text-lg text-center">
        {{ session('success') }}
    </div>
    <div class="error-message text-lg text-center">
        {{ session('error') }}
    </div>
</div>
<div class="h-4/5 w-1/3 flex-container">
    <div class="flex text-xl my-5">
        <p class="flex items-center justify-center text-2xl">{{ __('Purchase API Key') }}
        </p>
    </div>
    <form action="{{route('process.transaction')}}" class="h-1/2 flex flex-col w-full" method="get">
        <div class="h-1/3">
            <label for="name"
                   class="input input-bordered flex items-center gap-2 @error('name') input-error @enderror">
                <i class="fa-solid fa-cloud"></i>
                <input id="name" type="text" class="grow"
                       name="name" value="{{ old('name') }}" placeholder="API Name" required
                       autocomplete="name" autofocus>
            </label>
            @error('name')
            <div class="error-message text-lg text-center">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="h-1/3">
            <label for="email"
                   class="input input-bordered flex items-center gap-2 @error('email') input-error @enderror">
                <i class="fa-solid fa-envelope"></i>
                <input id="email" type="email" class="grow"
                       name="email" value="{{ old('email') }}" placeholder="E-mail" required
                       autocomplete="email">
            </label>
            @error('email')
            <div class="error-message text-lg text-center">
                {{$message}}
            </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-neutral rounded-3xl w-full text-[18px]" value="">Pay with <i
                class="fa-brands fa-paypal"></i> PayPal
        </button>
    </form>
</div>
</body>
</html>
