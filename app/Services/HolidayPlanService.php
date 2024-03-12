<?php


namespace App\Services;

use App\DTOs\HolidayPlanDTO;
use App\Models\HolidayPlan;
use App\Repositories\HolidayPlanRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use PDF;

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


    /*
     |--------------------------------------------------------------------------
     | Protected methods
     |--------------------------------------------------------------------------
     */

    /**
     * @param HolidayPlanDTO $dto
     * @return void
     */
    protected function validate(HolidayPlanDTO $dto): void
    {
        $validator = Validator::make((array)$dto, HolidayPlan::$rules);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
    }


    /*
     |--------------------------------------------------------------------------
     | Public methods
     |--------------------------------------------------------------------------
     */

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id): mixed
    {
        return $this->repository->getById($id);
    }

    /**
     * @return mixed
     */
    public function getAll(): mixed
    {
        return $this->repository->getAll();
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
     * @param $id
     * @return mixed
     */
    public function delete($id): mixed
    {
        return $this->repository->delete($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function generatePDF($id): mixed
    {
        $holidayPlan = $this->getById($id);
        $data = [
            'title' => $holidayPlan->title,
            'description' => $holidayPlan->description,
            'date' => $holidayPlan->date,
            'location' => $holidayPlan->location,
        ];
        $pdf = PDF::loadView('pdf.document', $data);
        return $pdf->download('document.pdf');
    }
}
