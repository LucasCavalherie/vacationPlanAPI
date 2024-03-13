<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\HolidayPlanResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class HolidayPlanResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->description('Requisição com sucesso')
            ->content(MediaType::json()->schema(HolidayPlanResponseSchema::ref()));
    }
}
