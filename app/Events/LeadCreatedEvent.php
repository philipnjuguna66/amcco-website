<?php

namespace App\Events;

use Appsorigin\Leads\Models\Lead;
use Illuminate\Queue\SerializesModels;

class LeadCreatedEvent
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public Lead $lead , public string $branch , public string $phone, public string $name, public ?string $message = null, )
    {


    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
