<?php

namespace FreezyBee\EditroubleBundle\Twig;

use Twig_Error_Syntax;
use Twig_Token;

/**
 * Class EditroubleTokenParser
 * @package FreezyBee\EditroubleBundle\Twig
 */
class EditroubleTokenParser extends \Twig_TokenParser
{

    /**
     * Parses a token and returns a node.
     *
     * @param Twig_Token $token A Twig_Token instance
     * @return EditroubleNode|void
     * @throws Twig_Error_Syntax
     */
    public function parse(Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        // namespace
        $attr['namespace'] = $stream->expect(Twig_Token::NAME_TYPE)->getValue();

        // dot
        $stream->expect(Twig_Token::PUNCTUATION_TYPE);

        $loop = 0;
        $lastWasName = false;

        // get name with {} variables
        while (!$stream->test(Twig_Token::BLOCK_END_TYPE) && $loop++ < 30) {
            // inspect name

            if ($stream->test(Twig_Token::NAME_TYPE) && !$lastWasName) {
                // simple string
                $attr['name'][] = $stream->expect(Twig_Token::NAME_TYPE)->getValue();
                $lastWasName = true;

            } elseif ($stream->test(Twig_Token::PUNCTUATION_TYPE) && $lastWasName) {
                // php variable
                $stream->expect(Twig_Token::PUNCTUATION_TYPE);
                $attr['name'][] = '$' . $stream->expect(Twig_Token::NAME_TYPE)->getValue();
                $stream->expect(Twig_Token::PUNCTUATION_TYPE);
                $lastWasName = false;

            } else {
                throw new \Twig_Error_Syntax('Invalid syntax');
            }
        }

        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

        return new EditroubleNode($attr, $lineno, $this->getTag());
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'editrouble';
    }
}
