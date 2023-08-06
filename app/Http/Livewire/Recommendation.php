<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Recommendation extends Component
{
    public $inputJasa;
    public $recommendation = [];

    public function calculateRecommendation()
    {
        // Mengirimkan data nama jasa ke server Python
        $response = Http::post('http://localhost:5000/recommendation', [
            'input_jasa' => $this->inputJasa,
        ]);

        if ($response->successful()) {
            $this->recommendation = $response->json();
        }
    }

    public function render()
    {
        return view('livewire.recommendation');
    }
}
