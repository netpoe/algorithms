<?php 

class Container implements Sortable
{
    public $weight;
    public $content;

    public function __construct(String $content, Int $weight)
    {
        $this->weight = $weight;
        $this->content = $content;
    }

    public function toString()
    {
        return "Container holds $this->content and weights $this->weight";
    }

    public function compareTo(Container $otherContainer)
    {
        if ($this->weight < $otherContainer->weight) {
            return -1;
        } else if ($this->weight == $otherContainer->weight) {
            return 0;
        } else {
            return 1;
        }
    }
}

interface Sortable
{
    public function toString();
}

class Sort
{
    public $unit;

    public function __construct($unit)
    {
        $this->unit = $unit;
    }

    public function mergeSort(Array $arr)
    {
        if (count($arr) <= 1) return $arr;

        $mid = floor(count($arr) / 2);

        $left = array_slice($arr, 0, $mid);
        $right = array_slice($arr, $mid);

        $left = $this->mergeSort($left);
        $right = $this->mergeSort($right);

        $result = $this->merge($left, $right);

        return $result;
    }

    public function merge(Array $left, Array $right)
    {
        $result = [];
        $unit = $this->unit;

        while (count($left) > 0 && count($right) > 0) {
            if ($left[0]->$unit <= $right[0]->$unit) {
                $result[] = array_shift($left);
            } else {
                $result[] = array_shift($right);
            }
        }

        array_splice($result, count($result), 0, $left);
        array_splice($result, count($result), 0, $right);
     
        return $result; 
    }
}

abstract class TestDrive
{
    public function display(Array $items)
    {
        if (empty($items)) return;

        echo array_shift($items)->toString() . PHP_EOL;
        
        $this->display($items);
    }
}

class ContainerTestDrive extends TestDrive
{
    public function __construct()
    {
        $containers = [
            new Container('Apples', 40),
            new Container('Bananas', 57),
            new Container('Coconuts', 32),
            new Container('Brocolli', 12),
            new Container('Eggplants', 89),
            new Container('Coffee', 89),
            new Container('Cereal', 23),
        ];

        echo '>>>>> BEFORE SORT' . PHP_EOL;
        $this->display($containers);

        $sortable = new Sort('weight');
        $sortedContainers = $sortable->mergeSort($containers);

        echo '>>>>> AFTER SORT' . PHP_EOL;
        $this->display($sortedContainers);
    }
}

$test = new ContainerTestDrive;










