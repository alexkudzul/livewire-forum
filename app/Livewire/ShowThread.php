<?php

namespace App\Livewire;

use App\Models\Thread;
use Livewire\Component;

class ShowThread extends Component
{
    public Thread $thread;
    public $body;

    public function postReply()
    {
        // Validate
        $this->validate(['body' => 'required']);

        // Create
        auth()->user()->replies()->create([
            'thread_id' => $this->thread->id,
            'body' => $this->body,
        ]);

        // Refresh
        $this->reset('body');
    }

    public function render()
    {
        $replies = $this->thread
            ->replies()
            ->whereNull('reply_id')
            // Carga la relacion user, repliesChilds trae sus propios users, repliesChilds trae sus propios repliesChilds
            ->with('user', 'repliesChilds.user', 'repliesChilds.repliesChilds')
            ->get();

        return view('livewire.show-thread', compact('replies'));
    }
}
