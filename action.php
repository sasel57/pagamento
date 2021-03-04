<?php
  if(isset($_POST['stripe_payment_process'])){
    require_once 'vendor/autoload.php';
      $amount=$_POST[amount]*100;

      \Stripe\Stripe::setApiKey(Database::STRIPE_SECRET_KEY);
      header('Content-Type: application/json');
      $YOUR_DOMAIN = 'http://test.traders-mag.it/pagamento';
      $checkout_session= \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
          'price_data'=> [
            'currency'=>'eur',
            'unit_amount'=> $amount,
          ],
          'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN.'/notify.php',
        'cancel_url' => $YOUR_DOMAIN.'/cancel.php',
      ]);
      echo json_encode(['id'=>$checkout_session->id]);
  }



?>