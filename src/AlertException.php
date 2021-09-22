<?php

namespace Nidavellir\Exceptions;

use Nidavellir\Cube\Models\Alert;

class AlertException extends \Exception
{
    public function __construct($message, array|string $headers = null, array|string $body = null, Alert $alert = null)
    {
        if ($alert) {
            $alert->headers ??= $headers;
            $alert->body ??= $body;
            $alert->error = $message;
            $alert->status = 'error';
            $alert->save();
        } else {
            Alert::create([
                'headers' => $headers,
                'body' => $body,
                'error' => $message,
                'status' => 'error',
            ]);
        }

        // ensure assignment of all values correctly
        parent::__construct($message);
    }

    // representing the custom string object
    public function __toString()
    {
        return __CLASS__.": [{$this->code}]: {$this->message}\n";
    }
}
