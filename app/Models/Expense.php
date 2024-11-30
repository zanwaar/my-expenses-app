<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'status_id'];

    public function approvers()
    {
        return $this->belongsToMany(Approver::class, 'expense_approver');
    }
}
