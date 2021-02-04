<?php
$config = require(__DIR__ . '/server/config.php');

if(!isset($_POST['token'])){
  header('Location: ' . $config['base_url']);
}

require __DIR__ .  '/vendor/autoload.php';

// Agrega credenciales
MercadoPago\SDK::setAccessToken($config['mercadopago']['seller']['access_token']);
MercadoPago\SDK::setIntegratorId($config['mercadopago']['integrator-id']);

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

// Máximo 6 cuotas
// No permitir AMEX ni ATM
$preference->payment_methods = array(
  "excluded_payment_methods" => array(
    array("id" => "amex")
  ),
  "excluded_payment_types" => array(
    array("id" => "atm")
  ),
  "installments" => 6 // Cuotas
);

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->id = "1234";
$item->title = $_POST['title'];
$item->description = "Dispositivo móvil de Tienda e-commerce";
$item->picture_url = $_POST['img'];
$item->quantity = 1;
$item->unit_price = $_POST['price'];
$preference->items = array($item);

// Comprador
$payer = new MercadoPago\Payer();
$payer->name = $config['mercadopago']['customer']['name'];
$payer->surname = $config['mercadopago']['customer']['last_name'];
$payer->email = $config['mercadopago']['customer']['email'];
$payer->date_created = date("c");
$payer->phone = array(
  "area_code" => $config['mercadopago']['customer']['tel_code'],
  "number" => $config['mercadopago']['customer']['tel']
);

$payer->identification = array(
  "type" => "DNI",
  "number" => $config['mercadopago']['customer']['id']
);

$payer->address = array(
  "street_name" => $config['mercadopago']['customer']['address']['street'],
  "street_number" => $config['mercadopago']['customer']['address']['number'],
  "zip_code" => $config['mercadopago']['customer']['address']['zip_code']
);
$preference->payer = $payer;

// Back URLs
$preference->back_urls = array(
  "success" => $config['base_url'] . "finish.php",
  "failure" => $config['base_url'] . "finish.php", 
  "pending" => $config['base_url'] . "finish.php"
);

// Número de orden del pedido (external_reference)
$preference->external_reference = "mail.mansilla@gmail.com";

$preference->auto_return = "approved";
$preference->notification_url = $config['base_url'] . "webhook.php";

