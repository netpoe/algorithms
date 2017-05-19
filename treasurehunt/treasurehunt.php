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

    public $length = 0;

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

    public function setLength()
    {
        $this->length = count($this->clueTokenArray);

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

    public function numberClues()
    {
        $content = $this->content;

        $length = $this->length;

        $this->content = array_map(function($item, $index) use ($length) {
            $location = $item['clue'];
            $clue = $index+1 . "/$length. $location";
            $token = $item['token'];
            return [
                'clue' => $clue,
                'token' => $token,
            ];
        }, $content, array_keys($content));

        return $this;
    }

    public function sortCluesForNumberOfPlayers()
    {
        $length = $this->length;

        $startFrom = 0;

        for ($i = 0; $i < $this->players; $i++) {
            $player = $i+1;
            $index = 0;
            for ($j = $startFrom; $index < $length; $j++) {
                if ($j == $length) {
                    $j = 0;
                }
                $token = $this->content[$j]['token'];
                $clue = $this->content[$j]['clue'];
                $sortedClueTokenArray[$index][] = [
                    'clue' => $clue,
                    'token' => $token,
                    'group' => "Player: {$player}",
                ];
                $index++;
            }
            $startFrom = $length - $player;
        }

        $this->sortedClueTokenArray = $sortedClueTokenArray;

        return $this;
    }

    public function saveToCsv()
    {
        $fp = fopen($this->file, 'w');

        fputcsv($fp, ["Clues: $this->length"]);
        foreach ($this->content as $clue) {
            fputcsv($fp, $clue);
        }

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
            ->setLength()
            ->setFileName('./clues.json')
            ->createJsonFile()
            ->saveCluesToJsonFile()
            ->waitForFileFill()
            ->setContent()
            ->numberClues()
            ->sortCluesForNumberOfPlayers()
            ->setFileName('./treasurehunt.csv')
            ->saveToCsv();