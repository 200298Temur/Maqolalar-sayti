<?php 
 namespace App;
class TinkerService{
    public function service(){
        echo $this->add(2,2);
    }
    public function add($x,$y){
        return $x+$y;
    }

    public function kop($x){
        return $x*2;
    }
}

$ss = new TinkerService();
echo $ss->service();