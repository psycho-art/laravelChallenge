<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'token', 'expires_at', 'invited_by'];

    // Check if the invitation has expired
    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }

    // Relationship with the user model
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
