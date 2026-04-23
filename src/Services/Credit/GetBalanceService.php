<?php

namespace KiriminAja\Services\Credit;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\CreditRepository;
use KiriminAja\Responses\ServiceResponse;

class GetBalanceService extends ServiceBase
{
    private CreditRepository $creditRepo;

    public function __construct()
    {
        $this->creditRepo = new CreditRepository;
    }

    /**
     * @return ServiceResponse
     */
    public function call(): ServiceResponse
    {
        try {
            [$status, $data] = $this->creditRepo->balance();
            if ($status && isset($data['status']) && $data['status']) {
                return self::success($data['data'] ?? null, $data['text'] ?? 'loaded');
            }
            if (isset($data['status']) && !$data['status']) {
                return self::error(null, $data['text'] ?? 'Failed to fetch credit balance');
            }
            return self::error(null, json_encode($data));
        } catch (\Throwable $th) {
            return self::error(null, $th->getMessage());
        }
    }
}
