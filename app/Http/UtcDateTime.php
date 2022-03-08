<?php

namespace App\Http;


use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UtcDateTime implements CastsAttributes
{


    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     *
     * @return Carbon|mixed
     */
    public function get($model, string $key, $value, array $attributes  )
    {
       // return 77;
        $c = Category::where('id', $attributes['category_id'])->first();
////        $obj = var_dump(json_decode($c));
//       $obj =json_decode($c);
//       $type= $obj->type;
//        return json_decode($c)->type;
//        return $attributes['category_id'];

    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     *
     * @return array|Carbon|string
     */
    public function set($model, string $key, $value, array $attributes)
    {

    }
}
