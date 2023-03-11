<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use Avron\AvronException;
use Avron\Core\VisitableNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ParserAvdl extends ParserJson
{
    /**
     * ProtocolDeclaration <EOF>
     *
     * @return AstNode
     * @throws AvronException
     */
    public function parseProtocol(): AstNode
    {
        $node = $this->parseProtocolDeclaration();
        $this->consume(Token::EOF);

        /** @var AstNode */
        return $node;
    }

    /**
     * ( Property )* "protocol" Identifier ProtocolBody
     *
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseProtocolDeclaration(): VisitableNode
    {
        $properties = $this->parseProperties();

        $this->consumeWithHint(Token::IDENT, self::hintProtocolKeyword, "protocol");
        $name = $this->parseAnyIdentifierWithHint(self::hintProtocolIdentifier);

        $node = new ProtocolDeclarationNode($name, $properties);
        $node->setComments($this->fromCommentQueue());

        return $node->addNode(...$this->parseProtocolBody());
    }

    /**
     * "{" ( Imports | Declarations )*  "}"
     *
     * @return VisitableNode[]
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
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseImportStatement(): VisitableNode
    {
        $types = ImportType::names();
        $this->consume(Token::IDENT, "import");
        $type = $this->consumeWithHint(Token::IDENT, self::hintImportTypeName, ...$types)->getLoad();
        $path = $this->consumeWithHint(Token::STRING, self::hintImportFilePath)->getLoad();
        $this->parseSemicolon();

        return new ImportStatementNode(ImportType::from($type), $path);
    }

    /**
     * ( Property )* ( NamedDeclaration | MessageDeclaration ) )*
     *
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseDeclaration(): VisitableNode
    {
        $properties = $this->parseProperties();

        return $this->expect(Token::IDENT, ...NamedType::names())
            ? $this->parseNamedDeclaration($properties)
            : $this->parseMessageDeclaration($properties);
    }

    /**
     * ResultType Identifier FormalParameters ( "oneway" | "throws" ErrorList )? ";"
     *
     * @param Properties $properties
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseMessageDeclaration(Properties $properties): VisitableNode
    {
        $type = $this->parseResultType();
        $node = new MessageDeclarationNode($this->parseAnyIdentifier(), $properties);
        $node->addNode($type, $this->parseFormalParameters());
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
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseFormalParameters(): VisitableNode
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
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseFormalParameter(): VisitableNode
    {
        $node = new FormalParameterNode();
        $node->addNode($this->parseType());
        $node->addNode($this->parseVariableDeclarator());
        return $node;
    }

    /**
     * ReferenceType ( "," ReferenceType )*
     *
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseErrorList(): VisitableNode
    {
        $token = $this->consume(Token::IDENT, ...ErrorType::names());
        $node = new ErrorListNode(ErrorType::from($token->getLoad()));
        $node->addNode((new TypeNode())->addNode($this->parseReferenceType(Properties::fromArray([]))));

        while ($this->expect(Token::COMMA)) {
            $this->consume(Token::COMMA);
            $node->addNode((new TypeNode())->addNode($this->parseReferenceType(Properties::fromArray([]))));
        }
        return $node;
    }

    /**
     * "oneway"
     *
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseOnewayStatement(): VisitableNode
    {
        $this->consume(Token::IDENT, "oneway");
        return (new TypeNode())->addNode(new OnewayStatementNode());
    }

    /**
     * ( RecordDeclaration | ErrorDeclaration | EnumDeclaration | FixedDeclaration )
     *
     * @param Properties $properties
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseNamedDeclaration(Properties $properties): VisitableNode
    {
        if ($this->expect(Token::IDENT, "error")) {
            return $this->parseErrorDeclaration($properties);
        }
        if ($this->expect(Token::IDENT, "enum")) {
            return $this->parseEnumDeclaration($properties);
        }
        if ($this->expect(Token::IDENT, "fixed")) {
            return $this->parseFixedDeclaration($properties);
        }
        return $this->parseRecordDeclaration($properties);
    }

    /**
     * "fixed" Identifier "(" <INTEGER> ")" ";"
     *
     * @param Properties $properties
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseFixedDeclaration(Properties $properties): VisitableNode
    {
        $this->consume(Token::IDENT, "fixed");
        $name = $this->parseAnyIdentifier();
        $this->consume(Token::LPAREN);
        $value = $this->consume(Token::NUMBER)->getLoad();
        $node = new FixedDeclarationNode($name, (int)$value, $properties);
        $node->setComments($this->fromCommentQueue());
        $this->consume(Token::RPAREN);
        $this->parseSemicolon();
        return $node;
    }

    /**
     * "record" Identifier "{" (FieldDeclaration)* "}"
     *
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseRecordDeclaration(Properties $properties): VisitableNode
    {
        $this->consume(Token::IDENT, "record");
        $node = new RecordDeclarationNode($this->parseAnyIdentifier(), $properties);
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
     * @param Properties $properties
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseErrorDeclaration(Properties $properties): VisitableNode
    {
        $this->consume(Token::IDENT, "error");
        $node = new ErrorDeclarationNode($this->parseAnyIdentifier(), $properties);
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
     * @param Properties $properties
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseEnumDeclaration(Properties $properties): VisitableNode
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

        $node = new EnumDeclarationNode($ident, $default, $properties);
        $node->setComments($this->fromCommentQueue());
        return $node->addNode(...$body);
    }

    /**
     * ( Identifier ( "," Identifier )* )?
     *
     * @return VisitableNode[]
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
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseFieldDeclaration(): VisitableNode
    {
        $props = $this->parseProperties();

        $node = new FieldDeclarationNode($props);
        $node->addNode($this->parseType());
        $node->addNode($this->parseVariableDeclarator());
        $node->setComments($this->fromCommentQueue());

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
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseVariableDeclarator(): VisitableNode
    {
        $props = $this->parseProperties();
        $node = new VariableDeclaratorNode($this->parseAnyIdentifier(), $props);

        if ($this->expect(Token::EQ)) {
            $this->consume(Token::EQ);
            $node->addNode(parent::parseJson());
        }
        return $node;
    }

    /**
     * "void" | Type
     *
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseResultType(): VisitableNode
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
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseType(): VisitableNode
    {
        $properties = $this->parseProperties();

        $node = $this->parsePrimitiveType($properties);
        $node = $node ?? $this->parseUnionType($properties);
        $node = $node ?? $this->parseArrayType($properties);
        $node = $node ?? $this->parseMapType($properties);
        $node = $node ?? $this->parseDecimalType($properties);
        $node = $node ?? $this->parseReferenceType($properties);

        // FIXME: check properties
        if ($this->expect(Token::QMARK)) {
            $this->consume(Token::QMARK);
            $type = new NullableTypeNode();
        } else {
            $type = new TypeNode();
        }
        return $type->addNode($node);
    }

    /**
     * "boolean" | "bytes" | "int" | "string" | "float" | ...
     *
     * @param Properties $properties
     * @return VisitableNode|null
     * @throws AvronException
     */
    protected function parsePrimitiveType(Properties $properties): VisitableNode|null
    {
        if ($this->expect(Token::IDENT, ...LogicalType::names())) {
            return new LogicalTypeNode(LogicalType::from($this->parseIdentifier()), $properties);
        }
        if ($this->expect(Token::IDENT, ...PrimitiveType::names())) {
            return new PrimitiveTypeNode(PrimitiveType::from($this->parseIdentifier()), $properties);
        }
        return null;
    }

    /**
     * "decimal" "(" <INTEGER>, <INTEGER> ")"
     *
     * @param Properties $properties
     * @return VisitableNode|null
     * @throws AvronException
     */
    protected function parseDecimalType(Properties $properties): VisitableNode|null
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
        return new DecimalTypeNode($precision, $scale, $properties);
    }

    /**
     * "array" "<" Type ">"
     *
     * @param Properties $properties
     * @return VisitableNode|null
     * @throws AvronException
     */
    protected function parseArrayType(Properties $properties): VisitableNode|null
    {
        if (!$this->expect(Token::IDENT, "array")) {
            return null;
        }
        $this->consume(Token::IDENT);
        $this->consume(Token::LT);
        $node = (new ArrayTypeNode($properties))->addNode($this->parseType());
        $this->consume(Token::GT);
        return $node;
    }

    /**
     * "map" "<" Type ">"
     *
     * @param Properties $properties
     * @return VisitableNode|null
     * @throws AvronException
     */
    protected function parseMapType(Properties $properties): VisitableNode|null
    {
        if (!$this->expect(Token::IDENT, "map")) {
            return null;
        }
        $this->consume(Token::IDENT);
        $this->consume(Token::LT);
        $node = (new MapTypeNode($properties))->addNode($this->parseType());
        $this->consume(Token::GT);
        return $node;
    }

    /**
     * "union" "{" Type ( "," Type )* "}"
     *
     * @param Properties $properties
     * @return VisitableNode|null
     * @throws AvronException
     */
    protected function parseUnionType(Properties $properties): VisitableNode|null
    {
        if (!$this->expect(Token::IDENT, "union")) {
            return null;
        }
        $this->consume(Token::IDENT);
        $this->consume(Token::LBRACE);
        $node = (new UnionTypeNode($properties))->addNode($this->parseType());

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
     * @param Properties $properties
     * @return VisitableNode
     * @throws AvronException
     */
    protected function parseReferenceType(Properties $properties): VisitableNode
    {
        $ident = $this->parseAnyIdentifierWithHint(self::hintReferenceIdentifier);
        while ($this->expect(Token::DOT)) {
            $this->consume(Token::DOT);
            $ident .= "." . $this->parseAnyIdentifierWithHint(self::hintReferenceIdentifier);
        }
        return new ReferenceTypeNode($ident, $properties);
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
        $props = [];
        while ($this->expect(Token::AT)) {
            $props[] = $this->parseProperty();
        }
        return Properties::fromArray($props);
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
        return Comments::fromArray($this->getCursor()->getCommentQueue()->drain());
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
