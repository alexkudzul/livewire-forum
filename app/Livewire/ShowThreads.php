<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class ShowThreads extends Component
{
    public function render()
    {
        $categories = Category::get();

        return view('livewire.show-threads', compact('categories'));
    }
}
