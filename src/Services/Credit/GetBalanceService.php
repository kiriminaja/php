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
            if ($status && (!isset($data['status']) || $data['status'])) {
                $balance = $this->extractBalance(is_array($data) ? $data : []);
                if ($balance === null) {
                    return self::error(null, 'Credit balance is missing from the API response');
                }

                return self::success(['balance' => $balance], $data['text'] ?? $data['message'] ?? 'loaded');
            }
            if (isset($data['status']) && !$data['status']) {
                return self::error(null, $data['text'] ?? $data['message'] ?? 'Failed to fetch credit balance');
            }
            return self::error(null, json_encode($data));
        } catch (\Throwable $th) {
            return self::error(null, $th->getMessage());
        }
    }

    private function extractBalance(array $data): float|int|null
    {
        foreach (['results', 'result', 'data', 'payload'] as $key) {
            if (isset($data[$key]) && is_array($data[$key]) && isset($data[$key]['balance']) && is_numeric($data[$key]['balance'])) {
                return $data[$key]['balance'] + 0;
            }
        }

        if (isset($data['balance']) && is_numeric($data['balance'])) {
            return $data['balance'] + 0;
        }

        return null;
    }
}
