<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\core;

use lengo\avron\api\SourceLoader;
use lengo\avron\api\SourceParser;
use lengo\avron\api\SourceMap;
use lengo\avron\AvroException;

class ProtocolLoader implements SourceLoader
{
    public function __construct(private readonly SourceParser $parser)
    {
    }

    /**
     * @param string ...$filenames
     * @return SourceMap
     * @throws AvroException
     */
    public function load(string ...$filenames): SourceMap
    {
        $sourceMap = new ProtocolMap();

        foreach ($filenames as $sourceFile) {
            $this->parser->parse($sourceMap, RealPath::fromString($sourceFile));
        }

//        foreach ($sourceMap as $path => $protocol) {
//            echo $path,"\n";
//        }
        //$protocol->accept($builder);
        //return $builder->getHierarchyMap();

        return $sourceMap;
    }
}
