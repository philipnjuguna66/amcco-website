<?php

namespace App\Http\Controllers\API;

use App\Events\LeadCreatedEvent;
use App\Utils\SendSms;
use Appsorigin\Leads\Models\Lead;
use Carbon\Carbon;
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

            $clientMessage = "";

            foreach ($userColumns as $userColumn) {

                if ($userColumn['column_id'] === "PHONE_NUMBER")
                {
                    $clientTel = $userColumn['string_value'];
                }

                if ($userColumn['column_id'] == "FULL_NAME")
                {
                    $clientName = $userColumn['string_value'];
                }

                $message .= ' From ' . $clientName. ' Phone Number-: ' .  $clientTel;

                $clientMessage .=  "Dear: {$clientName}, We have received your book site visit request, One of RMs will contact soon. Thank You";

            }


            dispatch(fn() => (new SendSms())
                    ->send(
                        to: $clientTel,
                        text: $clientMessage
                    )
                )->afterResponse();


            $lead = Lead::create([
                'name' => $clientName,
                'phone_number' => $clientTel,
                'date' => new Carbon(),
                'page' => "GOOGLE_ADS_LEADS"
            ]);

            event(new LeadCreatedEvent(
                lead: $lead,
                branch: $lead->page,
                phone: $clientTel,
                name: $clientName,
                message: $clientMessage,
            ));

            dispatch(fn() =>  (new SendSms())
                ->send(
                    to: env('PHONE_NUMBER'),
                    text: $message
                ))
                ->afterResponse();


            return response()
                ->json(['status' => 'success'], 200);

        }


        return response()
            ->json(['status' => 'success'], 200);
    }

}
