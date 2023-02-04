<?php

namespace KiriminAja\Contracts;

interface PreferenceContract {
    public function setWhiteListExpedition(array $services);
    public function setCallback(string $url);
}
