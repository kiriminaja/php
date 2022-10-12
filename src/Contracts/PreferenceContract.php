<?php

namespace KiriminAja\Contracts;

interface PreferenceContract {
    public function setWhiteListExpedition($services);
    public function setCallback($url);
}