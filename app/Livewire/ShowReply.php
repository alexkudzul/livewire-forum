<?php

namespace App\Livewire;

use App\Models\Reply;
use Livewire\Component;

class ShowReply extends Component
{
    public Reply $reply;
    public $body;
    public $is_creating = false;
    public $is_editing = false;

    // $toggle (Magic Actions) = Acceso directo para activar o desactivar propiedades booleanas
    // $refresh (Magic Actions) = Volverá a renderizar el componente sin realizar ninguna acción.
    protected $listeners = ['refresh' => '$refresh'];

    public function updatedIsCreating()
    {
        $this->reset('body', 'is_editing');
    }

    public function updatedIsEditing()
    {
        $this->reset('is_creating');

        $this->body = $this->reply->body;
    }

    public function updateReply()
    {
        // Validate
        $this->validate(['body' => 'required']);

        // Update
        $this->reply->update([
            'body' => $this->body
        ]);

        // Refresh
        $this->reset('is_editing');
    }

    public function postChild()
    {
        // Limita no tener multiples niveles de respuestas
        if (!is_null($this->reply->reply_id)) return;

        // Validate
        $this->validate(['body' => 'required']);

        // Create
        auth()->user()->replies()->create([
            'reply_id' => $this->reply->id,
            'thread_id' => $this->reply->thread->id,
            'body' => $this->body
        ]);

        // Refresh
        $this->reset('body', 'is_creating');
        $this->dispatch('refresh')->self();
    }

    public function render()
    {
        return view('livewire.show-reply');
    }
}
