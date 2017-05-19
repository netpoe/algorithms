<?php 

class TreasureHunt
{
    public $treasure = 'monstruo potato face';

    public $cluesPerTreasureSegment = [];

    public $clueTokenArray = [];

    public $sortedClueTokenArray = [];

    public $file = './clues.json';

    public $players = 10;

    public $content;

    public function segmentTreasureString(Int $segment = 1)
    {
        $this->cluesPerTreasureSegment = str_split(str_replace(' ', '', $this->treasure), $segment);

        return $this;
    }

    public function setCluesPerTreasureSegment()
    {
        $this->clueTokenArray = array_map(function($token){
            return [
                'clue' => '',
                'token' => $token,
            ];
        }, $this->cluesPerTreasureSegment);

        return $this;
    }

    public function setFileName(String $file)
    {
        $this->file = $file;

        return $this;
    }

    public function createJsonFile()
    {
        $file = fopen($this->file, 'w');
        
        fclose($file);

        return $this;
    }

    public function saveCluesToJsonFile()
    {
        $data = json_encode(array_values($this->clueTokenArray), JSON_PRETTY_PRINT);

        file_put_contents($this->file, $data);

        return $this;
    }

    public function waitForFileFill()
    {
        readline('Fill in each clue per token, save, and press enter to continue');

        return $this;
    }

    public function setContent()
    {
        $data = file_get_contents($this->file);
        
        $content = json_decode($data, true);

        $this->content = $content;

        return $this;
    }

    public function addNumbersToClues()
    {
        $content = $this->content;

        shuffle($content);

        $length = count($content);
        
        return array_map(function($clue, $i) use ($length) {
            $text = $clue['clue'];
            $arr['clue'] = $i+1 . "/$length. $text";
            $arr['token'] = $clue['token'];
            return $arr;
        }, $content, array_keys($content));
    }

    public function sortCluesForNumberOfPlayers()
    {
        $sortedClueTokenArray = [];

        for ($i = 0; $i <= $this->players; $i++) {
            $sortedClueTokenArray[] = $this->addNumbersToClues();
        }

        $this->sortedClueTokenArray = $sortedClueTokenArray;

        return $this;
    }

    public function saveToCsv()
    {
        $fp = fopen($this->file, 'w');

        foreach ($this->sortedClueTokenArray as $i => $group) {
            $index = $i+1;
            fputcsv($fp, ["group_$index"]);
            foreach ($group as $clue) {
                fputcsv($fp, $clue);
            }
        }

        fclose($fp);
    }
}

$treasureHunt = new TreasureHunt;
$treasureHunt->segmentTreasureString()
            ->setCluesPerTreasureSegment()
            ->setFileName('./clues.json')
            ->createJsonFile()
            ->saveCluesToJsonFile()
            ->waitForFileFill()
            ->setContent()
            ->sortCluesForNumberOfPlayers()
            ->setFileName('./treasurehunt.csv')
            ->saveToCsv();