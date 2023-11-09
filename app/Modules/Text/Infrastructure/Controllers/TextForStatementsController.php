<?php

namespace App\Modules\Text\Infrastructure\Controllers;

use App\Modules\Text\Application\UseCases\SaveTextForStatementsCommand;
use App\Modules\Text\Application\UseCases\SaveTextForStatementsCommandInterface;
use App\Modules\Text\Infrastructure\Jobs\MakeStatementsFromText;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use App\Modules\Text\Infrastructure\Requests\TextForStatementsRequest;
use App\Exceptions\TextForStatementsIsNullException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\json;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TextForStatementsController extends Controller
{
    /**
     * Функция, которая сохраняет текст
     * @param TextForStatementsRequest $request
     * @param SaveTextForStatementsCommandInterface $saveTextForStatementsCommand
     * @return JsonResponse
     */
    public function createText(TextForStatementsRequest $request, SaveTextForStatementsCommandInterface $saveTextForStatementsCommand):JsonResponse{

        $textForStatementsDTO = $saveTextForStatementsCommand->execute(userId: Auth::id(), text: $request->text);

        if($textForStatementsDTO){
            $responseData = [
                    "data" => [
                        "message" => "Text was added.",
                        "text_id" => $textForStatementsDTO->guid
                    ]
                ];
        }

        return response() -> json($responseData,200);

    }

    /**
     * разделить текст на высказывания и записать в БД
     *
     * @return json
     */
    public function makeStatementsFromText(){

            MakeStatementsFromText::dispatch(Auth::id());

            $responseData = [
                "data" => [
                    "message" => "The text was divided into statements.",
                ]
            ];

            return response() -> json($responseData,200);
            
    }

}
