<?php  
require_once 'DBController.php';
if(isset($_GET['totale']) && $_GET['totale'] != NULL && is_numeric($_GET['totale']) ){
    //$totale = $_GET['totale'];
    $totale = htmlspecialchars($_GET['totale']);
    $totale = stripslashes($totale);
    $totale = trim($totale);

}

else {
    echo '<script>alert("Non e stato inserito un prezzo valido")
    window.stop()
    </script>';
}
?>
<html>
<title>Pagina di pagamento</title>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">

</head>
<body id="page-top">
<header class="d-flex masthead" style="background-image:url('assets/img/bg-masthead.jpg');">
<div class="container fill text-center my-auto">
        <h1 class="mb-1">Traders' Magazine Italia</h1>
        <h3 class="mb-5"><em> La nostra migliore offerta</em></h3>

        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr"
            method="post" target="_top">
            <input type='hidden' name='business' value='traders@test.com'> 
                <input type='hidden' name='amount' value=<?= $totale ?>>
                <input type='hidden' name='no_shipping' value='1'> 
                <input type='hidden' name='currency_code' value='EUR'>
                <input type='hidden' name='notify_url' value='http://test.traders-mag.it/pagamento/notify.php'>
                <input type='hidden' name='cancel_return' value='http://test.traders-mag.it/pagamento/cancel.php'>
                <input type='hidden' name='return' value='http://test.traders-mag.it/pagamento/return.php'>
                <input type="hidden" name="cmd" value="_xclick"> 
                <input class="btn btn-primary btn-xl" type="submit" name="pay_now" id="pay_now" value="Paga ora <?=  htmlentities($totale) ?> EURO">
        </form>
        <button class="btn btn-primary btn-xl buy_now_btn" id='<?=  htmlentities($totale) ?>'>Paga ora con Stripe</button>
        <div class="overlay"></div>
    </div>
</header>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

  <script src="https://js.stripe.com/v3/"></script>
  <script>
      $(function(){
          let stripe= Stripe('<?= DBController:: STRIPE_PUB_KEY ?>');
		  
          $(document).on('click','.buy_now_btn',function(e){
              let amount= $(this).attr('id');
              $.ajax({
                url:'action.php',
                method: 'post',
			  data: {amount: amount,stripe_payment_process:1},
              datatype:'json',
                success: function(response){
                    console.log(response);
                    return stripe.redirectToCheckout({
                        sessionId: response.id
                    });
                }
              });
          });
      });
  </script>
</body>
</html>