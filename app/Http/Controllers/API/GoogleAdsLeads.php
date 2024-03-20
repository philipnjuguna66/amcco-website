<?php

namespace App\Http\Controllers\API;

use App\Utils\SendSms;
use Illuminate\Http\Request;

class GoogleAdsLeads
{
    public function __invoke(Request $request)
    {


        if ($request->google_key == env('GOOGLE_ADS_KEY'))
        {
            $userColumns = $request['user_column_data'];

            $message = "A New lead from Google Ads ";

            $clientTel = "";

            $clientName = "";

            foreach ($userColumns as $userColumn) {



                if ($userColumn['column_id'] == "PHONE_NUMBER")
                {
                    $clientTel = $userColumn['string_value'];
                }

                if ($userColumn['column_id'] == "FULL_NAME")
                {
                    $clientName = $userColumn['string_value'];
                }


                $message .= ' From ' . $clientName. ' Phone Number-: ' .  $clientTel;


                dispatch(fn() =>  (new SendSms())
                    ->send(
                        to: env('PHONE_NUMBER'),
                        text: $message
                    ))
                    ->afterResponse();

                $clientMessage =  "Dear: {$clientName}, We have received your book site visit request, One of RMs will contact soon. Thank You";

                dispatch(fn() => (new SendSms())
                    ->send(
                        to: $clientTel,
                        text: $clientMessage
                    )
                )->afterResponse();


                return response()
                    ->json(['status' => 'success'], 200);

            }



        }


        return response()
            ->json(['status' => 'success'], 200);
    }

}
