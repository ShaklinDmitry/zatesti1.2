<?php

namespace App\classes\Text\Domain;

use App\classes\Text\Application\MakeStatementsFromText;
use App\Exceptions\TextForStatementsIsNullException;
use App\Models\TextForStatementsModel;

class TextForStatements implements TextForStatementsInterface
{

    public function __construct(public TextForStatementsRepositoryInterface $textForStatementsRepository)
    {

    }

    public function makeStatementsFromText(int $userId)
    {
        $unparsedText = $this->getUnparsedTextForStatements($userId);
        $statements = $this->parseTextIntoStatements($unparsedText);
        $this->markTextAsParsed($unparsedText['id']);
        MakeStatementsFromText::dispatch(...$statements);
    }

    /**
     * Функция для получения текста, который еще не был распарсен на высказывания
     * @param int $userId
     * @return mixed
     * @throws TextForStatementsIsNullException
     */
    private function getUnparsedTextForStatements(int $userId){
        $unParsedText = $this->textForStatementsRepository->getUnparsedTextForStatementsByUserId($userId);

        if($unParsedText == null){
            throw new TextForStatementsIsNullException();
        }

        return $unParsedText;
    }


    /**
     *
     * @param string $text
     * @return string[]
     */
    private function parseTextIntoStatements(string $text): array{
        $statements = explode(".", $text);
        return $statements;
    }

    /**
     * @param int $textId
     * @return mixed
     */
    private function markTextAsParsed(int $textId){
        $markTextResult = TextForStatementsModel::where('id', $textId)->update(['is_parsed' => 1]);

        return $markTextResult;
    }

}
