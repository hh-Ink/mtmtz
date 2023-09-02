<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz\Contract;

interface RequestInterface
{
    public function getResult($response);

    public function getApiMethodName();

    public function getApiParams();
}
