<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article;

class Articles extends Component
{
    use WithPagination;
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';
    public $perPage = 5;

    public function updatePerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
    }
    public function setSortBy($sortByField){
        if ($this->sortBy === $sortByField) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $sortByField;
            $this->sortDir = 'asc';
        }
    }
    public function render()
    {
        $articles = Article::orderBy($this->sortBy,$this->sortDir)->where('title', 'like', '%' . $this->search . '%')->paginate($this->perPage);
        return view('livewire.articles',compact('articles'));
    }
}
