<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Manufacturer;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class Controller extends BaseController
{
    /**
     * @OA\Get(
     *      summary="Get Course Attendance records.",
     *      path="/1.0.0/academic/courses/attendances",
     *      operationId="1.0.0-academic-course-attendance-index",
     *      tags={"academic", "1.0.0", "course", "attendance"},
     *      description="Retrieves Course Attendance records.",
     *      parameters={
     *       {"name": "Authorization", "in": "header", "type": "string", "required": true, "description": "Bearer token"},
     *       {"name": "course_code", "in": "query", "type": "string", "required": true, "example": "CSS 101", "description": "Course Code"},
     *       {"name": "year", "in": "query", "type": "integer", "required": true, "example": "2022", "description": "Year"},
     *       {"name": "term", "in": "query", "type": "integer", "required": true, "example": "2", "description": "Term"},
     *       {"name": "section", "in": "query", "type": "string", "required": true, "example": "01", "description": "Section"}
     *      },
     *      security={{"passport": {}, "permissions": {"53", "132"}}},
     *
     *      @OA\Response(
     *           response=200,
     *           description="Attendance records are successfully returned.",
     *
     *      )
     *  )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Categories are successfully retrieved.',
            'data' => Manufacturer::all(),
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can add a new manufacturer.',
            ]);
        }

        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $newManufacturer = Manufacturer::query()->create([
            'name' => $data['name'],
        ]);

        return response()->json([
            'message' => 'Manufacturer is successfully created.',
            'data' => $newManufacturer,
        ]);
    }

    public function update(Manufacturer $manufacturer, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can change the manufacturer.',
            ]);
        }
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $manufacturer->update([
            'name' => $data['name'],
        ]);

        return response()->json([
            'message' => 'Manufacturer is successfully updated.',
            'data' => $manufacturer,
        ]);
    }

    public function delete(Manufacturer $manufacturer): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can delete the manufacturer.',
            ]);
        }

        $manufacturer->delete();

        return response()->json([
            'message' => 'Manufacturer is successfully deleted.',
        ]);
    }
}
