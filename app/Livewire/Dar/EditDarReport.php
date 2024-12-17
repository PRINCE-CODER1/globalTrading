<?php

namespace App\Livewire\Dar;

use Livewire\Component;
use App\Models\Dar;
use App\Models\CustomerSupplier;
use App\Models\CustomerSupplierUser;
use App\Models\VisitMaster;
use Illuminate\Support\Facades\Auth;

class EditDarReport extends Component
{
    public $darId;
    public $customer_id;
    public $pov_id;
    public $remarks;
    public $status;
    public $rating;
    public $date;
    public $user_id;

    public $customer_supplier_user_id = null;
    public $selectedCustomerUsers = [];

    public $customers = [];
    public $purposes = [];

    protected $rules = [
        'customer_id' => 'required|exists:customer_suppliers,id',
        'pov_id' => 'required|exists:visit_masters,id',
        'remarks' => 'nullable|string',
        'status' => 'required|in:0,1',
        'rating' => 'nullable|integer|between:1,5',
        'date' => 'required|date',
        'customer_supplier_user_id' => 'nullable|exists:customer_supplier_users,id',
    ];

    public function mount($darId)
    {
        $this->darId = $darId;

        $dar = Dar::findOrFail($this->darId);

        $this->customer_id = $dar->customer_id;
        $this->customer_supplier_user_id = $dar->customer_supplier_user_id;
        $this->pov_id = $dar->pov_id;
        $this->remarks = $dar->remarks;
        $this->status = $dar->status;
        $this->rating = $dar->rating;
        $this->date = $dar->date;
        $this->user_id = $dar->user_id;

        $this->customers = CustomerSupplier::all();
        $this->purposes = VisitMaster::all();

        $this->selectedCustomerUsers = CustomerSupplierUser::where('customer_supplier_id', $this->customer_id)->get();
    }

    public function update()
    {
        $this->validate();

        $dar = Dar::findOrFail($this->darId);

        $dar->update([
            'customer_id' => $this->customer_id,
            'customer_supplier_user_id' => $this->customer_supplier_user_id,
            'pov_id' => $this->pov_id,
            'remarks' => $this->remarks,
            'status' => $this->status,
            'rating' => $this->rating,
            'date' => $this->date,
            'user_id' => Auth::id(),
        ]);

        toastr()->closeButton(true)->success('DAR form updated successfully!');
        return redirect()->route('daily-report.index');
    }

    public function render()
    {
        return view('livewire.dar.edit-dar-report');
    }
}
