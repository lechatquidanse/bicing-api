<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Literal;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\Lexer;

/** @todo add comment to explain how it works */
class TimescaleDbTimeBucketFunction extends FunctionNode
{
    /** @var Literal */
    private $intervalLiteral;

    /** @var PathExpression */
    private $fieldExpression;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $sql = sprintf(
            'time_bucket(%s, %s)',
            $this->intervalLiteral->dispatch($sqlWalker),
            $this->fieldExpression->dispatch($sqlWalker));

        return $sql;
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->intervalLiteral = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->fieldExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