$preference->save();
?>
<!DOCTYPE html>
<html class="supports-animation supports-columns svg no-touch no-ie no-oldie no-ios supports-backdrop-filter as-mouseuser" lang="en-US">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta name="viewport" content="width=1024">
  <title>Tienda e-commerce</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="format-detection" content="telephone=no">

  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="./assets/category-landing.css" media="screen, print">

  <link rel="stylesheet" href="./assets/category.css" media="screen, print">

  <link rel="stylesheet" href="./assets/merch-tools.css" media="screen, print">

  <link rel="stylesheet" href="./assets/fonts" media="">
  <style>
    .title_link, .title_link:hover, .title_link:visited{
      text-decoration: none;
      color: #000;
    }
    .as-filter-button-text {
      font-size: 26px;
      font-weight: 700;
      color: #333;
    }

    .row.as-fixed-nav {
      border-bottom: 1px solid #ddd;
    }

    .as-producttile-tilehero.with-paddlenav.with-paddlenav-onhover {
      height: 330px;
    }

    .as-footnotes {
      background: #333;
      color: #fff;
      padding: 16px 40px;
    }
  </style>
  <style type="text/css">
    @keyframes loading-rotate {
      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes loading-dash {
      0% {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
      }

      50% {
        stroke-dasharray: 100, 200;
        stroke-dashoffset: -20px;
      }

      100% {
        stroke-dasharray: 89, 200;
        stroke-dashoffset: -124px;
      }
    }

    @keyframes loading-fade-in {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .mp-spinner {
      position: absolute;
      top: 100px;
      left: 50%;
      font-size: 70px;
      margin-left: -35px;
      animation: loading-rotate 2.5s linear infinite;
      transform-origin: center center;
      width: 1em;
      height: 1em;
    }

    .mp-spinner-path {
      stroke-dasharray: 1, 200;
      stroke-dashoffset: 0;
      animation: loading-dash 1.5s ease-in-out infinite;
      stroke-linecap: round;
      stroke-width: 2px;
      stroke: #009ee3;
    }
  </style>
  <style type="text/css">
    .mercadopago-button-payment {
      padding: 0.9em 1.7142857142857142em;
      font-family: "Helvetica Neue", Arial, sans-serif;
      font-size: 0.875em;
      line-height: 2.7142857142857144;
      background: #009ee3;
      border-radius: 0.2857142857142857em;
      color: #fff;
      cursor: pointer;
      border: 0;
      text-decoration: none;
    }
    .mercadopago-button {
      padding: 0 1.7142857142857142em;
      font-family: "Helvetica Neue", Arial, sans-serif;
      font-size: 0.875em;
      line-height: 2.7142857142857144;
      background: #009ee3;
      border-radius: 0.2857142857142857em;
      color: #fff;
      cursor: pointer;
      border: 0;
    }
  </style>
  <style type="text/css">
    @keyframes loading-rotate {
      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes loading-dash {
      0% {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
      }

      50% {
        stroke-dasharray: 100, 200;
        stroke-dashoffset: -20px;
      }

      100% {
        stroke-dasharray: 89, 200;
        stroke-dashoffset: -124px;
      }
    }

    @keyframes loading-fade-in {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .mp-spinner {
      position: absolute;
      top: 100px;
      left: 50%;
      font-size: 70px;
      margin-left: -35px;
      animation: loading-rotate 2.5s linear infinite;
      transform-origin: center center;
      width: 1em;
      height: 1em;
    }

    .mp-spinner-path {
      stroke-dasharray: 1, 200;
      stroke-dashoffset: 0;
      animation: loading-dash 1.5s ease-in-out infinite;
      stroke-linecap: round;
      stroke-width: 2px;
      stroke: #009ee3;
    }
  </style>
  <style type="text/css">
    .mercadopago-button {
      padding: 0 1.7142857142857142em;
      font-family: "Helvetica Neue", Arial, sans-serif;
      font-size: 0.875em;
      line-height: 2.7142857142857144;
      background: #009ee3;
      border-radius: 0.2857142857142857em;
      color: #fff;
      cursor: pointer;
      border: 0;
    }
  </style>
  <style type="text/css">
    @keyframes loading-rotate {
      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes loading-dash {
      0% {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
      }

      50% {
        stroke-dasharray: 100, 200;
        stroke-dashoffset: -20px;
      }

      100% {
        stroke-dasharray: 89, 200;
        stroke-dashoffset: -124px;
      }
    }

    @keyframes loading-fade-in {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .mp-spinner {
      position: absolute;
      top: 100px;
      left: 50%;
      font-size: 70px;
      margin-left: -35px;
      animation: loading-rotate 2.5s linear infinite;
      transform-origin: center center;
      width: 1em;
      height: 1em;
    }

    .mp-spinner-path {
      stroke-dasharray: 1, 200;
      stroke-dashoffset: 0;
      animation: loading-dash 1.5s ease-in-out infinite;
      stroke-linecap: round;
      stroke-width: 2px;
      stroke: #009ee3;
    }
  </style>
  <style type="text/css">
    .mercadopago-button {
      padding: 0 1.7142857142857142em;
      font-family: "Helvetica Neue", Arial, sans-serif;
      font-size: 0.875em;
      line-height: 2.7142857142857144;
      background: #009ee3;
      border-radius: 0.2857142857142857em;
      color: #fff;
      cursor: pointer;
      border: 0;
    }
  </style>
  <style type="text/css">
    @keyframes loading-rotate {
      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes loading-dash {
      0% {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
      }

      50% {
        stroke-dasharray: 100, 200;
        stroke-dashoffset: -20px;
      }

      100% {
        stroke-dasharray: 89, 200;
        stroke-dashoffset: -124px;
      }
    }

    @keyframes loading-fade-in {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .mp-spinner {
      position: absolute;
      top: 100px;
      left: 50%;
      font-size: 70px;
      margin-left: -35px;
      animation: loading-rotate 2.5s linear infinite;
      transform-origin: center center;
      width: 1em;
      height: 1em;
    }

    .mp-spinner-path {
      stroke-dasharray: 1, 200;
      stroke-dashoffset: 0;
      animation: loading-dash 1.5s ease-in-out infinite;
      stroke-linecap: round;
      stroke-width: 2px;
      stroke: #009ee3;
    }
  </style>
  <style type="text/css">
    .mercadopago-button {
      padding: 0 1.7142857142857142em;
      font-family: "Helvetica Neue", Arial, sans-serif;
      font-size: 0.875em;
      line-height: 2.7142857142857144;
      background: #009ee3;
      border-radius: 0.2857142857142857em;
      color: #fff;
      cursor: pointer;
      border: 0;
    }
  </style>
  <style type="text/css">
    @keyframes loading-rotate {
      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes loading-dash {
      0% {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
      }

      50% {
        stroke-dasharray: 100, 200;
        stroke-dashoffset: -20px;
      }

      100% {
        stroke-dasharray: 89, 200;
        stroke-dashoffset: -124px;
      }
    }

    @keyframes loading-fade-in {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .mp-spinner {
      position: absolute;
      top: 100px;
      left: 50%;
      font-size: 70px;
      margin-left: -35px;
      animation: loading-rotate 2.5s linear infinite;
      transform-origin: center center;
      width: 1em;
      height: 1em;
    }

    .mp-spinner-path {
      stroke-dasharray: 1, 200;
      stroke-dashoffset: 0;
      animation: loading-dash 1.5s ease-in-out infinite;
      stroke-linecap: round;
      stroke-width: 2px;
      stroke: #009ee3;
    }
  </style>
  <style type="text/css">
    .mercadopago-button {
      padding: 0 1.7142857142857142em;
      font-family: "Helvetica Neue", Arial, sans-serif;
      font-size: 0.875em;
      line-height: 2.7142857142857144;
      background: #009ee3;
      border-radius: 0.2857142857142857em;
      color: #fff;
      cursor: pointer;
      border: 0;
    }
  </style>
  <style type="text/css">
    @keyframes loading-rotate {
      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes loading-dash {
      0% {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
      }

      50% {
        stroke-dasharray: 100, 200;
        stroke-dashoffset: -20px;
      }

      100% {
        stroke-dasharray: 89, 200;
        stroke-dashoffset: -124px;
      }
    }

    @keyframes loading-fade-in {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .mp-spinner {
      position: absolute;
      top: 100px;
      left: 50%;
      font-size: 70px;
      margin-left: -35px;
      animation: loading-rotate 2.5s linear infinite;
      transform-origin: center center;
      width: 1em;
      height: 1em;
    }

    .mp-spinner-path {
      stroke-dasharray: 1, 200;
      stroke-dashoffset: 0;
      animation: loading-dash 1.5s ease-in-out infinite;
      stroke-linecap: round;
      stroke-width: 2px;
      stroke: #009ee3;
    }
  </style>
  <style type="text/css">
    .mercadopago-button {
      padding: 0 1.7142857142857142em;
      font-family: "Helvetica Neue", Arial, sans-serif;
      font-size: 0.875em;
      line-height: 2.7142857142857144;
      background: #009ee3;
      border-radius: 0.2857142857142857em;
      color: #fff;
      cursor: pointer;
      border: 0;
    }
  </style>
</head>

<body class="as-theme-light-heroimage">

  <div class="stack">

    <div class="as-search-wrapper" role="main">
      <div class="as-navtuck-wrapper">
        <div class="as-l-fullwidth  as-navtuck" data-events="event52">
          <div>
            <div class="pd-billboard pd-category-header">
              <div class="pd-l-plate-scale">
                <div class="pd-billboard-background">
                  <img src="./assets/music-audio-alp-201709" alt="" width="1440" height="320" data-scale-params-2="wid=2880&amp;hei=640&amp;fmt=jpeg&amp;qlt=95&amp;op_usm=0.5,0.5&amp;.v=1503948581306" class="pd-billboard-hero ir">
                </div>
                <div class="pd-billboard-info">
                  <a class="title_link" href="<?php echo $config['base_url']; ?>"><h1 class="pd-billboard-header pd-util-compact-small-18">Tienda e-commerce</h1></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="as-search-results as-filter-open as-category-landing as-desktop" id="as-search-results">

        <div id="accessories-tab" class="as-accessories-details">
          <div class="as-accessories" id="as-accessories">
            <div class="as-accessories-header">
              <div class="as-search-results-count">
                <span class="as-search-results-value"></span>
              </div>
            </div>
            <div class="as-searchnav-placeholder" style="height: 77px;">
              <div class="row as-search-navbar" id="as-search-navbar" style="width: auto;">
                <div class="as-accessories-filter-tile column large-6 small-3">

                  <button class="as-filter-button" aria-expanded="true" aria-controls="as-search-filters" type="button">
                    <h2 class=" as-filter-button-text">
                      Smartphones
                    </h2>
                  </button>


                </div>

              </div>
            </div>
            <div class="as-accessories-results  as-search-desktop">
              <div class="width:60%">
                <div class="as-producttile-tilehero with-paddlenav " style="float:left;">
                  <div class="as-dummy-container as-dummy-img">

                    <img src="./assets/wireless-headphones" class="ir ir item-image as-producttile-image  " style="max-width: 70%;max-height: 70%;" alt="" width="445" height="445">
                  </div>
                  <div class="images mini-gallery gal5 ">


                    <div class="as-isdesktop with-paddlenav with-paddlenav-onhover">
                      <div class="clearfix image-list xs-no-js as-util-relatedlink relatedlink" data-relatedlink="6|Powerbeats3 Wireless Earphones - Neighborhood Collection - Brick Red|MPXP2">
                        <div class="as-tilegallery-element as-image-selected">
                          <div class=""></div>
                          <img src="./assets/003.jpg" class="ir ir item-image as-producttile-image" alt="" width="445" height="445" style="content:-webkit-image-set(url(<?php echo $_POST['img'] ?>) 2x);">
                        </div>

                      </div>


                    </div>



                  </div>

                </div>
                <div class="as-producttile-info" style="float:left;min-height: 168px;">
                  <div class="as-producttile-titlepricewraper" style="min-height: 128px;">
                    <div class="as-producttile-title">
                      <h3 class="as-producttile-name">
                        <p class="as-producttile-tilelink">
                          <span data-ase-truncate="2"><?php echo $_POST['title'] ?></span>
                        </p>

                      </h3>
                    </div>
                    <h3>
                      <?php echo $_POST['price'] ?>
                    </h3>
                    <h3>
                      <?php echo "$" . $_POST['unit'] ?>
                    </h3>
                  </div>

                  <a class="mercadopago-button-payment" href="<?php echo $preference->init_point; ?>">Pagar la compra</a>

                  <?php /*
                  <script
                    src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js"
                    data-preference-id="<?php echo $preference->id; ?>"
                    data-button-label="Pagar la compra (NO)">
                  </script>
                  */ ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div role="alert" class="as-loader-text ally" aria-live="assertive"></div>
    <div class="as-footnotes">
      <div class="as-footnotes-content">
        <div class="as-footnotes-sosumi">
          Todos los derechos reservados Tienda Tecno 2021
        </div>
      </div>
    </div>

  </div>
  <div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50">
      <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle>
    </svg> </div>
  <div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50">
      <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle>
    </svg> </div>
  <div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50">
      <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle>
    </svg> </div>
  <div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50">
      <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle>
    </svg> </div>
  <div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50">
      <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle>
    </svg> </div>
  <div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50">
      <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle>
    </svg> </div>
  <div id="ac-gn-viewport-emitter"> </div>


  <script src="https://www.mercadopago.com/v2/security.js" view="item"></script>
</body>

</html>