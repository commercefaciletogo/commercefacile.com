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
        $locale = "en";

        if($this->frs()->contains($this->country)){
            $locale = "fr";
        }
        return $locale;
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