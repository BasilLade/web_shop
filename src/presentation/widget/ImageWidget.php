<?php

/**
 * -----------------------------------------------------------------------------
 * ImageWidget Klasse
 * -----------------------------------------------------------------------------
 * 
 * @author b.lade
 */
class ImageWidget extends Widget {
    
    protected $src;
    
    protected $alt;

    public function __construct(string $src, string $alt = '') {
        parent::__construct();
        $this->src = $src;
        $this->alt = $alt;
    }

    public function prepare() {
        $this->code .= '<img '
        . 'class="'. self::class . $this->cssClasses .'" '
        . 'id="'. $this->id .'" '
        . 'src="' . $this->src . '" '
        . ($this->alt !== '' ? 'alt="'. $this->alt .'"' : '') . '/>';
    }
}
    