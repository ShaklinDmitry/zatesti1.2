<?php

namespace App\Http\Controllers;

use App\Exceptions\NoStatementsException;
use App\Models\Statement;
use App\Models\TextForStatements;
use App\Services\StatementService;
use App\Services\TextForStatementsService;
use App\Services\UserResponseService;
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
     * @return JsonResponse
     */
    public function getStatements():JsonResponse{

        try{
            $statementService = new StatementService();
            $statements = $statementService->getStatements(Auth::id());

            $responseData = [
                "data" => [
                    "statements" => $statements
                ]
            ];

            return response() -> json($responseData,200);

        }catch(NoStatementsException $exception){

            return response() -> json([
                "error" => [
                    "message" => $exception->getMessage()
                ]
            ], $exception->getCode());

        }catch (\Exception $exception){
            return response() -> json(["error" => ["message" => $exception->getMessage(),
            ]], $exception->getCode());
        }
    }


    /**
     * Удалить высказывание
     *
     * @return json
     */
    public function destroy(Request $request){
        $statementService = new StatementService();
        $delete = $statementService->deleteStatement($request->id);

        if($delete){
            return response() -> json(["data" => ["message" => "Statement was deleted."]], 200);
        }else{
            return response() -> json(["error" => ["message" => "Statement was not deleted."]], 200);
        }
    }

    /**
     * Функция для того чтобы сделать обычное высказывание лучшим
     * @param Request $request
     * @return JsonResponse|void
     */
    public function makeStatementTheBest(Request $request){
        $statementService = new StatementService();
        $updateBestStatement = $statementService->makeStatementBest($request->id);

        if($updateBestStatement == true){
            return response() -> json(["data" => ["message" => "Statement now is best."]], 200);
        }
    }

}
