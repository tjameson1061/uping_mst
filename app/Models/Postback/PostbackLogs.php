<?php

namespace App\Models\Postback;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostbackLogs extends Model
{
    use HasFactory;

    protected $table = 'postback_logs';
}
