<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ReturnChalaan;

class ReturnChalaanList extends Component
{ 
    use WithPagination;

    public function render()
    {
        $returnChalaans = ReturnChalaan::with(['externalChalaan', 'returnedBy'])->paginate(10);

        return view('livewire.crm.return-chalaan-list', compact('returnChalaans'));
    }
}
