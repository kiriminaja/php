<?php

namespace KiriminAja\Services\Calculations;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\CalculationsRepository;
use KiriminAja\Responses\ServiceResponse;

class CodCalculationService extends ServiceBase
{
    private CalculationsRepository $repo;
    private array $data;

    public function __construct(array $data)
    {
        $this->repo = new CalculationsRepository;
        $this->data = $data;
    }

    public function call(): ServiceResponse
    {
        try {
            [$status, $data] = $this->repo->cod($this->data);
            if ($status && isset($data['status']) && $data['status']) {
                return self::success($data['results'] ?? null, $data['text'] ?? 'COD calculated');
            }
            if (isset($data['status']) && !$data['status']) {
                return self::error(null, $data['text'] ?? 'Failed to calculate COD');
            }
            return self::error(null, json_encode($data));
        } catch (\Throwable $th) {
            return self::error(null, $th->getMessage());
        }
    }
}
