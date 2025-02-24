<?php

namespace FriendsOfBotble\Sms\Actions;

use FriendsOfBotble\Sms\Facades\Otp;
use FriendsOfBotble\Sms\Facades\Sms;

class SendOtpAction
{
    public function __invoke(string $phone): void
    {
        $otp = Otp::generate($phone);

        $message = str_replace(
            '{code}',
            $otp->token,
            setting('fob_otp_message', 'Your OTP code is: {code}')
        );

        // Sms::send($phone, $message);
        // echo 123;die;
        $phone =str_replace('+91','',$phone);
        $response=   $this->fasSms($phone,$otp->token);

            //   print_r($response);die;
        
    }

    public function fasSms($phone,$otp){

        $fields = array(
            "sender_id" => "PHCPRL",
            "message" => "180473",
            "variables_values" => $otp."|",
            "route" => "dlt",
            "numbers" => $phone,
        );
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($fields),
          CURLOPT_HTTPHEADER => array(
            "authorization: 4JL39u7IEjUR6gaYiQKTosyfCVGvkM8cbHOp5SZtAnD2wBzeXqueM1w6rpzbk2s5dB4HQF3v7iJ0tUYo",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
        //   echo "cURL Error #:" . $err;
        } else {
        //   echo $response;
        }

        return true;
    }
}
