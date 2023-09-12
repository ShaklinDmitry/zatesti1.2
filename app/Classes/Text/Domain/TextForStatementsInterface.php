<?php

namespace App\Classes\Text\Domain;

interface TextForStatementsInterface
{

    public function parseTextIntoStatements();

    public function markTextAsParsed();
}
