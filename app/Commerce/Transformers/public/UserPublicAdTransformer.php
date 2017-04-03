<?php
/**
 * Created by PhpStorm.
 * User: guru
 * Date: 4/2/17
 * Time: 9:47 PM
 */

namespace App\Commerce\Transformers;


use App\Ad;
use League\Fractal\TransformerAbstract;

class UserPublicAdTransformer extends TransformerAbstract
{

    public function transform(Ad $ad)
    {
        return [

        ];
    }

}