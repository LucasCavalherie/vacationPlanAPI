<?php


namespace App\Http\Controllers;

use App\DTOs\HolidayPlanDTO;
use App\Services\HolidayPlanService;
use Illuminate\Http\Request;

class HolidayPlanController extends Controller
{
    /**
     * @var HolidayPlanService
     */
    protected $service;

    public function __construct(HolidayPlanService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $dto = new HolidayPlanDTO(
            $request->input('title'),
            $request->input('description'),
            $request->input('date'),
            $request->input('location')
        );

        return $this->service->create($dto);
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->service->getAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->service->getById($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $dto = new HolidayPlanDTO(
            $request->input('title'),
            $request->input('description'),
            $request->input('date'),
            $request->input('location')
        );

        return $this->service->update($id, $dto);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}