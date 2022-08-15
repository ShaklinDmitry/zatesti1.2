<?php

namespace App\Exceptions;

use Exception;

class TextForStatementsIsNullException extends Exception
{
    /**
     * функция для вывода информации об ошибке
     * @param $request
     * @return mixed
     */
    public function render($request)
    {
        return response()->json([
            'error' => 'Текст для извлечения высказываний отсутвует'
        ]);
    }
}
