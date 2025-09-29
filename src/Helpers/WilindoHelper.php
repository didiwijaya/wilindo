<?php

namespace DidiWijaya\WilIndo\Helpers;

use DidiWijaya\WilIndo\Models\Province;
use DidiWijaya\WilIndo\Models\City;
use DidiWijaya\WilIndo\Models\District;
use DidiWijaya\WilIndo\Models\Village;

class WilindoHelper
{
    /**
     * Get all provinces
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getProvinces()
    {
        return Province::orderBy('name')->get();
    }

    /**
     * Get cities by province code
     *
     * @param string $provinceCode
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getCitiesByProvince(string $provinceCode)
    {
        return City::byProvince($provinceCode)->orderBy('name')->get();
    }

    /**
     * Get districts by city code
     *
     * @param string $cityCode
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDistrictsByCity(string $cityCode)
    {
        return District::byCity($cityCode)->orderBy('name')->get();
    }

    /**
     * Get villages by district code
     *
     * @param string $districtCode
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getVillagesByDistrict(string $districtCode)
    {
        return Village::byDistrict($districtCode)->orderBy('name')->get();
    }

    /**
     * Get complete address hierarchy by village code
     *
     * @param string $villageCode
     * @return array|null
     */
    public static function getCompleteAddress(string $villageCode)
    {
        $village = Village::with(['district.city.province'])->byCode($villageCode)->first();
        
        if (!$village) {
            return null;
        }

        return [
            'village' => $village->name,
            'district' => $village->district->name,
            'city' => $village->district->city->name,
            'province' => $village->district->city->province->name,
            'village_code' => $village->code,
            'district_code' => $village->district->code,
            'city_code' => $village->district->city->code,
            'province_code' => $village->district->city->province->code,
        ];
    }

    /**
     * Search provinces by name
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchProvinces(string $name)
    {
        return Province::byName($name)->orderBy('name')->get();
    }

    /**
     * Search cities by name
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchCities(string $name)
    {
        return City::byName($name)->orderBy('name')->get();
    }

    /**
     * Search districts by name
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchDistricts(string $name)
    {
        return District::byName($name)->orderBy('name')->get();
    }

    /**
     * Search villages by name
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchVillages(string $name)
    {
        return Village::byName($name)->orderBy('name')->get();
    }

    /**
     * Get province by code
     *
     * @param string $code
     * @return \DidiWijaya\WilIndo\Models\Province|null
     */
    public static function getProvinceByCode(string $code)
    {
        return Province::byCode($code)->first();
    }

    /**
     * Get city by code
     *
     * @param string $code
     * @return \DidiWijaya\WilIndo\Models\City|null
     */
    public static function getCityByCode(string $code)
    {
        return City::byCode($code)->first();
    }

    /**
     * Get district by code
     *
     * @param string $code
     * @return \DidiWijaya\WilIndo\Models\District|null
     */
    public static function getDistrictByCode(string $code)
    {
        return District::byCode($code)->first();
    }

    /**
     * Get village by code
     *
     * @param string $code
     * @return \DidiWijaya\WilIndo\Models\Village|null
     */
    public static function getVillageByCode(string $code)
    {
        return Village::byCode($code)->first();
    }

    /**
     * Get statistics of data
     *
     * @return array
     */
    public static function getStatistics()
    {
        return [
            'provinces' => Province::count(),
            'cities' => City::count(),
            'districts' => District::count(),
            'villages' => Village::count(),
        ];
    }
}
