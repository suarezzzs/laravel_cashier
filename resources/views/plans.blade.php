<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Cashier</title>
    <link rel="stylesheet" href="{{ asset("assets/bootstrap/bootstrap.min.css") }}">
</head>

<body>

    <div class="container my-5">
        <p class="display-6 text-center my-5">Laravel Cashier (Stripe)</p>
        <hr>
            <div class="text-center">
                Usuário: <strong class="text-info">{{ auth()->user()->name }}</strong>
                <a href="{{ route("logout") }}" class="btn btn-danger btn-sm ms-3">Sair</a>
            </div>
        <hr>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="col-4 p-3">
                <div class="border border-2 rounded-3 border-secondary p-5 text-center">
                    <h3>Plano Mensal</h1>
                    <hr>
                    <h1 class="text-center text-white">9.99$ / mês</h4>
                    <a href="{{route("plan.selected", ["id" => $prices["montly"]])}}" class="btn btn-secondary mt-3 w-100">ASSINAR</a>
                </div>
            </div>
            
            <div class="col-4 p-3">
                <div class="border border-5 rounded-3 border-success p-5 text-center bg-black">
                    <h3>Plano Anual</h1>
                    <hr>
                    <h1 class="text-center text-white">49.99$ / ano</h4>
                    <a href="{{route("plan.selected", ["id" => $prices["yearly"]])}}" class="btn btn-success mt-3 w-100">ASSINAR</a>
                    <p class="text-center text-warning mt-3">Mais Popular</p>
                </div>
            </div>
            
            <div class="col-4 p-3">
                <div class="border border-2 rounded-3 border-warning p-5 text-center text-center">
                    <h3>Plano Tri Anual</h1>
                    <hr>
                    <h1 class="text-center text-white">100.99$</h4>
                    <a href="{{route("plan.selected", ["id" => $prices["longest"]])}}" class="btn btn-warning mt-3 w-100">ASSINAR</a>
    
                </div>
            </div>
            
        </div>
    </div>

</body>

</html>