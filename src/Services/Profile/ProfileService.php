<?php

namespace KiriminAja\Services\Profile;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\ProfileRepository;
use KiriminAja\Responses\ServiceResponse;

class ProfileService extends ServiceBase
{
    private ProfileRepository $repo;

    public function __construct()
    {
        $this->repo = new ProfileRepository;
    }

    public function call(): ServiceResponse
    {
        try {
            [$status, $data] = $this->repo->get();
            if ($status && isset($data['status']) && $data['status']) {
                return self::success($data['results'] ?? null, $data['text'] ?? 'Profile loaded');
            }
            if (isset($data['status']) && !$data['status']) {
                return self::error(null, $data['text'] ?? 'Failed to fetch profile');
            }
            return self::error(null, json_encode($data));
        } catch (\Throwable $th) {
            return self::error(null, $th->getMessage());
        }
    }
}
