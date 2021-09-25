<?php

namespace Nidavellir\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Nidavellir\Cube\Models\Error;

class ErrorException extends Exception
{
    protected $payload;
    protected $message;
    protected $model;

    public function __construct(string $message, mixed $payload = [], Model $model = null)
    {
        [$this->payload, $this->message, $this->model] =
            [$payload, $message, $model];

        parent::__construct($message);
    }

    public function report()
    {
        // Save in the error log.
        $error = Error::create([
            'message' => $this->message,
            'trace' => $this->getTraceAsString(),
            'code' => $this->getCode(),
            'payload' => json_encode($this->payload),
        ]);

        if ($this->model) {
            $error->related()->associate($this->model)->save();
        }
    }
}
