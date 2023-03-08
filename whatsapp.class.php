<?php
/**
 *
 */
class Whatsapp {

    function __construct($endpoint = ""){
       $this->endpoint = $endpoint;
     }

  public function createInstance($token,$name){

     $curl = curl_init();

     curl_setopt_array($curl, array(
       CURLOPT_URL => $this->endpoint.'/devices/create?name='.$name.'&token='.trim($token),
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => '',
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 0,
       CURLOPT_FOLLOWLOCATION => true,
       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       CURLOPT_CUSTOMREQUEST => 'POST',
       CURLOPT_HTTPHEADER => array(
         'Token: 1234ABCD',
         'Content-Type: application/json'
       ),
     ));

     $response = curl_exec($curl);
     curl_close($curl);


     try{

         $json = json_decode($response);

         if(isset($json->success)){
             if($json->success == true){

                 if(isset($json->data->name)){
                     if($json->data->name != ""){
                         return true;
                     }else{
                         return false;
                     }
                 }else{
                     return false;
                 }

             }else{
                 return false;
             }
         }else{
             return false;
         }


     }catch(\Exception  $e){
         return false;
     }


  }

  public function sendMessage($instance,$phone,$message){

					$data = array(
								"Id"     => uniqid().date('His'),
								"Phone"  => $phone,
								"Body"   => $message
						);

						$postdata = json_encode($data);

						$curl = curl_init();

						curl_setopt_array($curl, array(
						CURLOPT_URL => $this->endpoint.'/chat/send/text',
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 1,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => $postdata,
						CURLOPT_HTTPHEADER => array(
  						'Token: '.trim($instance),
  						'Content-Type: application/json'
  						),
						));

						$response = curl_exec($curl);
						curl_close($curl);

            return $response ;

  }

  public function getStatus($instance){

     $curl = curl_init();

     curl_setopt_array($curl, array(
       CURLOPT_URL => $this->endpoint.'/session/status',
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => '',
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 0,
       CURLOPT_FOLLOWLOCATION => true,
       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       CURLOPT_CUSTOMREQUEST => 'GET',
       CURLOPT_HTTPHEADER => array(
         'Token: '.trim($instance)
       ),
     ));

     $response = curl_exec($curl);

     curl_close($curl);


     try{

         $json = json_decode($response);

         if(isset($json->success)){
             if($json->success == true){

                  if($json->data->Connected == false && $json->data->LoggedIn == false){
                      return false;
                  }else if($json->data->Connected == true && $json->data->LoggedIn == false){
                      return false;
                  }else if($json->data->Connected == false && $json->data->LoggedIn == true){
                      return false;
                  }else if($json->data->Connected == true && $json->data->LoggedIn == true){
                      return true;
                  }else{
                      return false;
                  }

             }else{
                 return false;
             }
         }else{
             return false;
         }


     }catch(\Exception  $e){
         return false;
     }


  }

    public function verifyWhatsapp($instance,$phone){

       $curl = curl_init();

       curl_setopt_array($curl, array(
         CURLOPT_URL => $this->endpoint.'/user/check',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_POSTFIELDS =>'{"Phone":["'.$phone.'"]}',
         CURLOPT_HTTPHEADER => array(
           'token: '.trim($instance),
           'Content-Type: application/json'
         ),
       ));

       $response = curl_exec($curl);
       curl_close($curl);

       try{

           $json = json_decode($response);

           if(isset($json->code)){
               if($json->code == 200){
                   return $response;
               }else{
                   return false;
               }
           }else{
               return false;
           }


       }catch(\Exception  $e){
           return false;
       }

    }


    public function logOut($instance){

       $curl = curl_init();

       curl_setopt_array($curl, array(
         CURLOPT_URL => $this->endpoint.'/session/logout',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_HTTPHEADER => array(
           'Token: '.trim($instance)
         ),
       ));

       $response = curl_exec($curl);
       curl_close($curl);

       try{

           $json = json_decode($response);

           if(isset($json->success)){
               if($json->success == true){
                   return true;
               }else{
                   return false;
               }
           }else{
               return false;
           }


       }catch(\Exception  $e){
           return false;
       }

    }

    public function getqrcode($instance){

           $curl = curl_init();

           curl_setopt_array($curl, array(
             CURLOPT_URL => $this->endpoint.'/session/qr',
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => '',
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 0,
             CURLOPT_FOLLOWLOCATION => true,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => 'GET',
             CURLOPT_HTTPHEADER => array(
               'Token: '.trim($instance)
             ),
           ));

           $response = curl_exec($curl);

           curl_close($curl);

       try{

           $json = json_decode($response);

           if(isset($json->success)){


               if($json->success == false){

                   if(isset($json->error)){
                       if($json->error == "Already Loggedin"){
                           echo json_encode(['erro' => false, 'connected' => true]);
                           exit;
                       }else{
                           return false;
                       }
                   }else{
                       return false;
                   }

               }else if($json->success == true){

                   if(isset($json->data->QRCode)){
                       return $json->data->QRCode;
                   }else{
                       return false;
                   }

             }else{
                   return false;
              }
           }else{
               return false;
           }


       }catch(\Exception  $e){
           return false;
       }


    }

    public function startWhatsapp($instance){

          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => $this->endpoint.'/session/connect',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"Subscribe":["Message"],"Immediate":false}',
            CURLOPT_HTTPHEADER => array(
              'Token: '.trim($instance),
              'Content-Type: application/json'
            ),
          ));

          $response = curl_exec($curl);
          curl_close($curl);

          try{

              $json = json_decode($response);

              if(isset($json->success)){

                  return true;

              }else{
                  return false;
              }


          }catch(\Exception  $e){
              return false;
          }



    }

}
 ?>
