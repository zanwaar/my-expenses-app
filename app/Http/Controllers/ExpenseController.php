<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\ApproveExpenseRequest;
use App\Http\Requests\GetExpenseRequest;
use App\Repositories\ExpenseRepository;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{
    protected $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/expense",
     *     summary="Create a new expense",
     *     description="This endpoint creates a new expense record in the system.",
     *     tags={"Expense"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount"},
     *             @OA\Property(property="amount", type="integer", example=1000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Expense created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Expense created successfully"),
     *             @OA\Property(property="data", type="object", 
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="amount", type="integer", example=1000)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request - invalid input"
     *     )
     * )
     */
    public function store(ExpenseRequest $request): JsonResponse
    {
        $expense = $this->expenseRepository->create($request->validated());

        return response()->json([
            'message' => 'Expense created successfully.',
            'data' => $expense
        ], 201);
    }

    /**
     * @OA\Patch(
     *     path="/api/expense/{id}/approve",
     *     summary="Approve an expense",
     *     description="This endpoint approves an expense record in the system.",
     *     tags={"Expense"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the expense to approve",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"approver_id"},
     *             @OA\Property(property="approver_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense approved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Expense approved successfully"),
     *             @OA\Property(property="data", type="object", 
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="amount", type="integer", example=1000)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request - invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */
    // public function approve(ExpenseRequest $request, $id): JsonResponse
    // {
    //     $expense = $this->expenseRepository->approve($id, $request->approver_id);

    //     return response()->json([
    //         'message' => 'Expense approved successfully.',
    //         'data' => $expense
    //     ]);
    // }

    public function approve(ExpenseRequest $request, $id): JsonResponse
    {
        $approval = $this->expenseRepository->approve($id, $request->validated());
        return response()->json([
            'message' => 'Pengeluaran berhasil disetujui',
            'data' => $approval
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/expense/{id}",
     *     summary="Get a single expense record",
     *     description="This endpoint retrieves an expense record with its approval status.",
     *     tags={"Expense"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the expense to retrieve",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="amount", type="integer", example=1000),
     *             @OA\Property(property="status", type="string", example="approved"),
     *             @OA\Property(property="approvals", type="array", @OA\Items(
     *                 @OA\Property(property="approver", type="integer", example=2),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="status", type="string", example="approved")
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */
    public function show(GetExpenseRequest $request, $id): JsonResponse
    {
        $expense = $this->expenseRepository->find($id);

        return response()->json($expense);
    }
}
