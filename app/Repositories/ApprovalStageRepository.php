<?php
namespace App\Repositories;

use App\Models\ApprovalStage;
use App\Models\Approver;

class ApprovalStageRepository
{
    /**
     * Menambahkan tahap approval baru.
     *
     * @param array $data
     * @return ApprovalStage
     */
    public function create(array $data): ApprovalStage
    {
        return ApprovalStage::create($data);
    }

    /**
     * Mengupdate tahap approval.
     *
     * @param int $id
     * @param array $data
     * @return ApprovalStage
     */
    public function update(int $id, array $data): ApprovalStage
    {
        $approvalStage = ApprovalStage::findOrFail($id);
        $approvalStage->update($data);

        return $approvalStage;
    }
}
