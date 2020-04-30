<?

class TOpenChart extends TScrollBox {
    
    public $class_name_ex = __CLASS__;

    public function __construct($onwer=nil,$init=true,$self=nil){
        parent::__construct($onwer, $init, $self);
	    
        if ($init){
            $this->graphColor  = clYellow;
            $this->borderStyle = bsNone;
            $this->parentColor = false;
            $this->color       = clBlack;
            $this->autoScroll  = false;
        }
    }

    public function setGraphColor($clr){
        $this->graphColor = $clr;
        if( !is_array($GLOBALS["openteechartshapes"][intval($this->self)]) or !count($GLOBALS["openteechartshapes"][intval($this->self)]) ) return;
        foreach( $GLOBALS["openteechartshapes"][intval($this->self)] as $sh){
            $sh->brushColor = $clr;
            $sh->penColor = $clr;
        }
    }

    public function clear(){
        if(!$GLOBALS["openteechartshapes"][intval($this->self)]) return;
        foreach($GLOBALS["openteechartshapes"][intval($this->self)] as $shapes){
            $shapes->free();
        }
        $GLOBALS["openteechartshapes"][intval($this->self)] = array();
        $GLOBALS["openteechartx"][intval($this->self)] = 1;

        
    }

    public function addNewValue($val){
        if($GLOBALS["openteechartx"][intval($this->self)] >= $this->w){
            $this->clear();
        }

        if( is_array($GLOBALS["openteechartshapes"][intval($this->self)]) or count($GLOBALS["openteechartshapes"][intval($this->self)]) ){
            end($GLOBALS["openteechartshapes"][intval($this->self)]);
            $sh = current($GLOBALS["openteechartshapes"][intval($this->self)]);
            if( $GLOBALS["openteechartlastval"][intval($this->self)] == $val && $sh->h == 2 ){
                $sh->w += 2;
                $GLOBALS["openteechartx"][intval($this->self)] += 2;
                return;
            }
        }
        $sh = new TShape;
        $sh->parent = $this;    
        $sh->w = 2;
        if(!$GLOBALS["openteechartlastval"][intval($this->self)] or !($val - $GLOBALS["openteechartlastval"][intval($this->self)])) $sh->h = 2;
        else $sh->h = ($val - $GLOBALS["openteechartlastval"][intval($this->self)]) + 2;
        $sh->y = ($this->h - $val);
        $sh->x = $GLOBALS["openteechartx"][intval($this->self)] += 1;
        $sh->brushColor = $this->graphColor;
        $sh->penColor = $this->graphColor;
        $sh->anchors = "akBottom, akLeft";



        $GLOBALS["openteechartshapes"][intval($this->self)][] = $sh;
        $GLOBALS["openteechartlastval"][intval($this->self)] = $val;
    }
    
    public function __initComponentInfo(){
    }
}