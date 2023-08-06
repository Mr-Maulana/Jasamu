<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Service;

class CreateService extends Component
{
    public $name;
    public $category;
    public $image;
    public $contact;
    public $description;

    public function render()
    {
        return view('livewire.create-service');
    }

    public function createService()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'category' => 'required',
            'image' => 'required',
            'contact' => 'required',
            'description' => 'required',
        ]);

        Service::create($validatedData);

        session()->flash('message', 'Service created successfully.');

        return redirect()->to('/services');
    }
}
