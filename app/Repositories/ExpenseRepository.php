<?php

namespace App\Repositories;

use App\Models\Approval;
use App\Models\Expense;
use App\Models\Approver;

class ExpenseRepository
{
    /**
     * Menambah pengeluaran
     */
    public function create(array $data)
    {
        // Tambahkan status_id jika belum ada
        if (!isset($data['status_id'])) {
            $data['status_id'] = 1; // Default ke "Menunggu Persetujuan"
        }

        return Expense::create($data);
    }

    /**
     * Menyetujui pengeluaran
     */
    public function approve($expenseId, array $data)
    {
        // Ambil pengeluaran berdasarkan ID
        $expense = Expense::with(['approvals' => function ($query) {
            $query->orderBy('id', 'asc');
        }])->findOrFail($expenseId);

        // Validasi apakah approver sesuai dengan tahap approval saat ini
        $currentApproval = $expense->approvals()
            ->where('status_id', 1) // Status 'menunggu persetujuan'
            ->orderBy('id', 'asc')
            ->first();

        if (!$currentApproval) {
            throw new \Exception('Tidak ada approval yang membutuhkan persetujuan saat ini.');
        }

        if ($currentApproval->approver_id !== $data['approver_id']) {
            throw new \Exception('Approver tidak sesuai dengan tahap approval saat ini.');
        }

        // Update status approval ke 'disetujui'
        $currentApproval->update(['status_id' => 2]); // Status 'disetujui'

        // Periksa apakah semua tahap sudah disetujui
        $remainingApprovals = $expense->approvals()->where('status_id', 1)->count();
        if ($remainingApprovals === 0) {
            // Jika semua disetujui, ubah status pengeluaran menjadi 'disetujui'
            $expense->update(['status_id' => 2]); // Status 'disetujui'
        }

        return $currentApproval;
    }
    public function approveS($expenseId, array $data)
    {
        $expense = Expense::findOrFail($expenseId);

        // Approval Urutan approval bisa didasari oleh `approvals.id asc`, yang mengacu kepada `approval_stages.id asc`.



        $nextApproval = Approval::where('expense_id', $expenseId)
            ->where('status_id', 1) // Belum disetujui
            ->orderBy('id')
            ->first();

        if (!$nextApproval || $nextApproval->approver_id != $data['approver_id']) {
            throw new \Exception("Approver tidak sesuai tahap approval.");
        }

        $nextApproval->update(['status_id' => 2]);

        // Cek jika semua tahap disetujui
        if (Approval::where('expense_id', $expenseId)->where('status_id', 1)->doesntExist()) {
            $expense->update(['status_id' => 2]);
        }

        return $nextApproval;
    }

    public function find($id)
    {
        return Expense::with([
            'approvals.approver',
            'approvals.status',
            'status',
        ])->findOrFail($id);
    }
}
