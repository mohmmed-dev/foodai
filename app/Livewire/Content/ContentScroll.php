<?php

namespace App\Livewire\Content;

use App\Models\Content;
use Livewire\Component;
use Livewire\WithPagination;
use PHPUnit\Framework\Constraint\Count;

class ContentScroll extends Component
{
    use WithPagination;
    public $perPage = 10;
     public function loadMore()
    {
        $this->perPage += 10;
    }

    public function render()
    {
        $contents = Content::paginate($this->perPage);
        return view('livewire.content.content-scroll',compact('contents'));
    }
}
