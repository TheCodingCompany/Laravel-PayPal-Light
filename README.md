# Laravel-PayPal-Light
Laravel PayPal Light library for Google App Engine

# Installation using Composer

```
composer require thecodingcompany/laravel-paypal-light
```

# Examples

## Create Payment Example
```
require_once __DIR__.'/src/PayPalLight/HttpRequest.php';
require_once __DIR__.'/src/PayPalLight/PayPalLight.php';
require_once __DIR__.'/src/PayPalLight/PayPalPayment.php';
require_once __DIR__.'/src/PayPalLight/CreditCardPayment.php';
require_once __DIR__.'/src/PayPalLight/PayPalTransaction.php';

use CodingCompany\PayPal\PayPalPayment as PayPalPayment;
use CodingCompany\PayPal\PayPalTransaction as PayPalTransaction;

$p = new PayPalPayment(array(
    'client_id'         => 'AddMFxCjj3QgJZT4kYgrgegbfdbgthre9Qj24o_P8Ldag7yeu2A',
    'client_secret'     => 'EFNXQgBjL9PQO0ZeuC5_4567547y6htet5ert34435_tct4nFU7g'
));

$p->set_endpoint("https://api.paypal.com");

$transaction = new PayPalTransaction();
$transaction->amount = array(
    "total" => "1.00",
    "currency" => "USD"
);
$transaction->description = "PayPal transaction";
$p->set_transaction($transaction);

$p->set_return_url("http://localhost:8000/paypal/callback");
$p->set_cancel_url("http://localhost:8000/paypal/cancel");

$response = $p->authorize_payment();
```
User wil be routed to PayPal to authorize the payment. After that the user will be redirected to the 'RETURN' URL supplied.

## Authorize Payment Example
```
require_once __DIR__.'/src/PayPalLight/HttpRequest.php';
require_once __DIR__.'/src/PayPalLight/PayPalLight.php';
require_once __DIR__.'/src/PayPalLight/PayPalPayment.php';
require_once __DIR__.'/src/PayPalLight/CreditCardPayment.php';
require_once __DIR__.'/src/PayPalLight/PayPalTransaction.php';

use CodingCompany\PayPal\PayPalPayment as PayPalPayment;
use CodingCompany\PayPal\PayPalTransaction as PayPalTransaction;

$p = new PayPalPayment(array(
    'client_id'         => 'AddMFxCjj3QgJZT4kYgrgegbfdbgthre9Qj24o_P8Ldag7yeu2A',
    'client_secret'     => 'EFNXQgBjL9PQO0ZeuC5_4567547y6htet5ert34435_tct4nFU7g'
));

$p->set_endpoint("https://api.paypal.com");

$response = $p->execute_payment(array(
    "paymentId" => "PAY-554",
    "token" => "EC-45645",
    "PayerID" => "455454"
));
```

$response looks like:

Array
(
    [id] => PAY-554
    [intent] => sale
    [state] => approved
    [cart] => 10E457GK130324L
    [payer] => Array
        (
            [payment_method] => paypal
            etc
        etc
    etc
    )
)