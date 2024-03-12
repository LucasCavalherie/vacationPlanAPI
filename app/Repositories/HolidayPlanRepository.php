<?php


namespace App\Repositories;

use App\Models\HolidayPlan;

class HolidayPlanRepository
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return HolidayPlan::create($data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
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
     * @return void
     */
    public function delete($id)
    {
        $plan = HolidayPlan::findOrFail($id);
        $plan->delete();
    }
}

