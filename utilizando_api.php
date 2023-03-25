<?php

 require_once 'whatsapp.class.php';

 $whatsapp = new whatsapp('http://127.0.0.1:3000/');

 // criar dispositivo
 $created = $whatsapp->createInstance('TOKEN_DO_CLIENTE','Nome do cliente');
 print_r($created);
 sleep(2);

 // inicia o whatsapp para depois Conectar
 $started = $whatsapp->startWhatsapp('OPP3422');
 print_r($started);
 sleep(2);

 // inicia o whatsapp para depois Conectar
 $qrcode = $whatsapp->getqrcode('OPP3422');
 print_r($qrcode);
 sleep(2);
 die;
  // busca o status de conexao do dispositivo (true ou false a resposta)
  $status = $whatsapp->getStatus('TOKEN_DO_CLIENTE');
  print_r($status);
  die;

  // envia mensagem para whatsapp
  $message = $whatsapp->sendMessage('TOKEN_DO_CLIENTE','5511999999999','Fala rapeize!');
  print_r($message);
  die;

  // desconecta o whatsapp
  $logout = $whatsapp->logOut('TOKEN_DO_CLIENTE');
  print_r($logout);
  die;
