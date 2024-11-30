<?php
namespace App\Repositories;

use App\Models\Approver;

class ApproverRepository
{
    public function create(array $data)
    {
        // Buat approver baru
        return Approver::create($data);
    }

}
