<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use Avron\AvronException;
use Avron\Core\VisitableNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ParserJson extends ParserBase
{
    /**
     * @return VisitableNode
     * @throws AvronException
     */
    public function parseJson(): VisitableNode
    {
        // @formatter:off
        // phpcs:disable
        switch (($token = $this->peek())->getType()) {
            case Token::LBRACK: return $this->parseJsonArray();
            case Token::LBRACE: return $this->parseJsonObject();
            case Token::STRING: return $this->parseJsonString();
            case Token::NUMBER: return $this->parseJsonNumber();
            case Token::IDENT:
                switch ($token->getLoad()) {
                    case "true":
                    case "false": return $this->parseJsonBool();
                    case "null":  return $this->parseJsonNull();
                    default:      $this->throwUnexpectedTokenWithHint($token, "valid JSON");
                }
            default: $this->throwUnexpectedToken($token);
        }
        // phpcs:enable
        // @formatter:on
    }

    /**
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseJsonString(): VisitableNode
    {
        return new JsonValueNode($this->consume(Token::STRING)->getLoad());
    }

    /**
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseJsonNumber(): VisitableNode
    {
        return new JsonValueNode((float)$this->consume(Token::NUMBER)->getLoad());
    }

    /**
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseJsonBool(): VisitableNode
    {
        $token = $this->consume(Token::IDENT, "true", "false");
        return new JsonValueNode($token->getLoad() === "true");
    }

    /**
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseJsonNull(): VisitableNode
    {
        $this->consume(Token::IDENT, "null");
        return new JsonValueNode(null);
    }

    /**
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseJsonArray(): VisitableNode
    {
        $node = new JsonArrayNode();
        $this->consume(Token::LBRACK);

        if (!$this->expect(Token::RBRACK)) {
            $node->addNode($this->parseJson());

            while ($this->expect(Token::COMMA)) {
                $this->consume(Token::COMMA);
                $node->addNode($this->parseJson());
            }
        }
        $this->consume(Token::RBRACK);
        return $node;
    }

    /**
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseJsonObject(): VisitableNode
    {
        $node = new JsonObjectNode();
        $this->consume(Token::LBRACE);

        if (!$this->expect(Token::RBRACE)) {
            $node->addNode($this->parseJsonField());

            while ($this->expect(Token::COMMA)) {
                $this->consume(Token::COMMA);
                $node->addNode($this->parseJsonField());
            }
        }
        $this->consume(Token::RBRACE);
        return $node;
    }

    /**
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseJsonField(): VisitableNode
    {
        $node = new JsonFieldNode($this->consume(Token::STRING)->getLoad());
        $this->consume(Token::COLON);
        return $node->addNode($this->parseJson());
    }
}
