<?php
/**
 * Created by PhpStorm.
 * User: gmuheim
 * Date: 18.10.18
 * Time: 14:20
 */

class WidgetButton extends Widget
{

    /**
     * @var boolean
     * @Getter @Setter
     */
    protected $isDisabled = false;

    public function __construct($label = '')
    {
        parent::__construct();
        $this->setLabel($label);
    }

    public function setDisabled($isDisabled)
    {
        $this->isDisabled = $isDisabled;
    }

    public function prepare()
    {
        $this->code = '<button '
            . 'type="button" '
            . 'id="' . $this->id . '" '
            . 'class="' . self::class . '' . ($this->isDisabled ? ' disabled' : '') . $this->cssClasses . '" '
            . ($this->actionName !== '' ? 'data-action="' . $this->actionName . '" ' : '')
            . ($this->isDisabled ? 'tabindex="-1"' : '') . ' '
            . ($this->tooltip !== null ? 'title="' . $this->tooltip . '"' : '')
            . ($this->isDisabled ? 'disabled' : '') . '>';
        $this->code .= $this->label;
        $this->code .= '</button>';
    }
}
