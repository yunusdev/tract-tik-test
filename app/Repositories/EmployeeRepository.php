<?php


namespace App\Repositories;
use App\Contracts\EmployeeContract;
use App\Http\Transformers\EmployeeCollection;
use App\Http\Transformers\EmployeeResource;
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

    public function fetch(string|null $provider, int $limit): EmployeeCollection
    {
        $filter = $provider ? ['provider' => $provider] : [];
        return new EmployeeCollection($this->paginate($filter, $limit));
    }

    /**
     * @throws Exception
     */
    public function get(int $trackTikEmployeeId): EmployeeResource
    {
        $employee = $this->findOneBy(['track_tik_id' => $trackTikEmployeeId]);

        if(!$employee){
            throw new Exception('Employee with the Track Tik ID doesnt exist.', 404);
        }
        return EmployeeResource::make($employee);
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
            throw new Exception('This provider cant update the employee with the Track Tick ID.', 400);
        }

        $mappedTrackTikData["tags"] = [$provider];
        $employee = $this->trackTickApiService->updateEmployee($trackTikEmployeeId, $mappedTrackTikData);

        $data['provider'] = $provider;
        return $this->updateOrCreate($data, ['track_tik_id' => $employee['data']['id']]);
    }

}
