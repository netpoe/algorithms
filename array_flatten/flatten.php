<?php 

namespace Utils\Arrays;

/**
 * Array Cleaner
 * Utility methods for array or objects normalization
 */
class Cleaner
{
    protected $result = [];

    /**
     * flatten  Return a single dimension array of integers 
     * from an array of arbitrarily nested arrays of integers
     * @param  Array|array $arr     An arbitrarily nested array of integers
     * @return Self
     */
    public function flatten(Array $arr = [])
    {
        array_reduce($arr, function($accesor, $item){
            if (is_array($item)) {
                return $this->flatten($item);
            } 
            
            $this->result[] = $item;
        }, []);

        return $this;
    }

    /**
     * get  Returns the resulting array of the cleaning methods
     * @return Array $result
     */
    public function get()
    {
        return $this->result;
    }

    /**
     * reset  Resets the results array
     * @return self
     */
    public function reset()
    {
        $this->result = [];

        return $this;
    }
}

$cleaner = new Cleaner;
$cleaner->flatten([[1, 2, [3]], 4]);
print_r($cleaner->get());
$cleaner->reset();
$cleaner->flatten([[1, 2, [3]], 4, [1,2,3,4, [5,6,7,8, [9,10]]], 11, 12]);
print_r($cleaner->get());




