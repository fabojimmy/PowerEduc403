<?php

   class Orange{
         
      


        function iniatiVen($url,$login,$password,$data){

            $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "Authorization: Basic " . base64_encode("$login:$password")
                ));

                $response = curl_exec($ch);


                if ($response === FALSE) {
                     
                    return "Erreur lors de la requête cURL : " . curl_error($ch);
                } else {
                    // echo $response."<br>";
                    // var_dump(json_decode($response));
                    $response = json_decode($response);
                    // var_dump($response);
                    return $response->access_token;
                }

                curl_close($ch);


        }


        function payementInit($url,$accessToken,$authToken)
        
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            /*curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));*/
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/x-www-form-urlencoded",
                "X-AUTH-TOKEN: ".$authToken,
                "Authorization: Bearer " .$accessToken
            ));
            
            $response = curl_exec($ch);
            $response= json_decode($response);
            
            if ($response === FALSE) {
                return "Erreur lors de la requête cURL : " . curl_error($ch);
            } else {
                // $response=json_encode($response);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    echo 'Erreur lors du décodage de la chaîne JSON : ' . json_last_error_msg();
                } else {
                    // echo $response['data']['payToken'];
                    var_dump($response,$response->data->payToken);
                }
                return $response->data->payToken;
            }
            
            curl_close($ch);

        }


        function paymentRequest($url,$accessToken,$authToken,$pin,$orderId,$description=null,
                                $channelUserMsisdn,$amount,$subscriberMsisdn,$payToken)
        {


            $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json ",
                    "X-AUTH-TOKEN: ".$authToken,
                    "Authorization: Bearer " .$accessToken
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $data = <<<DATA
                {
                    "notifUrl": "https://www.y-note.cm/notification",
                        "channelUserMsisdn": "{$channelUserMsisdn}",
                        "amount": "{$amount}",
                        "subscriberMsisdn": "{$subscriberMsisdn}",
                        "pin": "{$pin}",
                        "orderId": "{$orderId}",
                        "description": "{$description}",
                        "payToken": "{$payToken}"
                        
                }
                DATA;
                curl_setopt($ch, CURLOPT_POSTFIELDS,  $data);

                $response = curl_exec($ch);
                
                if ($response === FALSE) {
                    return "Erreur lors de la requête cURL : " . curl_error($ch);
                } else {
                    return $response;
                }

                curl_close($ch);

        }


        function getStauts($url,$accessToken,$authToken)
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "X-AUTH-TOKEN: ".$authToken,
                "Authorization: Bearer " .$accessToken
            ));
        
            $response = curl_exec($ch);
            // $response= json_decode($response);
            if ($response === FALSE) {
                return "Erreur lors de la requête cURL : " . curl_error($ch);
            } else {
                return $response;
            }
        
            curl_close($ch);



        }
     
   }