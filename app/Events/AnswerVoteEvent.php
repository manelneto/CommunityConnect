<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnswerVoteEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $id_question;
    public string $id_user;
    public string $vote;

    public function __construct(int $id_question, string $title, string $id_user, string $vote)
    {
        $this->message = 'Your answer to the question: ' . $title . ' was voted ' . $vote . '!';
        $this->id_question = $id_question;
        $this->id_user = $id_user;
        $this->vote = $vote;
    }

    public function broadcastOn()
    {
        return 'CommunityConnect';
    }

    public function broadcastAs(): string
    {
        return 'voteAnswer';
    }
}