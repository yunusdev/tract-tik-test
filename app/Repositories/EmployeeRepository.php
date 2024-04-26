<?php


namespace App\Repositories;
use App\Contracts\EmployeeContract;
use App\Models\Employee;
use App\Schemas\EmployeeProvider1;
use App\Schemas\EmployeeProvider2;
use App\Services\TrackTickApiService;
use GuzzleHttp\Exception\GuzzleException;
use Exception;

class EmployeeRepository extends BaseRepository implements EmployeeContract
{

    protected TrackTickApiService $trackTickApiService;

    public function __construct(Employee $model, TrackTickApiService $trackTickApiService)
    {
        parent::__construct($model);
        $this->trackTickApiService = $trackTickApiService;
    }

    /**
     * @throws GuzzleException
     */
    public function fetch(string|null $provider)
    {
        return $this->trackTickApiService->fetchEmployees($provider);
    }

    public function get(int $employeeId)
    {
        return $this->trackTickApiService->getEmployee($employeeId);
    }

    /**
     * @throws GuzzleException
     */
    public function storeEmployee(string $provider, array $data)
    {
        $mappedTrackTikData = match ($provider){
            EmployeeProvider1::$providerName => EmployeeProvider1::mapTrackTikAttributes($data),
            EmployeeProvider2::$providerName => EmployeeProvider2::mapTrackTikAttributes($data),
        };

        $mappedTrackTikData["tags"] = [$provider];
        $employee = $this->trackTickApiService->storeEmployee($mappedTrackTikData);

        $data['track_tik_id'] = $employee['data']['id'];
        $data['provider'] = $provider;

        return $this->store($data);

    }

    /**
     * @throws Exception|GuzzleException
     */
    public function updateEmployee(string $provider, int $trackTikEmployeeId, array $data)
    {
        $mappedTrackTikData = match ($provider){
            EmployeeProvider1::$providerName => EmployeeProvider1::mapTrackTikAttributes($data),
            EmployeeProvider2::$providerName => EmployeeProvider2::mapTrackTikAttributes($data),
        };

        $employee = $this->findOneBy(['track_tik_id' => $trackTikEmployeeId]);
        if($employee && $employee->provider !== $provider){
            info($employee);
            throw new Exception('This provider cant update the employee with the Track Tick ID.', 400);
        }

        $mappedTrackTikData["tags"] = [$provider];
        $employee = $this->trackTickApiService->updateEmployee($trackTikEmployeeId, $mappedTrackTikData);

        $data['provider'] = $provider;
        return $this->updateOrCreate($data, ['track_tik_id' => $employee['data']['id']]);
    }

}
