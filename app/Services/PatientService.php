<?php

namespace app\Services;

use App\Models\Patient;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class PatientService
{
    /**
     * @return array
     */
    public function getAllQueryFormattedResult(): array
    {
        $patients = Patient::all();
        $resultJson = [];

        foreach ($patients as $patient) {
            $resultJson[] = $this->formatAsArray($patient);
        }

        return $resultJson;
    }

    public function formatAsArray(Patient $patient): array
    {
        $result['name'] = $patient->first_name.' '.$patient->last_name;
        $result['birth_date'] = Carbon::parse($patient->birth_date)->format('d.m.Y');
        $age = $this->pluralizeAge($patient->birth_date);
        $result['age'] = $age['age']. ' '.$age['units'];

        return $result;
    }
    /**
     * @param Request $request
     * @return void
     * @throws \Throwable
     */
    public function saveFromRequest(Request $request): Patient
    {
        $patient = new Patient();
        $attributes = $request->all();
        $patient->fill($attributes);
        $patient->saveOrFail();

        return $patient;
    }

    public function pluralizeAge($birth_date)
    {
        $birth_date = Carbon::parse($birth_date);
        $now = new DateTime('now');
        $days = $birth_date->diffInUTCDays($now);
        $months = $birth_date->diffInUTCMonths($now);
        $years = $birth_date->diffInUTCYears($now);

        if ($years > 1){
            $age = ['age' => floor($years), 'units' => 'years'];
        } elseif ( $months > 1 ){
            $age = ['age' => floor($months), 'units' => 'months'];
        } else {
            $age = ['age' => floor($days), 'units' => 'days'];
        }

        return $age;
    }
}
