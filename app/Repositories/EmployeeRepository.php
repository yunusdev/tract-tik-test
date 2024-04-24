<?php


namespace App\Repositories;
use App\Contracts\EmployeeContract;
use App\Schemas\EmployeeProvider1;
use App\Schemas\EmployeeProvider2;
use App\Services\TrackTickApiService;
use GuzzleHttp\Exception\GuzzleException;

class EmployeeRepository implements EmployeeContract
{

    protected TrackTickApiService $trackTickApiService;

    public function __construct(TrackTickApiService $trackTickApiService)
    {
        $this->trackTickApiService = $trackTickApiService;
    }

    /**
     * @throws GuzzleException
     */
    public function storeEmployee(string $provider, array $data)
    {
        $mappedData = match ($provider){
            EmployeeProvider1::$providerName => EmployeeProvider1::mapAttributes($data),
            EmployeeProvider2::$providerName => EmployeeProvider2::mapAttributes($data),
        };

        $mappedData["tags"] = [$provider];

        return $this->trackTickApiService->storeEmployee($mappedData);
    }

}
