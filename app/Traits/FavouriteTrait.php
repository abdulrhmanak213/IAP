<?php

namespace App\Traits;

use App\Repositories\Contracts\IFavorite;
use App\Repositories\Eloquent\Criteria\Where;
use App\Repositories\Eloquent\FavoriteRepository;

trait FavouriteTrait { 
    // private $favRepo ;

    public function checkIsFav($user_id ,$service_provider_id ){
        if(!$user_id )
            return null ;

        $favRepo = new FavoriteRepository();
       return  $favRepo->withCriteria([
            new Where('user_id',$user_id),
            new Where('service_provider_id',$service_provider_id)
        ])->first();
    }

}