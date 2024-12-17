<?php

namespace App\Livewire\Dar;

use App\Models\Dar;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Component;

class UserDarReport extends Component
{
    use WithPagination;

    public $userId;
    public $user;
    public $search = '';


    public function mount($userId)
    {
        $this->userId = $userId;

        $this->user = User::findOrFail($this->userId);
    }
    public function updatingSearch()
    {
        $this->resetPage(); 
    }
    public function render()
    {
        $darReports = Dar::with(['customer', 'purposeOfVisit'])
            ->where('user_id', $this->userId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('remarks', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('purposeOfVisit', function ($query) {
                            $query->where('visitor_name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy('date', 'desc')
            ->paginate(3);

        return view('livewire.dar.user-dar-report', [
            'darReports' => $darReports,
        ]);
    }
}
