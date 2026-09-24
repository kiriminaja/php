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
            if ($status && (!isset($data['status']) || $data['status'])) {
                $profile = $this->extractProfile($data);
                if ($profile === null) {
                    return self::error(null, 'Profile data is missing from the API response');
                }

                return self::success($profile, $data['text'] ?? $data['message'] ?? 'Profile loaded');
            }
            if (isset($data['status']) && !$data['status']) {
                return self::error(null, $data['text'] ?? $data['message'] ?? 'Failed to fetch profile');
            }
            return self::error(null, json_encode($data));
        } catch (\Throwable $th) {
            return self::error(null, $th->getMessage());
        }
    }

    private function extractProfile(array $data): ?array
    {
        foreach (['results', 'result', 'data'] as $key) {
            if (isset($data[$key]) && is_array($data[$key])) {
                return $data[$key];
            }
        }

        if (isset($data['id']) || isset($data['name']) || isset($data['email']) || isset($data['metadata'])) {
            return $data;
        }

        return null;
    }
}
