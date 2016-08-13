<?php

namespace FreezyBee\EditroubleBundle\Twig;

use Twig_Node;
use Twig_Compiler;

/**
 * Class EditroubleNode
 * @package FreezyBee\EditroubleBundle\Twig
 */
class EditroubleNode extends Twig_Node
{
    /**
     * EditroubleNode constructor.
     * @param array $attr
     * @param int $lineno
     * @param string $tag
     */
    public function __construct($attr, $lineno, $tag = 'editrouble')
    {
        parent::__construct([], $attr, $lineno, $tag);
    }

    /**
     * @inheritdoc
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $name = '';
        foreach ($this->getAttribute('name') as $part) {
            if (strpos($part, '$') === 0) {
                $name .= ' $context[\'' . substr($part, 1) . '\'] . ';
            } else {
                $name .= '\'' . $part . '\' . ';
            }
        }

        $name = rtrim($name, ' .');

        $output = 'echo $this->env->getExtension(\'editrouble\')';
        $output .= '->getContext(\'' . $this->getAttribute('namespace') . '\',';
        $output .= $name . ', $context[\'app\']->getUser());' . "\n";

        $compiler
            ->write("// editrouble\n")
            ->write($output);
    }
}
