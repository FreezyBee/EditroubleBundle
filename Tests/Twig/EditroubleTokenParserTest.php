<?php

namespace FreezyBee\EditroubleBundle\Tests\Twig;

use FreezyBee\EditroubleBundle\Twig\EditroubleNode;
use FreezyBee\EditroubleBundle\Twig\EditroubleTokenParser;

/**
 * Class EditroubleTokenParserTest
 * @package FreezyBee\EditroubleBundle\Tests\Twig
 */
class EditroubleTokenParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testParseValid()
    {
        $data = [
            [
                '{% editrouble namespaceX.name %}',
                ['name']
            ],
            [
                '{% editrouble namespaceX.name{x}name %}',
                ['name', '$x', 'name']
            ],
            [
                '{% editrouble namespaceX.name{x}_{y} %}',
                ['name', '$x', '_', '$y']
            ],
            [
                '{% editrouble namespaceX.name{x}_{y}_hello_{x} %}',
                ['name', '$x', '_', '$y', '_hello_' , '$x']
            ]
        ];

        foreach ($data as $item) {
            $node = $this->tryParseCode($item[0]);
            $this->assertEquals($item[1], $node->getAttribute('name'));
        }
    }

    public function testExceptionDots()
    {
        $this->expectException(\Twig_Error_Syntax::class);
        $this->tryParseCode('{% editrouble namespaceX.name.name %}');
    }

    public function testExceptionNearVariables()
    {
        $this->expectException(\Twig_Error_Syntax::class);
        $this->tryParseCode('{% editrouble namespaceX.name{x}{y} %}');
    }

    public function testExceptionSpace()
    {
        $this->expectException(\Twig_Error_Syntax::class);
        $this->tryParseCode('{% editrouble namespaceX.name{x }{y} %}');
    }

    public function testExceptionFirstVariable()
    {
        $this->expectException(\Twig_Error_Syntax::class);
        $this->tryParseCode('{% editrouble namespaceX.{x} %}');
    }

    /**
     * @param string $code
     * @return EditroubleNode
     */
    private function tryParseCode($code)
    {
        $twig = new \Twig_Environment;

        $twigParser = new class($twig) extends \Twig_Parser
        {
            public function setStream(\Twig_TokenStream $stream)
            {
                // move next '{%' and 'editrouble'
                $stream->nextIf(\Twig_Token::BLOCK_START_TYPE);
                $stream->nextIf(\Twig_Token::NAME_TYPE);
                $this->stream = $stream;
            }
        };

        $lexer = new \Twig_Lexer($twig);
        $twigParser->setStream($lexer->tokenize($code));

        $tokenParser = new EditroubleTokenParser();
        $tokenParser->setParser($twigParser);

        return $tokenParser->parse(new \Twig_Token(0, 0, 0));
    }
}
