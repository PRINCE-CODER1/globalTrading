<?php

namespace App\Livewire\Import;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport as ProductImportHandler;
use Livewire\WithFileUploads;
use Livewire\Component;

class ProductImport extends Component
{
    public $file;
    use WithFileUploads;
    // Validate the file
    protected $rules = [
        'file' => 'required|mimes:xlsx,xls,csv'
    ];

    public function import()
    {
        $this->validate();

        // Handle the file import
        Excel::import(new ProductImportHandler, $this->file);

        toastr()->closeButton(true)->success('Products imported successfully!');
        $this->reset('file'); 
    }
    public function render()
    {
        return view('livewire.import.product-import');
    }
}
