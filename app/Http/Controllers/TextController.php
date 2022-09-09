<?php

namespace App\Http\Controllers;

use App\Exceptions\TextForStatementsIsNullException;
use App\Models\Statement;
use App\Models\TextForStatements;
use App\Services\StatementService;
use App\Services\TextForStatementsService;
use Illuminate\Http\Request;

class TextController extends Controller
{
    /**
     * Функция, которая получает  и сохраняет текст, который дальше парсится в высказывания
     *
     * @return json
     */
    public function createText(Request $request, TextForStatementsService $textService){

        $textCreateResult = $textService->addText($request->text);

        if($textCreateResult){
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
    public function makeStatementsFromText(TextForStatementsService $textService, StatementService $statementService){

        try{
            $statements = $textService->makeStatements();

            $statementService->saveStatements($statements);

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
