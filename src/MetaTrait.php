<?php
namespace Cluedit\MaskMan;

use Closure;

trait MetaTrait
{
    /**
     * Methods.
     *
     * @var array
     */
    private $methods = array();

    /**
     * Add a callable method.
     *
     * @param string $methodName
     * @param callable $methodCallable
     * @return \Cluedit\MaskMan\MaskMan
     */
    public function by(string $methodName, callable $methodCallable): \Cluedit\MaskMan\MaskMan
    {
        if (!is_callable($methodCallable)) {
            // throw new InvalidArgumentException('Second param must be callable');
        }
        $this->methods[$methodName] = Closure::bind($methodCallable, $this, get_class());
        
        return $this;
    }

    public function __call(string $methodName, array $args)
    {
        if (isset($this->methods[$methodName])) {
            return call_user_func_array($this->methods[$methodName], $args);
        }

        // throw RunTimeException('There is no method with the given name to call');
    }
}