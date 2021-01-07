<?php

namespace App\Payment\PagSeguro;

use PagSeguro\Services\Transactions\Notification as PagSeguroNotification;
use PagSeguro\Configuration\Configure;
use PagSeguro\Helpers\Xhr;
use InvalidArgumentException;

class Notification
{
    public function getTransaction()
    {
        if (!Xhr::hasPost()) {
            throw new InvalidArgumentException($_POST);
        }

        $response = PagSeguroNotification::check(
            Configure::getAccountCredentials()
        );

        return $response;
    }
}

