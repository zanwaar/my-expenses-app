<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalStageRequest;
use App\Repositories\ApprovalStageRepository;
use Illuminate\Http\JsonResponse;


class ApprovalStageController extends Controller
{
    protected $approvalStageRepository;

    /**
     * ApprovalStageController constructor.
     * @param ApprovalStageRepository $approvalStageRepository
     */
    public function __construct(ApprovalStageRepository $approvalStageRepository)
    {
        $this->approvalStageRepository = $approvalStageRepository;
    }


    /**
     * @OA\Post(
     *     path="/api/approval-stages",
     *     summary="Create a new approval stage",
     *     description="This endpoint creates a new approval stage in the approval workflow system.",
     *     tags={"Approval Stage"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"approver_id"},
     *             @OA\Property(property="approver_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Approval stage created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Approval stage created successfully"),
     *             @OA\Property(property="data", type="object", 
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="approver_id", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request - invalid input"
     *     )
     * )
     */
    public function store(ApprovalStageRequest $request): JsonResponse
    {
        $approvalStage = $this->approvalStageRepository->create($request->validated());

        return response()->json([
            'message' => 'Approval stage created successfully',
            'data' => $approvalStage,
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/approval-stages/{id}",
     *     summary="Update an existing approval stage",
     *     description="This endpoint updates an existing approval stage in the approval workflow system.",
     *     tags={"Approval Stage"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the approval stage to update",
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
     *         description="Approval stage updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Approval stage updated successfully"),
     *             @OA\Property(property="data", type="object", 
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="approver_id", type="integer", example=2)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request - invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found - the approval stage was not found"
     *     )
     * )
     */
    public function update(ApprovalStageRequest $request, $id): JsonResponse
    {
        $approvalStage = $this->approvalStageRepository->update($id, $request->validated());

        return response()->json([
            'message' => 'Approval stage updated successfully',
            'data' => $approvalStage,
        ], 200);
    }
}
