<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel; 
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentQuestionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $id_question;
    public string $id_user;

    public function __construct(int $id_question, string $title, string $id_user)
    {
        $this->message = 'You received a new comment to your question: ' . $title . '!';
        $this->id_question = $id_question;
        $this->id_user = $id_user;
    }

    public function broadcastOn()
    {
        return 'CommunityConnect';
    }

    public function broadcastAs(): string
    {
        return 'commentQuestion';
    }
}
