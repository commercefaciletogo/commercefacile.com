<?php

namespace Commerce\Helpers;


class Lang
{
    private $country;

    /**
     * Lang constructor.
     * @param $country
     */
    public function __construct($country)
    {
        $this->country = $country;
    }
    /**
     * @return string
     */
    public function get()
    {
        $local = "en";

        if($this->frs()->contains($this->country)){
            $local = "fr";
        }
        return $local;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function frs()
    {
        $fr = [
            'Belgium',
            'Cameroon',
            'France',
            'Haiti',
            'Morocco',
            'Switzerland',
            'France',
            'Algeria',
            'Benin',
            'Burkina Faso',
            'Burundi',
            'Central African Republic',
            'Chad',
            'Republic of Congo',
            'Democratic Republic of the Congo',
            'Côte d\'Ivoire',
            'Egypt',
            'Niger',
            'Rwanda',
            'Senegal',
            'Togo',
        ];

        return collect($fr);
    }
}