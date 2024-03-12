<?php

namespace App\DTOs;

class HolidayPlanDTO
{
    public $title;
    public $description;
    public $date;
    public $location;

    /**
     * @param $title
     * @param $description
     * @param $date
     * @param $location
     */
    public function __construct($title, $description, $date, $location)
    {
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->location = $location;
    }
}

