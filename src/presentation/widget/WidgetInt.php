<?php

/**
 * -----------------------------------------------------------------------------
 * WidgetInt
 * -----------------------------------------------------------------------------
 *
 * WidgetInt definiert die Methoden welche
 * die Klasse Widget implementieren muss.
 *
 * Ein Widget ist ein für sich abgeschlossenes GUI Element und besteht aus HTML
 * Tags. Widgets können von anderen Widgets "konsumiert" werden, das heisst
 * ein grosses Widget kann aus kleinen Widgets bestehen. Z.B. wäre ein
 * Formular ein grosses Widget was kleine Widgets (Inputs) enthält.
 *
 * @author j.windmeisser
 * @author b.lade
 * @author g.muheim
 */
interface WidgetInt
{

    /**
     * -------------------------------------------------------------------------
     * HTML Code vorbereiten
     * -------------------------------------------------------------------------
     *
     * Diese Methode wird von den jeweiligen Widgets verwendet, um den HTML code
     * bzw. string aufzubereiten. Die Methode wird aufgerufen, wenn ein Widget
     * Objekt als Zeichenkette aufgerufen wird, was z.B. so ausehen kann:
     *
     * <i>echo new InputWidget();</i>
     *
     * oder so
     *
     * <i>
     * $input = new InputWidget();<br>
     * $input->setActionName('superTolleAction');<br>
     * echo $input;
     * </i>
     *
     * @return void
     *
     */
    public function prepare();

    /**
     * -------------------------------------------------------------------------
     * HTML Labeltext setzen
     * -------------------------------------------------------------------------
     *
     * Diese Methode setzt das Label z.B. für ein Inputfeld.
     *
     * @param string $label
     */
    public function setLabel(string $label);

    /**
     * -------------------------------------------------------------------------
     * HTML Labeltext zurückliefern
     * -------------------------------------------------------------------------
     *
     * Diese Methode liefert den Labeltext zürück.
     *
     * @return string Liefert den Labeltext zurück
     */
    public function getLabel(): string;

    /**
     * -------------------------------------------------------------------------
     * HTML Inhalt setzen
     * -------------------------------------------------------------------------
     *
     * Diese Methode setzt den Wert welcher zwischen den HTML Tags steht.
     *
     * @param string $value Der Wert als string
     *
     * @return void
     */
    public function setValue(string $value);

    /**
     * -------------------------------------------------------------------------
     * HTML Inhalt zurückliefern
     * -------------------------------------------------------------------------
     *
     * Diese Methode liefert den Wert welcher zwischen den HTML Tags steht zurück.
     *
     * @return string liefert den Wert des HTML Elements zurück
     */
    public function getValue();

    /**
     * -------------------------------------------------------------------------
     * Aktionname setzen
     * -------------------------------------------------------------------------
     *
     * Diese Methode setzt den Aktionsnamen fest, welcher im Widget selber als
     * Wert eines HTML data attributes verwendet wird.
     *
     * @param string $actionName Der Aktionsname als string
     *
     * @return void
     */
    public function setActionName(string $actionName);

    /**
     * -------------------------------------------------------------------------
     * Hinweistext setzen
     * -------------------------------------------------------------------------
     *
     * Diese Methode setzt den Text für die Kurzinfo fest. Die Kurzinfo erscheint,
     * nachdem der Nutzer mit dem Mauszeiger über das entprechende Widget fährt.
     *
     * @param string $tooltip
     *
     * @return void
     */
    public function setTooltip(string $tooltip);

    /**
     * -------------------------------------------------------------------------
     * Css Klasse setzen
     * -------------------------------------------------------------------------
     *
     * Diese Methode setzt den Wert für zusätzliche Css Klassen fest.
     *
     * @param string $cssClass Die Css Klasse als string
     *
     * @return void
     */
    public function addCssClass(string $cssClass);
}
