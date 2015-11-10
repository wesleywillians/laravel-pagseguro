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

## Exemplo de notificação

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use PHPSC\PagSeguro\Purchases\Subscriptions\Locator as SubscriptionLocator;
use PHPSC\PagSeguro\Purchases\Transactions\Locator as TransactionLocator;


class PagseguroController extends Controller
{
    public function index(SubscriptionLocator $subscription, TransactionLocator $transaction)
    {
        try {
            $data = $request->all();

            $service = $data['notificationType'] == 'preApproval' ? $subscription : $transaction; // Cria instância do serviço de acordo com o tipo da notificação

            $purchase = $service->getByNotification($data['notificationCode']);

            return $purchase; // Exibe na tela a transação ou assinatura atualizada
        } catch (Exception $error) { // Caso ocorreu algum erro
            return $error->getMessage(); // Exibe na tela a mensagem de erro
        }
    }
}
````
