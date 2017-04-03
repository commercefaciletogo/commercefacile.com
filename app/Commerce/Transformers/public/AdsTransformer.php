<?php
/**
 * Created by PhpStorm.
 * User: guru
 * Date: 4/3/17
 * Time: 7:58 AM
 */

namespace App\Commerce\Transformers;


use App\Ad;
use League\Fractal\TransformerAbstract;

class AdsTransformer extends TransformerAbstract
{

    public function transform(Ad $ad)
    {
        return [];
    }

}