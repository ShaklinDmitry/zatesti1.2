<?php

namespace App\classes\Text\Domain;

interface TextForStatementsInterface
{

    public function parseTextIntoStatements();

    public function markTextAsParsed();
}
