<?php
namespace Cluedit\MaskMan;

use Closure;

/**
 * Class MaskMan.
 *
 * @method MaskMan convert($array)
 * @method array to($case)
 */
class MaskMan
{
    use \Cluedit\MaskMan\MetaTrait;
    
    /**
     * Input data.
     *
     * @var array
     */
    protected $array;

    /**
     * Regex pattern.
     *
     * @var string
     */
    protected $stringPattern = "/([a-z])([A-Z])/";

    /**
     * Regex pattern.
     *
     * @var string
     */
    protected $withDashPattern = "@[^a-zA-Z0-9\-_ ]+@";

    /**
     * Regex pattern.
     *
     * @var string
     */
    protected $withEmptyPattern = "\\1 \\2";

    /**
     * Regex pattern.
     *
     * @var string
     */
    protected $underscorePattern = "\\1_\\2";

    /**
     * Check if an array contains only numeric keys.
     *
     * @param array $array
     * @return bool
     */
    final protected function isAssociative(array $array): bool
    {
        if (array() === $array) return false;
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * Create a new maskman instance.
     *
     * @return string
     */
    final protected function camelCase(string $str): string
    {
        $dashAndUnderscore = array("-", "_");
        $str = preg_replace($this->stringPattern, $this->withEmptyPattern, $str);
        $str = preg_replace($this->withDashPattern, "", $str);
        $str = str_replace($dashAndUnderscore, " ", $str);
        $str = str_replace(" ", "", ucwords(strtolower($str)));
        $str = strtolower(substr($str, 0, 1)).substr($str, 1);

        return $str;
    }

    /**
     * Create a new maskman instance.
     *
     * @return string
     */
    final protected function snake_case(string $str): string
    {
        $str = preg_replace($this->stringPattern, $this->underscorePattern, $str);
        $str = strtolower($str);

        return $str;
    }

    /**
     * Convert all key in array from snake case to camel case or from camel case to snake case.
     *
     * @param array $array
     * @return array
     */
    protected function convertAssociativeArray(array $array, Closure $callback): array
    {
        $newArray = array();
        foreach ($array as $key => $value) {

            if (is_array($value) && $this->isAssociative($value)) {
                $newArray[$callback($key)] = $this->convertAssociativeArray($value, $callback);
                continue;
            }

            if (is_array($value) && ! $this->isAssociative($value)) {
                $newList = array();
                foreach ($value as $element) {
                    if (is_array($element)) {
                        array_push($newList, $this->convertAssociativeArray($element, $callback));
                    } else {
                        array_push($newList, $element);
                    }
                }
                $newArray[$callback($key)] = $newList;
                continue;
            }

            $newArray[$callback($key)] = $value;

        }

        return $newArray;
    }

    /**
     * Create a new maskman instance.
     *
     * @return void
     */
    final public function __construct(array $array = [])
    {
        if (is_array($array)) {
            // throw new InvalidArgumentException('Param must be array');
        }
        $this->array = $array;
    }

    /**
     * Create a new maskman instance.
     *
     * @param array $array
     * @return \Cluedit\MaskMan\MaskMan
     */
    final public static function convert(array $array = []): \Cluedit\MaskMan\MaskMan
    {
        if (is_array($array)) {
            // throw new InvalidArgumentException('Param must be array');
        }
        
        return new static($array);
    }

    /**
     * Convert all key in array to camel case or snake case.
     *
     * @param string $case
     * @return array
     */
    final public function to(string $case): array
    {
        if ($this->isAssociative($this->array)) {
            return $this->convertAssociativeArray($this->array, Closure::fromCallable([$this, $case]));
        }
        $newArray = array();
        foreach ($this->array as $value) {
            array_push($newArray, $this->convertAssociativeArray($value, Closure::fromCallable([$this, $case])));
        }

        return $newArray;
    }
}