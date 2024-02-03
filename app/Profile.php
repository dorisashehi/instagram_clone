<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $guarded=[];
    //

    public function profileImage()
    {
       $imagePath=($this->image) ? $this->image:'profile/B5JF3cE7HOjmT1Ggvu0JyRQLRbJBMFHx06vY2vNq.png';
       return '/storage/profile/'.$imagePath;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
