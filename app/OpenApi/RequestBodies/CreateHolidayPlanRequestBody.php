<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\HolidayPlanRequestSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;


class CreateHolidayPlanRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('CustomerCreate')
            ->description('Criar novo Cliente')
            ->content(MediaType::json()->schema(HolidayPlanRequestSchema::ref()));
    }
}
