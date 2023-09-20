<?php

namespace App\Modules\BestStatements\Application;

use App\Modules\BestStatements\Domain\BestStatementRepositoryInterface;

class AddBestStatementUseCase
{

    public function __construct(private string $chatId,private string $text, private BestStatementRepositoryInterface $bestStatementRepository)
    {
    }

    public function execute()
    {
        return $this->bestStatementRepository->addBestStatement(chatId: $this->chatId, text: $this->text);
    }
}
