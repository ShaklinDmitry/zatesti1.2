<?php

namespace App\Http\Controllers;

use App\Models\TextForSplitIntoStatements;
use App\Services\SplitTextForStatementsService;
use Illuminate\Http\Request;

class TextForStatementsController extends Controller
{
    /**
     * Функция, которая получает  и сохраняет текст, который дальше парсится в высказывания
     *
     * @return void
     */
    public function createText(Request $request){
        $textForParsing = new TextForSplitIntoStatements();

        $result = $textForParsing->addText($request->text);

        if($result){
            $responseData = [
                "data" => [
                    "message" => "Text was added.",
                ]
            ];

            return response() -> json($responseData, 200);
        }else{
            $responseData = [
                "error" => [
                    "message" => "Text was not added."
                ]
            ];
            return response() -> json($responseData,200);
        }
    }


    public function splitTextIntoStatements(){
        $splitTextForStatementService = new SplitTextForStatementsService();
        $statements = $splitTextForStatementService->getStatements();


    }

}
