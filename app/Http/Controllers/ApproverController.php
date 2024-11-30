<?php
namespace App\Http\Controllers;

use App\Http\Requests\ApproverRequest;
use App\Repositories\ApproverRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Expense Approval API",
 *     version="1.0.0",
 *     description="API for handling expense approval system"
 * )
 */
class ApproverController extends Controller
{
    protected $approverRepository;

    /**
     * ApproverController constructor.
     * @param ApproverRepository $approverRepository
     */
    public function __construct(ApproverRepository $approverRepository)
    {
        $this->approverRepository = $approverRepository;
    }
   /**
     * @OA\Post(
     *     path="/api/approvers",
     *     summary="Create a new approver",
     *     description="This endpoint creates a new approver in the system.",
     *     tags={"Approver"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="John Doe")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Approver created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Approver created successfully"),
     *             @OA\Property(property="data", type="object", 
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request - invalid input"
     *     )
     * )
     */
    public function store(ApproverRequest $request): JsonResponse
    {
        // Validasi input sudah dilakukan oleh ApproverRequest
        $approver = $this->approverRepository->create($request->validated());

        return response()->json([
            'message' => 'Approver created successfully.',
            'data' => $approver
        ], 201);
    }
}
