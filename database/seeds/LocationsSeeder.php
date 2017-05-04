<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->truncate();
        DB::table('locations')->insert($this->get_data());
    }

    private function get_data()
    {
        return collect($this->get_locations())->map(function($city){
            return [
                'uuid' => Uuid::uuid4(),
                'name' => title_case($city['name']),
                'slug' => str_slug($city['name']),
                'parent_id' => $city['parent_id']
            ];
        })->toArray();
    }

    private function get_locations()
    {
        return [

//      regions
            ['name' => 'Maritime', 'parent_id' => null],
            ['name' => 'Plateaux', 'parent_id' => null],
            ['name' => 'Centrale', 'parent_id' => null],
            ['name' => 'Kara', 'parent_id' => null],
            ['name' => 'Savanes', 'parent_id' => null],

//      cities
//          maritime
            ['name' => 'Ablogamé', 'parent_id' => 1],
            ['name' => 'Abobokomé', 'parent_id' => 1],
            ['name' => 'Abové', 'parent_id' => 1],
            ['name' => 'Adakpamé', 'parent_id' => 1],
            ['name' => 'Adawlato', 'parent_id' => 1],
            ['name' => 'Adidogomé', 'parent_id' => 1],
            ['name' => 'Adoboukomé', 'parent_id' => 1],
            ['name' => 'Aflao Gakli', 'parent_id' => 1],
            ['name' => 'Agbadahonou', 'parent_id' => 1],
            ['name' => 'Agbalépédogan', 'parent_id' => 1],
            ['name' => 'Agoè', 'parent_id' => 1],
            ['name' => 'Aguia Komé', 'parent_id' => 1],
            ['name' => 'Akodesséwa', 'parent_id' => 1],
            ['name' => 'Akodesséwa Kponou', 'parent_id' => 1],
            ['name' => 'Akodesséwa Kpota', 'parent_id' => 1],
            ['name' => 'Akossombo', 'parent_id' => 1],
            ['name' => 'Amoutivé', 'parent_id' => 1],
            ['name' => 'Anfamé', 'parent_id' => 1],
            ['name' => 'Anthonio Nétimé', 'parent_id' => 1],
            ['name' => 'Atiégou', 'parent_id' => 1],
            ['name' => 'Avénou (BATOME)', 'parent_id' => 1],
            ['name' => 'Bassadji', 'parent_id' => 1],
            ['name' => 'Bè', 'parent_id' => 1],
            ['name' => 'Bè-Ahligo', 'parent_id' => 1],
            ['name' => 'Bè-Apéhémé', 'parent_id' => 1],
            ['name' => 'Bè-Hédjé', 'parent_id' => 1],
            ['name' => 'Bè-Klikamé', 'parent_id' => 1],
            ['name' => 'Bè-Kpota', 'parent_id' => 1],
            ['name' => 'Béniglato', 'parent_id' => 1],
            ['name' => 'Cassablanca', 'parent_id' => 1],
            ['name' => 'Djidjolé', 'parent_id' => 1],
            ['name' => 'Dogbéavou', 'parent_id' => 1],
            ['name' => 'Doulassamé', 'parent_id' => 1],
            ['name' => 'Doumasséssé', 'parent_id' => 1],
            ['name' => 'Fréau Jardin', 'parent_id' => 1],
            ['name' => 'Gbényédi', 'parent_id' => 1],
            ['name' => 'Gbonvié', 'parent_id' => 1],
            ['name' => 'Hanoukopé', 'parent_id' => 1],
            ['name' => 'Hédzranawoé', 'parent_id' => 1],
            ['name' => 'Kagnikopé', 'parent_id' => 1],
            ['name' => 'Kélégougan', 'parent_id' => 1],
            ['name' => 'kodjoviakopé', 'parent_id' => 1],
            ['name' => 'Kokétimé', 'parent_id' => 1],
            ['name' => 'Kotokou Kondji', 'parent_id' => 1],
            ['name' => 'Kpéhénou', 'parent_id' => 1],
            ['name' => 'Lom Nava', 'parent_id' => 1],
            ['name' => 'Lomé 2', 'parent_id' => 1],
            ['name' => 'N’tifafakomé', 'parent_id' => 1],
            ['name' => 'Octaviano Nétimé', 'parent_id' => 1],
            ['name' => 'Quartier Administratif', 'parent_id' => 1],
            ['name' => 'Résidence du Bénin', 'parent_id' => 1],
            ['name' => 'Saint Joseph', 'parent_id' => 1],
            ['name' => 'Sanguéra', 'parent_id' => 1],
            ['name' => 'Souza Nétimé', 'parent_id' => 1],
            ['name' => 'Soviépé', 'parent_id' => 1],
            ['name' => 'Tokoin-N’kafu', 'parent_id' => 1],
            ['name' => 'Tokoin-Aéroport', 'parent_id' => 1],
            ['name' => 'Tokoin-Elavagnon', 'parent_id' => 1],
            ['name' => 'Tokoin-Forever', 'parent_id' => 1],
            ['name' => 'Tokoin-Gbadago', 'parent_id' => 1],
            ['name' => 'Tokoin-Hopital', 'parent_id' => 1],
            ['name' => 'Tokoin-Lycée', 'parent_id' => 1],
            ['name' => 'Tokoin-Ouest', 'parent_id' => 1],
            ['name' => 'Tokoin-Solidarité', 'parent_id' => 1],
            ['name' => 'Tokoin-Tamé', 'parent_id' => 1],
            ['name' => 'Tokoin-Wuiti', 'parent_id' => 1],
            ['name' => 'Totsi', 'parent_id' => 1],
            ['name' => 'Université du Bénin', 'parent_id' => 1],
            ['name' => 'Wété', 'parent_id' => 1],
            ['name' => 'Wétrivi Kondji', 'parent_id' => 1],
            ['name' => 'Zone Portuaire', 'parent_id' => 1],
            ['name' => 'xédranawoe', 'parent_id' => 1],
            ['name' => 'Amoutivé', 'parent_id' => 1],
            ['name' => 'Baguida', 'parent_id' => 1],
            ['name' => 'Agoè – Nyivé', 'parent_id' => 1],
            ['name' => 'Sanguéra', 'parent_id' => 1],
            ['name' => 'Fiata', 'parent_id' => 1],
            ['name' => 'Agouègan ', 'parent_id' => 1],
            ['name' => 'Togoville', 'parent_id' => 1],
            ['name' => 'Vogan', 'parent_id' => 1],
            ['name' => 'Avèpozo', 'parent_id' => 1]

//            kara
//            ['name' => 'ablogamé', 'parent_id' => 3],
        ];
    }
}
