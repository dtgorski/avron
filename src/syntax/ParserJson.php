<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\AvroException;

class ParserJson extends ParserBase
{
    /**
     * @return Node
     * @throws AvroException
     */
    public function parseJson(): Node
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
     * @return Node
     * @throws AvroException
     */
    protected function parseJsonString(): Node
    {
        return new JsonValueNode($this->consume(Token::STRING)->getLoad());
    }

    /**
     * @return Node
     * @throws AvroException
     */
    protected function parseJsonNumber(): Node
    {
        return new JsonValueNode((float)$this->consume(Token::NUMBER)->getLoad());
    }

    /**
     * @return Node
     * @throws AvroException
     */
    protected function parseJsonBool(): Node
    {
        $token = $this->consume(Token::IDENT, "true", "false");
        return new JsonValueNode($token->getLoad() === "true");
    }

    /**
     * @return Node
     * @throws AvroException
     */
    protected function parseJsonNull(): Node
    {
        $this->consume(Token::IDENT, "null");
        return new JsonValueNode(null);
    }

    /**
     * @return Node
     * @throws AvroException
     */
    protected function parseJsonArray(): Node
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
     * @return Node
     * @throws AvroException
     */
    protected function parseJsonObject(): Node
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
     * @return Node
     * @throws AvroException
     */
    protected function parseJsonField(): Node
    {
        $node = new JsonFieldNode($this->consume(Token::STRING)->getLoad());
        $this->consume(Token::COLON);
        return $node->addNode($this->parseJson());
    }
}
