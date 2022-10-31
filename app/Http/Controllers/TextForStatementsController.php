<?php

namespace App\Http\Controllers;

use App\Exceptions\TextForStatementsIsNullException;
use App\Models\Statement;
use App\Models\TextForStatements;
use App\Services\StatementService;
use App\Services\TextForStatementsService;
use Illuminate\Http\Request;

class TextForStatementsController extends Controller
{
    /**
     * Функция, которая сохраняет текст
     *
     * @return json
     */
    public function createText(Request $request, TextForStatementsService $textService){

        $user = auth('sanctum')->user();
        $userAttributes = $user->getAttributes();

        $text = $textService->addText($request->text, $userAttributes['id']);

        if($text != null){
            $responseData = [
                "data" => [
                    "message" => "Text was added.",
                ]
            ];
        }else{
            $responseData = [
                "error" => [
                    "message" => "Text was not added."
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
    public function makeStatementsFromText(TextForStatementsService $textForStatementsService, StatementService $statementService){

        try{
            $makeStatementsResult = $textForStatementsService->makeStatements($statementService);

            $responseData = [
                "data" => [
                    "message" => "The text was divided into statements.",
                ]
            ];

            return response() -> json($responseData,200);

        }catch (\TextForStatementsIsNullException $e){

            echo $e->getMessage();

        }
    }

}
