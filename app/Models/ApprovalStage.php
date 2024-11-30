<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalStage extends Model
{
    use HasFactory;

    protected $fillable = ['approver_id'];

    public function approver()
    {
        return $this->belongsTo(Approver::class);
    }
}
