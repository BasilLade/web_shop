<?php
/**
 * 
 * Definiert die notwendigen Methoden die eine Entität besitzen muss um
 * funktionell zu sein.
 * 
 * Entitys sind Objekte die Daten enthalten die man speichern, verarbeiten,
 * übergeben kann.
 * 
 * @author g.muheim
 */
interface EntityInt {

    
    /**
     * Setzt den Wert in einem Feld der Entity.
     * 
     * @param string $fieldName Der Name des Feldes bei welchem der Wert gesetzt
     * werden soll.
     * @param mixed $value Der Wert der im Feld gespeichert werden soll.
     * 
     * @throws Exception Sollte das Feld nicht existieren wird eine Ausnahme
     * generiert. Diese beinhaltet den Namen der Klasse, der aufgerufenen 
     * Funktion und des ungültigen Feldes wo der Wert gesetzt wurde.
     */
    public function set($fieldName, $value);

    /**
     * Liefert den Wert der in einem Feld gesetzt ist zurück.
     * 
     * @param string $fieldName Der Name des Feldes dessen Wert man zurück erhalten
     * will.
     * 
     * @return mixed Die Daten die im Feld mit dem übergebenen Namen gesetzt 
     * sind.
     * 
     * @throws Exception Sollte das Feld nicht existieren, wird eine Ausnahme
     * generiert. Diese beinhaltet den Namen der Klasse, der aufgerufenen 
     * Funktion und des ungültigen Feldes.
     */
    public function get($fieldName);

    /**
     * Liefert alle Felder mit den dazugehörigen Daten als assoziatives Array
     * zurück.
     * 
     * @return Array<mixed> Ein assoziatives Array mit den Daten die in der
     * Entity gesetzt sind. 
     */
    public function getData();

    /**
     * Setzt die Daten der Entity anhand eines assoziativen Arrays. Die Schlüssel
     * des Arrays müssen mit den Konstanten die in der Entität definiert sind
     * übereinstimmen.
     *
     * @param array $data
     */
    public function setData(array $data);

    public function disconnectFrom(Entity $entity);

    public function connectTo(Entity $entity);
}
