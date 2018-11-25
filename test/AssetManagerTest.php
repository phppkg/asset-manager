<?php

namespace PhpComp\Asset\Test;

use PhpComp\Asset\AssetBag;
use PhpComp\Asset\AssetBagInterface;
use PhpComp\Asset\AssetManager;
use PHPUnit\Framework\TestCase;

/**
 * @covers AssetManager
 */
class AssetManagerTest extends TestCase
{
    /**
     * @var AssetManager
     */
    protected $am;

    protected function createManager($new = false)
    {
        if ($new || !$this->am) {
            $this->am = new AssetManager();
        }

        return $this->am;
    }

    public function testCss()
    {
        $am = $this->createManager();

        $am->addCss('assets/app.css');
        $am->addCss('https://cdn.bootcss.com/pure/1.0.0/grids-core-min.css');

        $this->assertTrue($am->has(AssetBag::CSS_BAG));
        $this->assertEquals(null, $am->get('no-exists'));

        if ($bag = $am->get(AssetBag::CSS_BAG)) {
            $this->assertInstanceOf(AssetBagInterface::class, $bag);
            $this->assertEquals(2, $bag->count());
            $this->assertEquals('css', $bag->getName());
        }

        $this->expectException(\RuntimeException::class);
        $am->get('no-exist', true);

        $am->addJs('assets/app.js');
        $this->assertTrue($am->has(AssetBag::JS_BAG));
        if ($bag = $am->get(AssetBag::CSS_BAG)) {
            $this->assertEquals(1, $bag->count());
            $this->assertEquals('js', $bag->getName());
        }
    }
}
