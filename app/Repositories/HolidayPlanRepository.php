<?php


namespace App\Repositories;

use App\Models\HolidayPlan;
use Illuminate\Database\Eloquent\Collection;

class HolidayPlanRepository
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return HolidayPlan::create($data);
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        return HolidayPlan::all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return HolidayPlan::findOrFail($id);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        $plan = HolidayPlan::findOrFail($id);
        $plan->update($data);
        return $plan;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $plan = HolidayPlan::findOrFail($id);
        $plan->delete();
        return $plan;
    }
}

