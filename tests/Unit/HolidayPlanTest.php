<?php

namespace Tests\Unit;

use App\DTOs\HolidayPlanDTO;
use App\Helper\DateTimeHelper;
use App\Models\HolidayPlan;
use App\Services\HolidayPlanService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class HolidayPlanTest extends TestCase
{

    /**
     * @var HolidayPlanService
     */
    private HolidayPlanService $holidayPlanService;


    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->holidayPlanService = new HolidayPlanService();
    }

    /**
     * @return void
     */
    public function testGetAllHolidayPlan_ShouldReturn10HolidayPlans()
    {
        HolidayPlan::factory()->count(10)->create();
        $response = $this->holidayPlanService->getAll();
        $this->assertCount(10, $response);
    }

    /**
     * @return void
     */
    public function testGetAllHolidayPlan_ShouldReturnHolidayPlanWithCorrectData()
    {
        HolidayPlan::factory()->create([
            'title' => 'Valentines Day',
            'description' => 'A beautiful day for lovers',
            'date' => '2024-02-14',
            'location' => 'Paris'
        ]);
        HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);
        HolidayPlan::factory()->create([
            'title' => 'New Year',
            'description' => 'A beautiful day for alcoholics',
            'date' => '2024-01-01',
            'location' => 'Sidney'
        ]);
        $response = $this->holidayPlanService->getAll();
        $this->assertCount(3, $response);

        $this->assertEquals('Valentines Day', $response[0]['title']);
        $this->assertEquals('A beautiful day for lovers', $response[0]['description']);
        $this->assertEquals('2024-02-14', DateTimeHelper::formatDate($response[0]['date']));
        $this->assertEquals('Paris', $response[0]['location']);

        $this->assertEquals('Christmas', $response[1]['title']);
        $this->assertEquals('A beautiful day for Santa Claus', $response[1]['description']);
        $this->assertEquals('2024-12-25', DateTimeHelper::formatDate($response[1]['date']));
        $this->assertEquals('North Pole', $response[1]['location']);

        $this->assertEquals('New Year', $response[2]['title']);
        $this->assertEquals('A beautiful day for alcoholics', $response[2]['description']);
        $this->assertEquals('2024-01-01', DateTimeHelper::formatDate($response[2]['date']));
        $this->assertEquals('Sidney', $response[2]['location']);
    }

    /**
     * @return void
     */
    public function testGetAllHolidayPlan_ShouldReturnEmpty_WhenHasNoHolidayPlan()
    {
        $response = $this->holidayPlanService->getAll();
        $this->assertCount(0, $response);
    }

    /**
     * @return void
     */
    public function testGetByIdHolidayPlan_ShouldReturnHolidayPlan()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Valentines Day',
            'description' => 'A beautiful day for lovers',
            'date' => '2024-02-14',
            'location' => 'Paris'
        ]);
        $response = $this->holidayPlanService->getById($holidayPlan->id);

        $this->assertEquals('Valentines Day', $response['title']);
        $this->assertEquals('A beautiful day for lovers', $response['description']);
        $this->assertEquals('2024-02-14', DateTimeHelper::formatDate($response['date']));
        $this->assertEquals('Paris', $response['location']);
    }

    /**
     * @return void
     */
    public function testGetByIdHolidayPlan_ShouldBeException_WhenWrongId()
    {
        HolidayPlan::factory()->create([
            'title' => 'Valentines Day',
            'description' => 'A beautiful day for lovers',
            'date' => '2024-02-14',
            'location' => 'Paris'
        ]);
        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('No query results for model [App\Models\HolidayPlan] 9999');
        $this->holidayPlanService->getById(9999);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testCreateHolidayPlan_ShouldCreateHolidayPlan()
    {
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            '2024-02-14',
            'Paris'
        );

        $response = $this->holidayPlanService->create($holidayPlanDTO);

        $this->assertEquals('Valentines Day', $response['title']);
        $this->assertEquals('A beautiful day for lovers', $response['description']);
        $this->assertEquals('2024-02-14', DateTimeHelper::formatDate($response['date']));
        $this->assertEquals('Paris', $response['location']);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testCreateHolidayPlan_ShouldBeException_WhenWrongTitle()
    {
        $holidayPlanDTO = new HolidayPlanDTO(
            123,
            'A beautiful day for lovers',
            '2024-02-14',
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The title field must be a string.');
        $this->holidayPlanService->create($holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testCreateHolidayPlan_ShouldBeException_WhenNullTitle()
    {
        $holidayPlanDTO = new HolidayPlanDTO(
            null,
            'A beautiful day for lovers',
            '2024-02-14',
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The title field is required.');
        $this->holidayPlanService->create($holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testCreateHolidayPlan_ShouldBeException_WhenNullDescription()
    {
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            null,
            '2024-02-14',
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The description field is required.');
        $this->holidayPlanService->create($holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testCreateHolidayPlan_ShouldBeException_WhenWrongDescription()
    {
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            123,
            '2024-02-14',
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The description field must be a string.');
        $this->holidayPlanService->create($holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testCreateHolidayPlan_ShouldBeException_WhenNullDate()
    {
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            null,
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The date field is required.');
        $this->holidayPlanService->create($holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testCreateHolidayPlan_ShouldBeException_WhenWrongDateType()
    {
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            123,
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The date field must match the format Y-m-d.');
        $this->holidayPlanService->create($holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testCreateHolidayPlan_ShouldBeException_WhenWrongDateFormat()
    {
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            '01/01/2024',
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The date field must match the format Y-m-d.');
        $this->holidayPlanService->create($holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testCreateHolidayPlan_ShouldBeException_WhenNullLocation()
    {
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            '2024-02-14',
            null
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The location field is required.');
        $this->holidayPlanService->create($holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testCreateHolidayPlan_ShouldBeException_WhenWrongLocation()
    {
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            '2024-02-14',
            123
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The location field must be a string.');
        $this->holidayPlanService->create($holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testUpdateHolidayPlan_ShouldUpdateHolidayPlan()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            '2024-02-14',
            'Paris'
        );

        $response = $this->holidayPlanService->update($holidayPlan->id, $holidayPlanDTO);

        $this->assertEquals($holidayPlan->id, $response['id']);
        $this->assertEquals('Valentines Day', $response['title']);
        $this->assertEquals('A beautiful day for lovers', $response['description']);
        $this->assertEquals('2024-02-14', DateTimeHelper::formatDate($response['date']));
        $this->assertEquals('Paris', $response['location']);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testUpdateHolidayPlan_ShouldBeException_WhenWrongTitle()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);
        $holidayPlanDTO = new HolidayPlanDTO(
            123,
            'A beautiful day for lovers',
            '2024-02-14',
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The title field must be a string.');
        $this->holidayPlanService->update($holidayPlan->id, $holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testUpdateHolidayPlan_ShouldBeException_WhenNullTitle()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);
        $holidayPlanDTO = new HolidayPlanDTO(
            null,
            'A beautiful day for lovers',
            '2024-02-14',
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The title field is required.');
        $this->holidayPlanService->update($holidayPlan->id, $holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testUpdateHolidayPlan_ShouldBeException_WhenNullDescription()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            null,
            '2024-02-14',
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The description field is required.');
        $this->holidayPlanService->update($holidayPlan->id, $holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testUpdateHolidayPlan_ShouldBeException_WhenWrongDescription()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            123,
            '2024-02-14',
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The description field must be a string.');
        $this->holidayPlanService->update($holidayPlan->id, $holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testUpdateHolidayPlan_ShouldBeException_WhenNullDate()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            null,
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The date field is required.');
        $this->holidayPlanService->update($holidayPlan->id, $holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testUpdateHolidayPlan_ShouldBeException_WhenWrongDateType()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            123,
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The date field must match the format Y-m-d.');
        $this->holidayPlanService->update($holidayPlan->id, $holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testUpdateHolidayPlan_ShouldBeException_WhenWrongDateFormat()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            '01/01/2024',
            'Paris'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The date field must match the format Y-m-d.');
        $this->holidayPlanService->update($holidayPlan->id, $holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testUpdateHolidayPlan_ShouldBeException_WhenNullLocation()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            '2024-02-14',
            null
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The location field is required.');
        $this->holidayPlanService->update($holidayPlan->id, $holidayPlanDTO);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testUpdateHolidayPlan_ShouldBeException_WhenWrongLocation()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);
        $holidayPlanDTO = new HolidayPlanDTO(
            'Valentines Day',
            'A beautiful day for lovers',
            '2024-02-14',
            123
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The location field must be a string.');
        $this->holidayPlanService->update($holidayPlan->id, $holidayPlanDTO);
    }

    /**
     * @return void
     */
    public function testDeleteHolidayPlan_ShouldDeleteHolidayPlan()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);

        $response = $this->holidayPlanService->delete($holidayPlan->id);

        $this->assertEquals($holidayPlan->id, $response['id']);
        $this->assertNotNull($response['deleted_at']);
    }

    /**
     * @return void
     */
    public function testDeleteHolidayPlan_ShouldBeException_WhenIdNotFound()
    {
        HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole'
        ]);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('No query results for model [App\Models\HolidayPlan] 9999');
        $this->holidayPlanService->delete(9999);
    }

    /**
     * @return void
     */
    public function testDeleteHolidayPlan_ShouldBeException_WhenAlreadyDeleted()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'title' => 'Christmas',
            'description' => 'A beautiful day for Santa Claus',
            'date' => '2024-12-25',
            'location' => 'North Pole',
            'deleted_at' => now()
        ]);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('No query results for model [App\Models\HolidayPlan] ' . $holidayPlan->id);
        $this->holidayPlanService->delete($holidayPlan->id);
    }

    /**
     * @return void
     */
    public function testGeneratePDF_ShouldReturnPDF_WhenValidId()
    {
        $holidayPlan = HolidayPlan::factory()->create();

        $this->mock(HolidayPlanService::class)
            ->shouldReceive('getById')
            ->with($holidayPlan->id)
            ->andReturn($holidayPlan);

        $response = $this->holidayPlanService->generatePDF($holidayPlan->id);
        $this->assertStringContainsString('%PDF-', $response->getContent());
    }

    /**
     * @return void
     */
    public function testGeneratePDF_ShouldBeException_WhenInvalidId()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->holidayPlanService->generatePDF(9999);
    }
}
