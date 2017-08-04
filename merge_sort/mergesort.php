<?php 

class MergeSort
{
    public $arr = [67, 61, 73, 82, 92, 87, 40, 68, 10, 69, 59, 56, 93, 71, 90, 12, 70, 16, 91, 48, 79, 32, 96, 85, 42, 5 ,11, 45, 66, 36, 65, 58, 22, 31, 64, 34, 49, 75, 83, 63, 7 ,6 ,62, 18, 54, 10,  14, 35, 29, 77, 84, 4 ,60, 98, 43, 0 ,78, 28, 76, 89, 15, 94, 52, 46, 9 ,53, 80, 27, 19, 33, 1 ,55, 13, 99, 8 ,17, 3 ,86, 26, 41, 88, 57, 23, 24, 20, 25, 97, 95, 21, 38, 74, 47, 44, 2 ,39, 72, 50, 81, 37, 51, 30];

    public function makeRandomArray(Int $length = 100)
    {
        for ($i = 1; $i <= $length; $i++) {
            $this->arr[] = $i;
        }

        shuffle($this->arr);

        print_r($this->arr); exit;
    }

    public function divide(Array $arr = [])
    {        
        if (count($arr) <= 1) {
            return $arr;
        }

        $mid = count($arr) / 2;
        $left = array_slice($arr, 0, $mid);
        $right = array_slice($arr, $mid);

        // echo '>>>>>> LEFT' . PHP_EOL;
        // print_r($left); 
        // // echo '>>>>>> RIGHT' . PHP_EOL;
        // // print_r($right);

        $left = $this->divide($left);
        $right = $this->divide($right);
        
        return $this->merge($left, $right);
    }

    public function merge(Array $lF, Array $rF)
    {
        $result = [];

        while (count($lF) > 0 && count($rF) > 0) {
            if ($lF[0] <= $rF[0]) {
                array_push($result, array_shift($lF));
            } else {
                array_push($result, array_shift($rF));
            }
        }

        // did not see this in the pseudo code,  
        // but it became necessary as one of the arrays  
        // can become empty before the other  
        array_splice($result, count($result), 0, $lF);  
        array_splice($result, count($result), 0, $rF); 

        return $result;
    }
}

$mergeSort = new MergeSort;
print_r($mergeSort->divide($mergeSort->arr)); exit;