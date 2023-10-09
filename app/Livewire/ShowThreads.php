<?php

namespace App\Livewire;

use App\Models\Thread;
use Livewire\Component;
use App\Models\Category;

class ShowThreads extends Component
{
    public function render()
    {
        $categories = Category::get();
        $threads = Thread::latest()->get();

        return view('livewire.show-threads', compact('categories', 'threads'));
    }
}
