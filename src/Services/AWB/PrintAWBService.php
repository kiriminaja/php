<?php

namespace KiriminAja\Services\AWB;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\AWBRepository;
use KiriminAja\Responses\ServiceResponse;

class PrintAWBService extends ServiceBase
{
    private AWBRepository $repo;
    private array $data;

    public function __construct(array $data)
    {
        $this->repo = new AWBRepository;
        $this->data = $data;
    }

    public function call(): ServiceResponse
    {
        try {
            [$status, $data] = $this->repo->print($this->data);
            if ($status && isset($data['status']) && $data['status']) {
                return self::success($data['data'] ?? null, $data['text'] ?? 'AWB printed');
            }
            if (isset($data['status']) && !$data['status']) {
                return self::error(null, $data['text'] ?? 'Failed to print AWB');
            }
            return self::error(null, json_encode($data));
        } catch (\Throwable $th) {
            return self::error(null, $th->getMessage());
        }
    }
}
