<?php

namespace App\Modules\Text\Domain;

interface TextForStatementsInterface
{

    public function parseTextIntoStatements();

    public function markTextAsParsed();
}
