<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\Avron;

class AVDLParserBenchmark
{
    /** @var resource $stream */
    private $stream;

    public function setUp(): void
    {
        $filePath = "%s/../../../unit/internal/syntax/data/lex-dont-modify-schema.avdl";
        $this->stream = fopen(sprintf($filePath, __DIR__), "r");
    }

    public function tearDown(): void
    {
        fclose($this->stream);
    }

    /**
     * @BeforeMethods("setUp")
     * @AfterMethods("tearDown")
     * @OutputTimeUnit("seconds")
     * @OutputMode("throughput")
     * @Iterations(10)
     * @Revs(10)
     */
    public function benchCreateSchema(): void
    {
        $parser = Avron::createAvdlParser($this->stream);
        $parser->parse();
    }
}
