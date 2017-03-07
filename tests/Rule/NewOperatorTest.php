<?php

namespace anasinnyk\tests\Rule;

use PHPMD\PHPMD;
use PHPMD\Renderer\TextRenderer;
use PHPMD\RuleSetFactory;
use PHPMD\Writer\StreamWriter;
use PHPUnit\Framework\TestCase;

class NewOperatorTest extends TestCase
{
    protected $report;

    public function setUp()
    {
        $writer = new StreamWriter(fopen(__DIR__ . '/tmp.file', 'wb'));
        $textRender = new TextRenderer();
        $textRender->setWriter($writer);

        $phpmd = new PHPMD();

        $phpmd->processFiles(
            __DIR__ . '/example.php',
            realpath(__DIR__ . '/../../resources/new.xml'),
            [$textRender],
            new RuleSetFactory()
        );
    }

    public function testValidate()
    {
        $errors = file_get_contents(__DIR__ . '/tmp.file');
        $this->assertContains('Category', $errors);
        $this->assertNotContains('DateTime', $errors);
        $this->assertNotContains('Exception', $errors);
        $this->assertNotContains('anonymous', $errors);
    }
}
