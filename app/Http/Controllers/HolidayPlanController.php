<?php


namespace App\Http\Controllers;

use App\DTOs\HolidayPlanDTO;
use App\OpenApi\RequestBodies\CreateHolidayPlanRequestBody;
use App\OpenApi\Responses\HolidayPlanPdfResponse;
use App\OpenApi\Responses\HolidayPlanResponse;
use App\Services\HolidayPlanService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PDF;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
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
     * @throws ValidationException
     */
    #[OpenApi\Operation(tags: ['holiday plan'])]
    #[OpenApi\RequestBody(factory: CreateHolidayPlanRequestBody::class)]
    #[OpenApi\Response(factory: HolidayPlanResponse::class)]
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
    #[OpenApi\Operation(tags: ['holiday plan'])]
    #[OpenApi\Response(factory: HolidayPlanResponse::class)]
    public function getAll()
    {
        return $this->service->getAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    #[OpenApi\Operation(tags: ['holiday plan'])]
    #[OpenApi\Response(factory: HolidayPlanResponse::class)]
    public function getById($id)
    {
        return $this->service->getById($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws ValidationException
     */
    #[OpenApi\Operation(tags: ['holiday plan'])]
    #[OpenApi\RequestBody(factory: CreateHolidayPlanRequestBody::class)]
    #[OpenApi\Response(factory: HolidayPlanResponse::class)]
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
    #[OpenApi\Operation(tags: ['holiday plan'])]
    #[OpenApi\Response(factory: HolidayPlanResponse::class)]
    public function delete($id): mixed
    {
        return $this->service->delete($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    #[OpenApi\Operation(tags: ['holiday plan'])]
    #[OpenApi\Response(factory: HolidayPlanPdfResponse::class)]
    public function generatePDF($id)
    {
        return $this->service->generatePDF($id);
    }
}
