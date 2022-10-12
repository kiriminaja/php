<?php

namespace KiriminAja\Contracts;

interface AddressContract {
    public function provinces();
    public function cities($provinceId);
    public function districts($cityId);
    public function districtsByName($name);
}