<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\AvronException;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ParserAvdl extends ParserJson
{
    /**
     * ProtocolDeclaration <EOF>
     *
     * @return Node
     * @throws AvronException
     */
    public function parseProtocol(): Node
    {
        $node = $this->parseProtocolDeclaration();
        $this->consume(Token::EOF);
        return $node;
    }

    /**
     * ( Property )* "protocol" Identifier ProtocolBody
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseProtocolDeclaration(): Node
    {
        $props = $this->parseProperties();

        $this->consumeWithHint(Token::IDENT, self::hintProtocolKeyword, "protocol");
        $name = $this->parseAnyIdentifierWithHint(self::hintProtocolIdentifier);

        $node = new ProtocolDeclarationNode($name);
        $node->setComments($this->fromCommentQueue());
        $node->setProperties($props);

        return $node->addNode(...$this->parseProtocolBody());
    }

    /**
     * "{" ( Imports | Declarations )*  "}"
     *
     * @return Node[]
     * @throws AvronException
     */
    protected function parseProtocolBody(): array
    {
        $nodes = [];
        $this->consumeWithHint(Token::LBRACE, self::hintProtocolBodyOpen);

        while (!$this->expect(Token::RBRACE)) {
            if ($this->expect(Token::IDENT, "import")) {
                $nodes[] = $this->parseImportStatement();
            } else {
                $nodes[] = $this->parseDeclaration();
            }
        }

        $this->consumeWithHint(Token::RBRACE, self::hintProtocolBodyClose);
        return $nodes;
    }

    /**
     * ( ImportIdl | ImportProtocol | ImportSchema )*
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseImportStatement(): Node
    {
        $types = ImportTypes::names();
        $this->consume(Token::IDENT, "import");
        $type = $this->consumeWithHint(Token::IDENT, self::hintImportTypeName, ...$types)->getLoad();
        $path = $this->consumeWithHint(Token::STRING, self::hintImportFilePath)->getLoad();
        $this->parseSemicolon();

        return new ImportStatementNode(ImportTypes::from($type), $path);
    }

    /**
     * ( Property )* ( NamedDeclaration | MessageDeclaration ) )*
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseDeclaration(): Node
    {
        $props = $this->parseProperties();

        if ($this->expect(Token::IDENT, ...NamedTypes::names())) {
            $node = $this->parseNamedDeclaration();
        } else {
            $node = $this->parseMessageDeclaration();
        }
        return $node->setProperties($props);
    }

    /**
     * ResultType Identifier FormalParameters ( "oneway" | "throws" ErrorList )? ";"
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseMessageDeclaration(): Node
    {
        $type = $this->parseResultType();
        $node = new MessageDeclarationNode($this->parseAnyIdentifier());
        $node->addNode($type);
        $node->addNode($this->parseFormalParameters());
        $node->setComments($this->fromCommentQueue());

        if ($this->expect(Token::IDENT, "throws")) {
            $node->addNode($this->parseErrorList());
        } elseif ($this->expect(Token::IDENT, "oneway")) {
            $node->addNode($this->parseOnewayStatement());
        }
        $this->parseSemicolon();
        return $node;
    }

    /**
     *    ( "(" ( FormalParameter ( "," FormalParameter )* )? ")" )
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseFormalParameters(): Node
    {
        $node = new FormalParametersNode();
        $this->consume(Token::LPAREN);

        if (!$this->expect(Token::RPAREN)) {
            $node->addNode($this->parseFormalParameter());
            while ($this->expect(Token::COMMA)) {
                $this->consume(Token::COMMA);
                $node->addNode($this->parseFormalParameter());
            }
        }
        $this->consume(Token::RPAREN);
        return $node;
    }

    /**
     * Type VariableDeclarator
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseFormalParameter(): Node
    {
        $node = new FormalParameterNode();
        $node->addNode($this->parseType());
        $node->addNode($this->parseVariableDeclarator());
        return $node;
    }

    /**
     * ReferenceType ( "," ReferenceType )*
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseErrorList(): Node
    {
        $token = $this->consume(Token::IDENT, ...ErrorTypes::names());
        $node = new ErrorListNode(ErrorTypes::from($token->getLoad()));
        $node->addNode((new TypeNode())->addNode($this->parseReferenceType()));

        while ($this->expect(Token::COMMA)) {
            $this->consume(Token::COMMA);
            $node->addNode((new TypeNode())->addNode($this->parseReferenceType()));
        }
        return $node;
    }

    /**
     * "oneway"
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseOnewayStatement(): Node
    {
        $this->consume(Token::IDENT, "oneway");
        return (new TypeNode())->addNode(new OnewayStatementNode());
    }

    /**
     * ( RecordDeclaration | ErrorDeclaration | EnumDeclaration | FixedDeclaration )
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseNamedDeclaration(): Node
    {
        if ($this->expect(Token::IDENT, "error")) {
            return $this->parseErrorDeclaration();
        }
        if ($this->expect(Token::IDENT, "enum")) {
            return $this->parseEnumDeclaration();
        }
        if ($this->expect(Token::IDENT, "fixed")) {
            return $this->parseFixedDeclaration();
        }
        return $this->parseRecordDeclaration();
    }

    /**
     * "fixed" Identifier "(" <INTEGER> ")" ";"
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseFixedDeclaration(): Node
    {
        $this->consume(Token::IDENT, "fixed");
        $name = $this->parseAnyIdentifier();
        $this->consume(Token::LPAREN);
        $value = $this->consume(Token::NUMBER)->getLoad();
        $node = new FixedDeclarationNode($name, (int)$value);
        $node->setComments($this->fromCommentQueue());
        $this->consume(Token::RPAREN);
        $this->parseSemicolon();
        return $node;
    }

    /**
     * "record" Identifier "{" (FieldDeclaration)* "}"
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseRecordDeclaration(): Node
    {
        $this->consume(Token::IDENT, "record");
        $node = new RecordDeclarationNode($this->parseAnyIdentifier());
        $node->setComments($this->fromCommentQueue());
        $this->consume(Token::LBRACE);

        while (!$this->expect(Token::RBRACE)) {
            $node->addNode($this->parseFieldDeclaration());
        }
        $this->consume(Token::RBRACE);
        return $node;
    }

    /**
     * "error" Identifier "{" (FieldDeclaration)* "}"
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseErrorDeclaration(): Node
    {
        $this->consume(Token::IDENT, "error");
        $node = new ErrorDeclarationNode($this->parseAnyIdentifier());
        $node->setComments($this->fromCommentQueue());
        $this->consume(Token::LBRACE);

        while (!$this->expect(Token::RBRACE)) {
            $node->addNode($this->parseFieldDeclaration());
        }
        $this->consume(Token::RBRACE);
        return $node;
    }

    /**
     * "enum" Identifier "{" EnumBody "}" ( <EQ> Identifier )
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseEnumDeclaration(): Node
    {
        $default = "";
        $this->consume(Token::IDENT, "enum");
        $ident = $this->parseAnyIdentifier();
        $this->consume(Token::LBRACE);
        $body = $this->parseEnumBody();
        $this->consume(Token::RBRACE);

        if ($this->expect(Token::EQ)) {
            $this->consume(Token::EQ);
            $default = $this->parseAnyIdentifier();
            $this->parseSemicolon();
        }

        $node = new EnumDeclarationNode($ident, $default);
        $node->setComments($this->fromCommentQueue());
        return $node->addNode(...$body);
    }

    /**
     * ( Identifier ( "," Identifier )* )?
     *
     * @return Node[]
     * @throws AvronException
     */
    protected function parseEnumBody(): array
    {
        $nodes = [];
        if ($this->expect(Token::IDENT) || $this->expect(Token::TICK)) {
            $nodes[] = new EnumConstantNode($this->parseAnyIdentifier());

            while ($this->expect(Token::COMMA)) {
                $this->consume(Token::COMMA);
                $nodes[] = new EnumConstantNode($this->parseAnyIdentifier());
            }
        }
        return $nodes;
    }

    /**
     * ( ( Property )* Type VariableDeclarator ( "," VariableDeclarator )* ";" )*
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseFieldDeclaration(): Node
    {
        $props = $this->parseProperties();

        $node = new FieldDeclarationNode();
        $node->addNode($this->parseType());
        $node->addNode($this->parseVariableDeclarator());
        $node->setComments($this->fromCommentQueue());
        $node->setProperties($props);

        while ($this->expect(Token::COMMA)) {
            $this->consume(Token::COMMA);
            $node->addNode($this->parseVariableDeclarator());
        }
        $this->parseSemicolon();
        return $node;
    }

    /**
     * ( Property )* Identifier ( <EQ> JSONValue )?
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseVariableDeclarator(): Node
    {
        $props = $this->parseProperties();
        $node = new VariableDeclaratorNode($this->parseAnyIdentifier());

        if ($this->expect(Token::EQ)) {
            $this->consume(Token::EQ);
            $node->addNode(parent::parseJson());
        }
        return $node->setProperties($props);
    }

    /**
     * "void" | Type
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseResultType(): Node
    {
        if ($this->expect(Token::IDENT, "void")) {
            $this->consume(Token::IDENT);
            return new ResultTypeNode(true);
        }
        return (new ResultTypeNode(false))->addNode($this->parseType());
    }

    /**
     * ( Property )* ( ReferenceType | PrimitiveType | UnionType | ArrayType | MapType | DecimalType ) "?"?
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseType(): Node
    {
        $props = $this->parseProperties();

        $node = $this->parsePrimitiveType();
        $node = $node ?? $this->parseUnionType();
        $node = $node ?? $this->parseArrayType();
        $node = $node ?? $this->parseMapType();
        $node = $node ?? $this->parseDecimalType();
        $node = $node ?? $this->parseReferenceType();

        if ($this->expect(Token::QMARK)) {
            $this->consume(Token::QMARK);
            $type = new NullableTypeNode();
        } else {
            $type = new TypeNode();
        }
        return $type->setProperties($props)->addNode($node);
    }

    /**
     * "boolean" | "bytes" | "int" | "string" | "float" | ...
     *
     * @return ?Node
     * @throws AvronException
     */
    protected function parsePrimitiveType(): ?Node
    {
        if ($this->expect(Token::IDENT, ...LogicalTypes::names())) {
            return new LogicalTypeNode(LogicalTypes::from($this->parseIdentifier()));
        }
        if ($this->expect(Token::IDENT, ...PrimitiveTypes::names())) {
            return new PrimitiveTypeNode(PrimitiveTypes::from($this->parseIdentifier()));
        }
        return null;
    }

    /**
     * "decimal" "(" <INTEGER>, <INTEGER> ")"
     *
     * @return ?Node
     * @throws AvronException
     */
    protected function parseDecimalType(): ?Node
    {
        if (!$this->expect(Token::IDENT, "decimal")) {
            return null;
        }
        $this->consume(Token::IDENT);
        $this->consume(Token::LPAREN);
        $precToken = $this->peek();
        $precision = (int)$this->consume(Token::NUMBER)->getLoad();
        $this->consume(Token::COMMA);
        $scaleToken = $this->peek();
        $scale = (int)$this->consume(Token::NUMBER)->getLoad();
        $this->consume(Token::RPAREN);

        if ($precision < 0) {
            $this->throwException($precToken, "unexpected negative decimal type precision");
        }
        if ($scale < 0 || $scale > $precision) {
            $this->throwException($scaleToken, "unexpected invalid decimal type scale");
        }
        return new DecimalTypeNode($precision, $scale);
    }

    /**
     * "array" "<" Type ">"
     *
     * @return ?Node
     * @throws AvronException
     */
    protected function parseArrayType(): ?Node
    {
        if (!$this->expect(Token::IDENT, "array")) {
            return null;
        }
        $this->consume(Token::IDENT);
        $this->consume(Token::LT);
        $node = (new ArrayTypeNode())->addNode($this->parseType());
        $this->consume(Token::GT);
        return $node;
    }

    /**
     * "map" "<" Type ">"
     *
     * @return ?Node
     * @throws AvronException
     */
    protected function parseMapType(): ?Node
    {
        if (!$this->expect(Token::IDENT, "map")) {
            return null;
        }
        $this->consume(Token::IDENT);
        $this->consume(Token::LT);
        $node = (new MapTypeNode())->addNode($this->parseType());
        $this->consume(Token::GT);
        return $node;
    }

    /**
     * "union" "{" Type ( "," Type )* "}"
     *
     * @return ?Node
     * @throws AvronException
     */
    protected function parseUnionType(): ?Node
    {
        if (!$this->expect(Token::IDENT, "union")) {
            return null;
        }
        $this->consume(Token::IDENT);
        $this->consume(Token::LBRACE);
        $node = (new UnionTypeNode())->addNode($this->parseType());

        while ($this->expect(Token::COMMA)) {
            $this->consume(Token::COMMA);
            $node->addNode($this->parseType());
        }
        $this->consume(Token::RBRACE);
        return $node;
    }

    /**
     * ( Identifier ( "." Identifier )* )
     *
     * @return Node
     * @throws AvronException
     */
    protected function parseReferenceType(): Node
    {
        $ident = $this->parseAnyIdentifierWithHint(self::hintReferenceIdentifier);
        while ($this->expect(Token::DOT)) {
            $this->consume(Token::DOT);
            $ident .= "." . $this->parseAnyIdentifierWithHint(self::hintReferenceIdentifier);
        }
        return new ReferenceTypeNode($ident);
    }

    /**
     * "@" PropertyName "(" JSONValue ")"
     *
     * @return Property
     * @throws AvronException
     */
    protected function parseProperty(): Property
    {
        $this->consume(Token::AT);
        $name = $this->parsePropertyName();
        $this->consume(Token::LPAREN);

        /** @var mixed $json */
        $json = json_decode(json_encode(parent::parseJson()));

        $this->consume(Token::RPAREN);
        return new Property($name, $json);
    }

    /**
     * ( "@" PropertyName "(" JSONValue ")" )*
     *
     * @return Properties
     * @throws AvronException
     */
    protected function parseProperties(): Properties
    {
        $props = new Properties();
        while ($this->expect(Token::AT)) {
            $props->add($this->parseProperty());
        }
        return $props;
    }

    /**
     * <IDENTIFIER> (<DASH> <IDENTIFIER>)*
     *
     * @return string
     * @throws AvronException
     */
    protected function parsePropertyName(): string
    {
        $ident = $this->parseAnyIdentifier();
        while ($this->expect(Token::DASH)) {
            $this->consume(Token::DASH);
            $ident = $ident . "-" . $this->parseAnyIdentifier();
        }
        return $ident;
    }

    /**
     * @param string $hint Informative part for a possible error message.
     * @return string
     * @throws AvronException
     */
    protected function parseIdentifierWithHint(string $hint): string
    {
        return $this->consumeWithHint(Token::IDENT, $hint)->getLoad();
    }

    /**
     * @return string
     * @throws AvronException
     */
    protected function parseIdentifier(): string
    {
        return $this->parseIdentifierWithHint("<identifier>");
    }

    /**
     * @param string $hint Informative part for a possible error message.
     * @return string
     * @throws AvronException
     */
    protected function parseAnyIdentifierWithHint(string $hint): string
    {
        if ($this->expect(Token::TICK)) {
            $this->consume(Token::TICK);
            $ident = $this->parseIdentifierWithHint($hint);
            $this->consume(Token::TICK);
            return $ident;
        }
        return $this->parseIdentifierWithHint($hint);
    }

    /**
     * @return string
     * @throws AvronException
     */
    protected function parseAnyIdentifier(): string
    {
        if ($this->expect(Token::TICK)) {
            $this->consume(Token::TICK);
            $ident = $this->parseIdentifier();
            $this->consume(Token::TICK);
            return $ident;
        }
        return $this->parseIdentifier();
    }

    protected function parseSemicolon(): void
    {
        $this->consumeWithHint(Token::SEMICOL, self::hintTrailingSemicolon);
    }

    /** @return Comments */
    private function fromCommentQueue(): Comments
    {
        return new Comments($this->getCursor()->getCommentQueue()->drain());
    }

    // @formatter:off
    // phpcs:disable
    private const
        // Message "expected ..."
        hintProtocolKeyword     = "@namespace() property and 'protocol' keyword",
        hintProtocolIdentifier  = "protocol name <identifier>",
        hintProtocolBodyOpen    = "protocol body opening brace '{'",
        hintProtocolBodyClose   = "protocol body closing brace '}'",
        hintImportFilePath      = "import file path in double quotes",
        hintTrailingSemicolon   = "trailing semicolon ';'",
        hintReferenceIdentifier = "reference type name <identifier>",

        // FIXME: implement protocol and schema imports.
        #hintImportTypeName     = "import type to be one of 'idl', 'protocol' or 'schema'",
        hintImportTypeName      = "import type to be 'idl' ('protocol' or 'schema' unsupported)"
    ;
    // phpcs:enable
    // @formatter:on
}
