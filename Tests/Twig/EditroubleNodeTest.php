<?php

namespace FreezyBee\EditroubleBundle\Tests\Twig;

use FreezyBee\EditroubleBundle\Twig\EditroubleNode;

/**
 * Class EditroubleNodeTest
 * @package FreezyBee\EditroubleBundle\Tests\Twig
 */
class EditroubleNodeTest extends \Twig_Test_NodeTestCase
{
    /**
     * @return array
     */
    public function getTests()
    {
        $tests = [];

        $tests[] = [
            new EditroubleNode(['namespace' => 'namespaceX', 'name' => ['nameX']], 1),
            $this->getSource('simple')
        ];

        $tests[] = [
            new EditroubleNode(['namespace' => 'namespaceX', 'name' => ['nameX', '$varX']], 1),
            $this->getSource('one_variable')
        ];

        $tests[] = [
            new EditroubleNode(['namespace' => 'namespaceX', 'name' => ['nameX', '$varX', '$varY']], 1),
            $this->getSource('two_variables')
        ];

        return $tests;
    }

    /**
     * @param $name
     * @return string
     */
    private function getSource($name)
    {
        return file_get_contents(__DIR__ . '/nodes/' . $name . '.test');
    }
}
