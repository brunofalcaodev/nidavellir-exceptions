<?php

namespace Nidavellir\Exceptions;

use Nidavellir\Cube\Models\Api;

class ApiException extends \Exception
{
    public function __construct($message, Api $api = null)
    {
        // ensure assignment of all values correctly
        parent::__construct($message);
    }

    // representing the custom string object
    public function __toString()
    {
        return __CLASS__.": [{$this->code}]: {$this->message}\n";
    }
}
