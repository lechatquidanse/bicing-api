<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Literal;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\Lexer;

/**
 * DQL function to use TimescaleDB "time_bucket" function.
 *
 * "time_bucket" "(" IntervalLiteral INTERVAL "," DateTimeExpression DATE ")"
 */
class TimescaleDbTimeBucketFunction extends FunctionNode
{
    /** @var Literal */
    private $intervalLiteral;

    /** @var PathExpression */
    private $datetimeExpression;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $sql = sprintf(
            'time_bucket(%s, %s)',
            $this->intervalLiteral->dispatch($sqlWalker),
            $this->datetimeExpression->dispatch($sqlWalker));

        return $sql;
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->intervalLiteral = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->datetimeExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
