<?php
class OpeningHour
{
    private $OpeningHourID;
    private $OpeningHour;
    private $DayType;

    public function __construct($OpeningHourID, $OpeningHour, $DayType)
    {
        $this->OpeningHourID = $OpeningHourID;
        $this->OpeningHour = $OpeningHour;
        $this->DayType = $DayType;
    }

    public function getOpeningHourID()
    {
        return $this->OpeningHourID;
    }
    public function getOpeningHour()
    {
        return $this->OpeningHour;
    }
    public function getDayType()
    {
        return $this->DayType;
    }
}