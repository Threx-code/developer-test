<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible", content="ie=edge">
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">
        <title></title>
    </head>
    <body class="bg-gray-200 w-full h-full font-sans">
        <div class="flex h-screen">
            <div class="m-auto">
                <h1 class="text-center pb-12 text-2xl font-bold">NewsLetter</h1>

                <form action="/subscribe" method="post">
                    @csrf
                    <input
                    type="text"
                    name="email"
                    placeholder="enter Email..." >

                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </body>
</html>
