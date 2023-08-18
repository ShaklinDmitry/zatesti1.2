<?php

namespace App\classes\Text\Application;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MakeStatementsFromText
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $statements;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string ...$statements)
    {
        $this->$statements = $statements;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
