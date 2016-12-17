<?php
class Survey {
    static $crx = 0;
    static $disco = 0;
    static $duo = 0;
    static $read = 0;
    static $speak = 0;
    static $grsp = 0;
    static $humor = 0;
    static $info = 0;
    static $oo = 0;
    static $drama = 0;
    static $poetry = 0;
    static $prose = 0;
    static $story = 0;
    
    public function addPA($addVal) {
        self::addDisco($addVal);
        self::addSpeak($addVal);
        self::addGrsp($addVal);
        self::addInfo($addVal);
        self::addOo($addVal);
    }
    public function addInterp($addVal) {
        self::addCrx($addVal);
        self::addDrama($addVal);
        self::addDuo($addVal);
        self::addHumor($addVal);
        self::addPoetry($addVal);
        self::addProse($addVal);
        self::addRead($addVal);
        self::addStory($addVal);
    }
    public function addCrx($addVal) {
        self::$crx += $addVal;
    }
    public function addDisco($addVal) {
        self::$disco += $addVal;
    }
    public function addDuo($addVal) {
        self::$duo += $addVal;
    }
    public function addRead($addVal) {
        self::$read += $addVal;
    }
    public function addSpeak($addVal) {
        self::$speak += $addVal;
    }
    public function addGrsp($addVal) {
        self::$grsp += $addVal;
    }
    public function addHumor($addVal) {
        self::$humor += $addVal;
    }
    public function addInfo($addVal) {
        self::$info += $addVal;
    }
    public function addOo($addVal) {
        self::$oo += $addVal;
    }
    public function addDrama($addVal) {
        self::$drama += $addVal;
    }
    public function addPoetry($addVal) {
        self::$poetry += $addVal;
    }
    public function addProse($addVal) {
        self::$prose += $addVal;
    }
    public function addStory($addVal) {
        self::$story += $addVal;
    }
    public function getCrx() {
        return self::$crx;
    }
    public function getDisco() {
        return self::$disco;
    }
    public function getDuo() {
        return self::$duo;
    }
    public function getRead() {
        return self::$read;
    }
    public function getSpeak() {
        return self::$speak;
    }
    public function getGrsp() {
        return self::$grsp;
    }
    public function getHumor() {
        return self::$humor;
    }
    public function getInfo() {
        return self::$info;
    }
    public function getOo() {
        return self::$oo;
    }
    public function getDrama() {
        return self::$drama;
    }
    public function getPoetry() {
        return self::$poetry;
    }
    public function getProse() {
        return self::$prose;
    }
    public function getStory() {
        return self::$story;
    }
    
    public function compile() {
        $resultsPA = array(
            "Discussion" => self::getDisco(),
            "Extemporaneous Speaking" => self::getSpeak(),
            "Great Speeches" => self::getGrsp(),
            "Informative" => self::getInfo(),
            "Original Oratory" => self::getOo(),
        );
        $resultsINTERP = array(
            "Creative Expression" => self::getCrx(),
            "Duo Interpretation" => self::getDuo(),
            "Extemporaneous Reading" => self::getRead(),
            "Humorous" => self::getHumor(),
            "Serious Drama Interpretation" => self::getDrama(),
            "Serious Poetry Interpretation" => self::getPoetry(),
            "Serious Interpretation of Prose" => self::getProse(),
            "Storytelling" => self::getStory()
        );
          
        arsort($resultsPA);
        arsort($resultsINTERP);
        $newPA = array();
        $newINTERP = array();
        echo "<br>";
        
            foreach($resultsPA as $key => $val) {
                echo "$key = $val <br>";
                $newPA[] = $key;
            }
            foreach($resultsINTERP as $key => $val) {
                echo "$key = $val <br>";
                $newINTERP[] = $key;
            }
        $compile = array($newPA[0], $newPA[1], $newPA[2], $newINTERP[0], $newINTERP[1], $newINTERP[2]);
        echo "<br>";
        return $compile;
    }
    
    
    
    
}
