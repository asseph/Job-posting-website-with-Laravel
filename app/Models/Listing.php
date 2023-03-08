<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title','logo', 'company','website', 'tags', 'email', 'description', 'location', 'user_id'];
    public function scopeFilter($query, array$filters){
       // dd($filters['tag']);
         if($filters['tag'] ?? false){
          $query->where('tags', 'like', '%' .  request('tag'). '%');
         }

        if($filters['search'] ?? false){
            $query->where('title', 'like', '%' .  request('search'). '%')
                  ->orWhere('description', 'like', '%' .  request('search'). '%')
                  ->orWhere('tags', 'like', '%' .  request('search'). '%');

           }
    }


    //relationshio to user

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
