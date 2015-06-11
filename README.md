# LaravelPagseguro

## Instruções

Esse pacote utiliza a lib phpsc/pagseguro, gerando um ServiceProvider para aplicações Laravel 5.

## Instalação

Rode: composer require wesleywillians/laravel-pagseguro

Adicione o seguinte service provider em seu arquivo config/app.php:

```php
'providers' => [
    //...
    'LaravelPagseguro\LaravelPagseguroServiceProvider'
]
```

Rode o seguinte comando no artisan:

```bash
php artisan vendor:publish
```

Edite o arquivo *config/pagseguro.php*, entrando com o ambiente, email e token de sua conta pagseguro.

## Exemplo de utilização básica

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use PHPSC\PagSeguro\Items\Item;
use PHPSC\PagSeguro\Requests\Checkout\CheckoutService;


class PagseguroController extends Controller
{
    public function index(CheckoutService $checkoutService)
    {

        $checkout = $checkoutService->createCheckoutBuilder()
            ->addItem(new Item(1, 'Televisão LED 500', 8999.99))
            ->addItem(new Item(2, 'Video-game mega ultra blaster', 799.99))
            ->getCheckout();

        $response = $checkoutService->checkout($checkout);

        redirect($response->getRedirectionUrl());

    }
}
````



    
