<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPatient;
use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PatientService $patientService): JsonResponse
    {
        $result = $patientService->getAllQueryFormattedResult();
        return new JsonResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PatientService $patientService): JsonResponse
    {
        try{
            $patient = $patientService->saveFromRequest($request);

            Cache::put('patient_'.$patient->id, $patient, 300);
            ProcessPatient::dispatch($patient);

           return new JsonResponse('success', 200, [], true);
        } catch (\Throwable $e) {
            return new JsonResponse('fail', 200, [], true);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient, PatientService $patientService): JsonResponse
    {
        return new JsonResponse($patientService->formatAsArray($patient), 200, [], true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient): JsonResponse
    {
        //
    }
}
