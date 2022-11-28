<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetStatementsRequest;
use App\Models\Statement;
use App\Models\TextForStatements;
use App\Services\StatementService;
use App\Services\TextForStatementsService;
use Illuminate\Http\Request;
use App\Http\Requests\CreateStatementRequest;
use Illuminate\Support\Facades\Auth;

class StatementController extends Controller
{

    /**
     * создать новое высказывание
     * @return json
     */
    public function createStatement(CreateStatementRequest $request, StatementService $statementService){

        $createStatementResult = $statementService->addStatement($request->text, Auth::id());

        $responseData = [
            "data" => [
                "message" => "Statement was create successfull.",
            ]
        ];

        return response() -> json($responseData,200);
    }


    /**
     * Получить все высказывания у конкретного пользователя
     * @return json
     */
    public function getStatements(GetStatementsRequest $request, StatementService $statementService){

        $statements = $statementService->getStatements(Auth::id());

        $responseData = [
            "data" => [
                "statements" => $statements
            ]
        ];

        return response() -> json($responseData,200);
    }


    /**
     * Удалить высказывание
     *
     * @return json
     */
    public function deleteStatement(Request $request){
        $statement = new Statement();

        $result = $statement->deleteItem($request->id);

        if($result){
            $responseData = [
                "data" => [
                    "message" => "Statement was deleted.",
                ]
            ];

            return response() -> json($responseData, 200);
        }else{
            $responseData = [
                "error" => [
                    "message" => "Statement not deleted."
                ]
            ];
            return response() -> json($responseData,200);
        }

    }


}
