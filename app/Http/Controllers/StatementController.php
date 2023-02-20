<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetStatementsRequest;
use App\Models\Statement;
use App\Models\TextForStatements;
use App\Services\StatementService;
use App\Services\TextForStatementsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreateStatementRequest;
use Illuminate\Support\Facades\Auth;

class StatementController extends Controller
{

    /**
     * функция для создания высказывания
     * @param CreateStatementRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createStatement(CreateStatementRequest $request):JsonResponse{

        try{
            $statementService = new StatementService();
            $statement = $statementService->addStatement($request->text, Auth::id());

            if($statement){
                return response() -> json(["data" => ["message" => "Statement was create successfull.",
                ]],200);
            }
        }catch(\Exception $exception){
            return response() -> json(["error" => ["message" => $exception->getMessage(),
            ]],$exception->getCode());
        }
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
