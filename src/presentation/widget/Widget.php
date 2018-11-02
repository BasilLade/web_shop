<?php
/**
 * Created by PhpStorm.
 * User: gmuheim
 * Date: 18.10.18
 * Time: 14:08
 */

abstract class Widget implements WidgetInt
{
    /**
     * -------------------------------------------------------------------------
     * HTML Code
     * -------------------------------------------------------------------------
     *
     * @var string
     */
    protected $code;

    /**
     * -------------------------------------------------------------------------
     * HTML label
     * -------------------------------------------------------------------------
     *
     * @var string
     * @Setter @Getter
     */
    protected $label = '';

    /**
     * -------------------------------------------------------------------------
     * HTML Inhalt
     * -------------------------------------------------------------------------
     *
     * @var string
     * @Setter @Getter
     */
    protected $value;

    /**
     * -------------------------------------------------------------------------
     * Aktionsnamen Wert
     * -------------------------------------------------------------------------
     *
     * @var string
     */
    protected $actionName = '';

    /**
     * -------------------------------------------------------------------------
     * Id Wert
     * -------------------------------------------------------------------------
     *
     * @var string
     */
    protected $id;

    /**
     * -------------------------------------------------------------------------
     * Css Klassen text
     * -------------------------------------------------------------------------
     *
     * @var string
     */
    protected $cssClasses = '';

    /**
     * -------------------------------------------------------------------------
     * Tooltip text
     * -------------------------------------------------------------------------
     *
     * @var string
     */
    protected $tooltip = null;

    /**
     * -------------------------------------------------------------------------
     * GUID v4
     * -------------------------------------------------------------------------
     *
     * Damit die Widgets alle eindeutig identifiziert werden können, wird ihnen
     * einen GUID v4 string zugewiesen, welcher bei jedem neuen Widget Objekt
     * neu generiert wird.
     *
     * @see Entity::getGUID()
     */
    public function __construct()
    {
        $this->id = Entity::getGUID();
    }

    /**
     * -------------------------------------------------------------------------
     * HTML Code zurückgeben
     * -------------------------------------------------------------------------
     *
     * <i>__toString()</i> wird erst aufgerufen, wenn das Widget Objekt als Zei-
     * chenkette aufgerufen wird. Danach wird <i>prepare()</i> aufgerufen und
     * gibt den HTML Code als string zurück.
     *
     * @return string Liefert den HTML Code als string zurück
     *
     * @see WidgetInterface::prepare()
     */
    public function __toString()
    {
        $this->prepare();

        /*
         * Mit dem Konkatenationsoperator und dem leeren String stellt man
         * sicher, dass der PHP-Interpreter die Daten die in <code>$this->code
         * </code> gespeichert sind in einen String umwandelt.
         */
        return $this->code . '';
    }

    /**
     * -------------------------------------------------------------------------
     * <i>getLabel()</i> implementation
     * -------------------------------------------------------------------------
     *
     * @see EntityInterface->getLabel() Interface implementation von <i>getLabel()</i>
     *
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * -------------------------------------------------------------------------
     * <i>setLabel()</i> implementation
     * -------------------------------------------------------------------------
     *
     * @see EntityInterface->setLabel() Interface implementation von <i>setLabel()</i>
     *
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    /**
     * -------------------------------------------------------------------------
     * <i>getValue()</i> implementation
     * -------------------------------------------------------------------------
     *
     * @see EntityInterface->getValue() Interface implementation von <i>getValue()</i>
     *
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * -------------------------------------------------------------------------
     * <i>setValue()</i> implementation
     * -------------------------------------------------------------------------
     *
     * @see EntityInterface->setValue() Interface implementation von <i>setValue()</i>
     *
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    /**
     * -------------------------------------------------------------------------
     * <i>setActionName()</i> implementation
     * -------------------------------------------------------------------------
     *
     * @see EntityInterface->setActionName() Interface implementation von <i>setActionName()</i>
     *
     */
    public function setActionName(string $actionName)
    {
        $this->actionName = $actionName;
    }

    /**
     * -------------------------------------------------------------------------
     * <i>setTooltip()</i> implementation
     * -------------------------------------------------------------------------
     *
     * @see EntityInterface->setTooltip() Interface implementation von <i>setTooltip()</i>
     *
     */
    public function setTooltip(string $tooltip)
    {
        $this->tooltip = $tooltip;
    }

    /**
     * -------------------------------------------------------------------------
     * <i>addCssClass()</i> implementation
     * -------------------------------------------------------------------------
     *
     * @see EntityInterface->addCssClass() Interface implementation von <i>addCssClass()</i>
     *
     */
    public function addCssClass(string $cssClass)
    {
        $this->cssClasses .= ' ' . $cssClass;
//        $this->cssClasses = ltrim($this->cssClasses);
    }

}