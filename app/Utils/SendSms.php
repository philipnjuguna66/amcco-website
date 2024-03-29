<?php

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendSms implements ShouldQueue {

    use SerializesModels;

    use Queueable;


    public string $url = 'https://isms.celcomafrica.com/api/services';


    protected string  $partnerID;
    protected string $apikey;

    protected string $shortcode;

    public function __construct(public  ?Carbon $timeToSend = null)
    {

        $this->partnerID = (int) env('PARTNER_ID');
        $this->apikey =  env('API_KEY');
        $this->shortcode = env('SENDER_ID');


    }

    public function setTimeToSend(Carbon $timeToSend)
    {
        $this->timeToSend = $timeToSend;

        return $this;
    }

    public function send(string $to, string $text): \Illuminate\Http\Client\Response
    {

        return Http::baseUrl($this->url)
            ->get('/sendsms', [
                'partnerID' => $this->partnerID,
                'apikey' => $this->apikey,
                'message' =>  $text,
                'shortcode' => trim($this->shortcode),
                'mobile' => $to,
                'timeToSend' => is_null($this->timeToSend) ? now() : $this->timeToSend->toDateTimeLocalString()
            ]);


    }

    public function balance()
    {


        return Http::baseUrl($this->url)
            ->get('/getbalance', [
                'partnerID' => $this->partnerID,
                'apikey' => $this->apikey,
            ])->json('credit');
    }

    public function delivery(int $uniqueId) : \Illuminate\Http\Client\Response
    {
        return Http::baseUrl($this->url)

            ->get('/getdlr', [
                'partnerID' => $this->partnerID,
                'apikey' => $this->apikey,
                'messageID' => $uniqueId
            ]);

    }
}
