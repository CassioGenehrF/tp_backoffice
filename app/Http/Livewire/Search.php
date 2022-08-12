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
    public $terms = [];

    protected $queryString = [
        'search',
        'start',
        'end',
        'terms' => ['as' => 't']
    ];

    private function loadFilters()
    {
        $filters = PropertyFeature::loadFilters();
        $hasFilter = false;

        foreach ($filters as $key => $parentValue) {
            foreach ($parentValue as $value) {
                foreach ($this->terms as $term) {
                    if ($term == $value['term_id']) {
                        $hasFilter = true;
                        break;
                    }
                }

                if ($hasFilter) {
                    break;
                }
            }

            $filters[$key]['status'] = $hasFilter;
            $hasFilter = false;
        }

        return $filters;
    }

    public function render()
    {
        $fromDate = empty($this->start) ? Carbon::createFromTimeStamp(0)->toDateString() : $this->start;
        $toDate = empty($this->end) ? $fromDate : $this->end;
        $propertiesWithCommitment = Commitment::propertiesWithCommitment($fromDate, $toDate);

        $filteredProperties = PropertyFeature::filteredProperties($this->terms);

        $properties = Property::published()
            ->where('post_title', 'like', "%$this->search%")
            ->whereNotIn('wp_posts.ID', $propertiesWithCommitment)
            ->whereIn('wp_posts.ID', $filteredProperties)
            ->get();

        return view('livewire.search', [
            'properties' => $properties,
            'filters' => $this->loadFilters()
        ]);
    }
}
