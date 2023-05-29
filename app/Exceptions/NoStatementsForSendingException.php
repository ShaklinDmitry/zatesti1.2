<?php

namespace App\Exceptions;

use Exception;

class NoStatementsForSendingException extends Exception
{
    private $options;

    public function __construct($message,
                                $code = 0,
                                Exception $previous = null,
                                $options = array())
    {
        parent::__construct($message, $code, $previous);

        $this->options = $options;
    }

    /**
     * Для возвращения значений, которые будут переданы вместе с исключением
     * @return mixed
     */
    public function getOptions() {
        return $this->options;
    }
}
