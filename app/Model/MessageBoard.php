<?php

namespace  App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\User;

class MessageBoard extends Model
{

    protected $fillable = ['message','total_receiver','numbers'];

        protected $casts = [
        'device' => 'array',
    ];

    
    protected $table = 'message_board';
    
    public function user(){
        
        return $this->belongsTo(User::class,'sent_by');
    }
    
}
