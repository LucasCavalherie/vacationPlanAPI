<?php


namespace App\Services;

use App\DTOs\HolidayPlanDTO;
use App\Models\HolidayPlan;
use App\Repositories\HolidayPlanRepository;
use Illuminate\Support\Facades\Validator;

class HolidayPlanService
{
    /**
     * @var HolidayPlanRepository
     */
    protected $repository;

    /**
     * @param HolidayPlanRepository $repository
     */
    public function __construct(HolidayPlanRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param HolidayPlanDTO $dto
     * @return mixed
     */
    public function create(HolidayPlanDTO $dto): mixed
    {
        $this->validate($dto);

        return $this->repository->create((array)$dto);
    }

    /**
     * @param $id
     * @param HolidayPlanDTO $dto
     * @return mixed
     */
    public function update($id, HolidayPlanDTO $dto): mixed
    {
        $this->validate($dto);

        return $this->repository->update($id, (array)$dto);
    }

    /**
     * @param HolidayPlanDTO $dto
     * @return void
     */
    protected function validate(HolidayPlanDTO $dto): void
    {
        $validator = Validator::make((array)$dto, HolidayPlan::$rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }
    }
}
