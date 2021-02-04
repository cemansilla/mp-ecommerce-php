<?php
$config = require(__DIR__ . '/server/config.php');

switch($_GET['collection_status']){
  case "approved":
    $respuesta = array(
      'Payment' => $_GET['payment_id'],
      'PaymentId' => $_GET['payment_method_id'],      
      'ExternalReference' => $_GET['external_reference'],
      'Status' => $_GET['status'],
      'MerchantOrder' => $_GET['merchant_order_id']        
    );
    echo json_encode($respuesta);
  break;
  
  case "pending":
    echo "Pago pendiente por medio de pago offline";
  break;

  case "failure":
  default:
    echo "Pago rechazado o no finalizado";
  break;            
}

?>
<br><a href='<?php echo $config['base_url']; ?>'>Volver a la tienda</a>