<?php

namespace KiriminAja\Contracts;

interface CourierContract
{
    /**
     * @return mixed
     */
    public function list();

    /**
     * @return mixed
     */
    public function group();

    /**
     * @param string $courierCode
     * @return mixed
     */
    public function detail(string $courierCode);
}
