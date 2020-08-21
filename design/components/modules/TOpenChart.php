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
            $this->valueWidth  = 2;
            $this->offset      = 0;
            $this->showval     = true;
        }
    }

    public function clear(){
        if(!$GLOBALS["__openteechartshapes"][intval($this->self)]) return;
        foreach($GLOBALS["__openteechartshapes"][intval($this->self)] as $shapes){
            $shapes->free();
        }
        $GLOBALS["__openteechartshapes"][intval($this->self)] = array();
        $GLOBALS["__openteechartx"][intval($this->self)] = 1;
    }
    
    public function addNewValue($val){
        if($GLOBALS["__openteechartx"][intval($this->self)] >= $this->w){
            $this->clear();
        }
        if($this->showval){
            if( !$GLOBALS["__openteechartlabelval"][intval($this->self)]){
                $GLOBALS["__openteechartlabelval"][intval($this->self)] = new TLabel;
                $GLOBALS["__openteechartlabelval"][intval($this->self)]->parent = $this;
                $GLOBALS["__openteechartlabelval"][intval($this->self)]->font->name = "Segoe UI";
                $GLOBALS["__openteechartlabelval"][intval($this->self)]->font->size = 9;
                $GLOBALS["__openteechartlabelval"][intval($this->self)]->autoSize = true;
            }
            $GLOBALS["__openteechartlabelval"][intval($this->self)]->font->color = $this->graphColor;
            $GLOBALS["__openteechartlabelval"][intval($this->self)]->x = $GLOBALS["__openteechartx"][intval($this->self)] + 8;
            
        }
        else {
            if(is_object($GLOBALS["__openteechartlabelval"][intval($this->self)])){
                $GLOBALS["__openteechartlabelval"][intval($this->self)]->free();
            }
            $GLOBALS["__openteechartlabelval"][intval($this->self)] = false;
        }

        if( is_array($GLOBALS["__openteechartshapes"][intval($this->self)]) or count($GLOBALS["__openteechartshapes"][intval($this->self)]) ){
            end($GLOBALS["__openteechartshapes"][intval($this->self)]);
            $sh = current($GLOBALS["__openteechartshapes"][intval($this->self)]);
            if( $GLOBALS["__openteechartlastval"][intval($this->self)] == $val && $sh->h == 2 ){
                $sh->w += 2;


                //if($sh->h == 2) $GLOBALS["__openteechartx"][intval($this->self)] += $this->valueWidth;
                /*else*/ $GLOBALS["__openteechartx"][intval($this->self)] += 2;
                return;
            }
        }

        if( is_array($GLOBALS["__openteechartshapes"][intval($this->self)]) or count($GLOBALS["__openteechartshapes"][intval($this->self)]) ){
            end($GLOBALS["__openteechartshapes"][intval($this->self)]);
            $sh = current($GLOBALS["__openteechartshapes"][intval($this->self)]);
            if( $GLOBALS["__openteechartlastval"][intval($this->self)] == $val && $sh->h == 2 ){
                $sh->w += 2;


                if($sh->h == 2) $GLOBALS["__openteechartx"][intval($this->self)] += $this->valueWidth;
                else  $GLOBALS["__openteechartx"][intval($this->self)] += 2;
                return;
            }
        }
        $sh = new TShape;
        $sh->parent = $this;
        if(!$GLOBALS["__openteechartlastval"][intval($this->self)] or !($val - $GLOBALS["__openteechartlastval"][intval($this->self)])) $sh->h = 2;
        else $sh->h = ($val - $GLOBALS["__openteechartlastval"][intval($this->self)]) + 2;
        $sh->y = ($this->h - $val - 2 - $this->offset);
        $sh->x = ($GLOBALS["__openteechartx"][intval($this->self)]);
        $sh->brushColor = $this->graphColor;
        $sh->penColor = $this->graphColor;
        $sh->anchors = "akBottom, akLeft";
        
        if( $this->valueWidth > 0 && $this->valueWidth != 2){

            if($sh->h == 2) {
                $sh->w = $this->valueWidth;
                $GLOBALS["__openteechartx"][intval($this->self)] += $this->valueWidth;
            }
            else {
                $sh->w = 2;
                $GLOBALS["__openteechartx"][intval($this->self)] += 4;
                $sh->x += 2;
                $sh2 = new TShape;
                $sh2->parent = $this;
                $sh2->h = 2;
                $sh2->w = 2;
                $sh2->y = ($sh->h + $sh->y) - 2;
                $sh2->x = $sh->x - 2;
                $sh2->brushColor = $this->graphColor;
                $sh2->penColor = $this->graphColor;
                $sh2->anchors = "akBottom, akLeft";
                $GLOBALS["__openteechartshapes"][intval($this->self)][] = $sh2;
            }
        }
        else $sh->w = 2;
/*
        if($this->stretch){
            $sh->h = intval(($this->h / 100) * $sh->h);
            $sh->y = intval($sh->y * ($this->h / 100));
        }
*/
        $GLOBALS["__openteechartshapes"][intval($this->self)][] = $sh;
        $GLOBALS["__openteechartlastval"][intval($this->self)] = $val;


        if($this->showval){
            $GLOBALS["__openteechartlabelval"][intval($this->self)]->y = ($this->h - $GLOBALS["__openteechartlastval"][intval($this->self)]) - intval($GLOBALS["__openteechartlabelval"][intval($this->self)]->h);
            $GLOBALS["__openteechartlabelval"][intval($this->self)]->caption = $val;
            $GLOBALS["__openteechartlabelval"][intval($this->self)]->x = $GLOBALS["__openteechartx"][intval($this->self)] + 8;
        }
        //$GLOBALS["__openteechartx"][intval($this->self)] += $this->valueWidth;

        //pre($GLOBALS["__openteechartlabelval"][$this->self]->x . " " . $GLOBALS["__openteechartlabelval"][$this->self]->y . " " . $GLOBALS["__openteechartlabelval"][intval($this->self)]->caption);
    }
    
    public function __initComponentInfo(){
    }
}