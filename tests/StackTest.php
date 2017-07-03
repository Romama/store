<?php
/**
 * Created by WeiCuicui.
 * Date: 2017/5/22
 * Time: 15:16
 */
class StackTest extends PHPUnit\Framework\TestCase
{
    public function testPushAndPop()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack) - 1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));

        echo "\n";
        var_dump($stack);
    }
}