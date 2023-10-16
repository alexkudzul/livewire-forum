<?php

namespace App\Livewire;

use App\Models\Thread;
use Livewire\Component;
use App\Models\Category;

class ShowThreads extends Component
{
    public $search;
    public $category;

    public function render()
    {
        $categories = Category::get();
        $threads = Thread::query();
        $threads->where('title', 'like', "%$this->search%");

        if ($this->category) {
            $threads->where('category_id', $this->category);
        }

        $threads->with('user', 'category');
        $threads->withCount('replies');
        $threads->latest();

        return view('livewire.show-threads', [
            'categories' => $categories,
            'threads' => $threads->get(),
        ]);
    }

    public function filterByCategory($category)
    {
        $this->category = $category;
    }
}
