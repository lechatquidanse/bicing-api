<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Literal;
use Doctrine\ORM\Query\AST\SimpleArithmeticExpression;
use Doctrine\ORM\Query\Lexer;

/**
 * DQL function to use TimescaleDB "time_bucket" function.
 *
 * "time_bucket" "(" IntervalLiteral INTERVAL "," DateTimeExpression DATE ")"
 */
final class TimescaleDbTimeBucketFunctionDQL extends FunctionNode
{
    /** @var Literal */
    private $intervalLiteral;

    /** @var SimpleArithmeticExpression */
    private $datetimeExpression;

    /**
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     *
     * @return string
     *
     * @throws \Doctrine\ORM\Query\AST\ASTException
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker): string
    {
        return sprintf(
            'time_bucket(%s, %s)',
            $this->intervalLiteral->dispatch($sqlWalker),
            $this->datetimeExpression->dispatch($sqlWalker)
        );
    }

    /**
     * @param \Doctrine\ORM\Query\Parser $parser
     *
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->intervalLiteral = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->datetimeExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
