<?php

namespace App\Http\Livewire;

use App\Helpers\CoordinateCalculator;
use App\Helpers\Enums\StateEnum;
use App\Models\Commitment;
use App\Models\Property;
use App\Models\PropertyFeature;
use App\Models\PropertyInfo;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Livewire\Component;

class Search extends Component
{
    public $propertyId;
    public $search;
    public $start;
    public $end;
    public $terms = [];
    public $city;
    public $standard;
    public $period;
    public $people;
    public $daily;
    public $minValue;
    public $maxValue;
    private $client;

    protected $queryString = [
        'propertyId',
        'search',
        'start',
        'end',
        'terms' => ['as' => 't'],
        'city',
        'standard',
        'period',
        'people',
        'daily',
        'minValue',
        'maxValue'
    ];

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://maps.googleapis.com/maps/api/geocode/json',
            'timeout'  => 2.0,
        ]);
    }

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
            ->where('wp_posts.ID', 'like', "%$this->propertyId%")
            ->where('post_title', 'like', "%$this->search%")
            ->whereNotIn('wp_posts.ID', $propertiesWithCommitment)
            ->whereIn('wp_posts.ID', $filteredProperties)
            ->standard($this->standard)
            ->peopleOrPackage($this->minValue, $this->maxValue, $this->people, $this->daily, $this->period)
            ->get();

        if (
            !($this->propertyId || $this->search || $this->standard || $this->minValue ||
                $this->maxValue || $this->people || $this->daily || $this->period ||
                $this->start || $this->end || $this->terms || $this->city)
        ) {
            $properties = Property::where('ID', -999)->get();
        }

        foreach ($properties as $property) {
            $propertyInfo = PropertyInfo::where('property_id', $property->ID)->first();
            if (!$propertyInfo) {
                $propertyInfo = new PropertyInfo([
                    'property_id' => $property->ID
                ]);
                $propertyInfo->save();
            }

            if (!($propertyInfo->location_lat || $propertyInfo->location_lng)) {
                $abbreviation = isset(StateEnum::abbreviationList[$property->state]) ? StateEnum::abbreviationList[$property->state] : $property->state;
                $address = "{$property->city}/" . $abbreviation;

                $response = $this->client->request('GET', '', [
                    'query' => [
                        'address' => $address,
                        'key' => env('APP_KEY_GOOGLE_MAPS_API')
                    ]
                ]);

                $res = json_decode($response->getBody());
                
                if (isset($res->results[0]->geometry)) {
                    $location_lat = $res->results[0]->geometry->location->lat;
                    $location_lng = $res->results[0]->geometry->location->lng;
    
                    $propertyInfo->update([
                        'location_lat' => $location_lat,
                        'location_lng' => $location_lng
                    ]);
                }
            }

            $property->refresh();
            $property->distance = 0;
        }

        if ($this->city) {
            $response = $this->client->request('GET', '', [
                'query' => [
                    'address' => $this->city,
                    'key' => env('APP_KEY_GOOGLE_MAPS_API')
                ]
            ]);

            $res = json_decode($response->getBody());

            if (isset($res->results[0])) {
                $location_lat = $res->results[0]->geometry->location->lat;
                $location_lng = $res->results[0]->geometry->location->lng;

                foreach ($properties as $property) {
                    $distance = CoordinateCalculator::distanceBetween(
                        $location_lat,
                        $location_lng,
                        $property->propertyInfo->location_lat,
                        $property->propertyInfo->location_lng
                    );

                    $property->distance = floatval($distance);
                }
            }
        }

        $properties = $properties->sortBy('distance');

        return view('livewire.search', [
            'properties' => $properties,
            'filters' => $this->loadFilters()
        ]);
    }
}
