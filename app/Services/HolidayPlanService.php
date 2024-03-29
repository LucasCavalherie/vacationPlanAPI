<?php


namespace App\Services;

use App\DTOs\HolidayPlanDTO;
use App\Models\HolidayPlan;
use App\Repositories\HolidayPlanRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDF;

class HolidayPlanService
{
    /**
     * @var HolidayPlanRepository
     */
    protected $repository;

    /**
     * @param HolidayPlanRepository|null $repository
     */
    public function __construct(?HolidayPlanRepository $repository = null)
    {
        $this->repository = $repository ?? new HolidayPlanRepository();
    }


    /*
     |--------------------------------------------------------------------------
     | Protected methods
     |--------------------------------------------------------------------------
     */

    /**
     * @param HolidayPlanDTO $dto
     * @return void
     * @throws ValidationException
     */
    protected function validate(HolidayPlanDTO $dto): void
    {
        $validator = Validator::make((array)$dto, HolidayPlan::$rules);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
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
     * @throws ValidationException
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
     * @throws ValidationException
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
