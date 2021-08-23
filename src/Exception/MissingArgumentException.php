<?php

namespace OwenVoke\OpenSea\Exception;

use ErrorException;
use Throwable;

class MissingArgumentException extends ErrorException
{
    /** @param string|array<int, string> $required */
    public function __construct($required, int $code = 0, ?Throwable $previous = null)
    {
        if (is_string($required)) {
            $required = [$required];
        }

        parent::__construct(sprintf('One or more of required ("%s") parameters is missing!', implode('", "', $required)), $code, 1, __FILE__, __LINE__, $previous);
    }
}
