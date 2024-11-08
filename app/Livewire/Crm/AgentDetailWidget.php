<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\User;

class AgentDetailWidget extends Component
{
  public $userId = 0;
    public function render()
    {
        $agent = User::find($this->userId);
        return view('livewire.crm.agent-detail-widget',compact('agent'));
    }
}
