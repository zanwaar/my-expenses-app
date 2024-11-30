<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;
    protected $fillable = [
        'expense_id',
        'approver_id',
        'status_id',
    ];

    public function expense()
{
    return $this->belongsTo(Expense::class);
}

public function approver()
{
    return $this->belongsTo(Approver::class);
}

public function status()
{
    return $this->belongsTo(Status::class);
}

}
