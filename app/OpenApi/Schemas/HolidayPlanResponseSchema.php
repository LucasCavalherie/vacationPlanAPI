<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class HolidayPlanResponseSchema extends SchemaFactory implements Reusable
{
    /**
     * @return SchemaContract
     */
    public function build(): SchemaContract
    {
        return Schema::object('HolidayPlanResponseSchema')
            ->properties(
                Schema::string('title')->description('Holiday Title')->example('New Year'),
                Schema::string('description')->description('Holiday Description')->example('A beautiful day for alcoholics'),
                Schema::string('date')->description('Holiday date')->example('2024-01-01T00:00:00.000000Z'),
                Schema::string('location')->description('Location of Holiday')->example('Sidney'),
                Schema::string('created_at')->description('Data de criação')->example('2024-03-13T01:42:50.000000Z'),
                Schema::string('updated_at')->description('Data da última atualização')->example('2024-03-13T01:42:50.000000Z')
            );
    }
}
