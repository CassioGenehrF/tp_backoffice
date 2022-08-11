<?php

namespace App\Http\Livewire;

use App\Models\Commitment;
use App\Models\Property;
use App\Models\PropertyFeature;
use Carbon\Carbon;
use Livewire\Component;

class Search extends Component
{
    public $search;
    public $start;
    public $end;

    protected $queryString = [
        'search',
        'start',
        'end'
    ];

    public function render()
    {
        $fromDate = empty($this->start) ? Carbon::createFromTimeStamp(0)->toDateString() : $this->start;
        $toDate = empty($this->end) ? $fromDate : $this->end;
        $externalArea = PropertyFeature::externalAreaChildren();

        $propertiesWithCommitment = Commitment::propertiesWithCommitment($fromDate, $toDate);

        $properties = Property::published()
            ->where('post_title', 'like', "%$this->search%")
            ->whereNotIn('wp_posts.ID', $propertiesWithCommitment)
            ->get();

        return view('livewire.search', [
            'properties' => $properties
        ]);
    }
}
