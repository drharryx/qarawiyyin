<?php

namespace FacturaScripts\Plugins\qarawiyyin\Lib\ListFilter;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Dinamic\Lib\AssetManager;
use FacturaScripts\Dinamic\Lib\ListFilter\AutocompleteFilter as ParentAut;

/**
 * Description of AutocompleteFilter
 *
 * @author Jorge Mendoza <jorgmendoz@gmail.com>
 */
class AutocompleteFilter extends ParentAut
{

    /**
     *
     * @var string
     */
    public $fieldcode;

    /**
     *
     * @var string
     */
    public $fieldtitle;

    /**
     *
     * @var string
     */
    public $table;

    /**
     *
     * @var array
     */
    public $where;

    /**
     *
     * @param string $key
     * @param string $field
     * @param string $label
     * @param string $table
     * @param string $fieldcode
     * @param string $fieldtitle
     * @param array  $where
     */
    public function __construct($key, $field, $label, $table, $fieldcode = '', $fieldtitle = '', $where = [])
    {
        parent::__construct($key, $field, $label);
        $this->table = $table;
        $this->fieldcode = empty($fieldcode) ? $this->field : $fieldcode;
        $this->fieldtitle = empty($fieldtitle) ? $this->fieldcode : $fieldtitle;
        $this->where = $where;
    }

    /**
     *
     * @param array $where
     *
     * @return bool
     */
    public function getDataBaseWhere(array &$where): bool
    {
        if ('' !== $this->value && null !== $this->value) {
            $where[] = new DataBaseWhere($this->field, $this->value);
            return true;
        }

        return false;
    }

    /**
     *
     * @return string
     */
    public function render()
    {
        $label = static::$i18n->trans($this->label);
        $html = '<div class="col-sm-3 col-lg-2">'
            . '<input type="hidden" name="' . $this->name() . '" value="' . $this->value . '"/>'
            . '<div class="form-group">'
            . '<div class="input-group">';

        if ('' === $this->value || null === $this->value) {
            $html .= '<span class="input-group-prepend" title="' . $label . '">'
                . '<span class="input-group-text">'
                . '<i class="fas fa-search fa-fw" aria-hidden="true"></i>'
                . '</span>'
                . '</span>';
        } else {
            $html .= '<span class="input-group-prepend" title="' . $label . '">'
                . '<button class="btn btn-warning" type="button" onclick="this.form.' . $this->name() . '.value = \'\'; this.form.submit();">'
                . '<i class="fas fa-times fa-fw" aria-hidden="true"></i>'
                . '</button>'
                . '</span>';
        }

        $html .= '<input type="text" value="' . $this->getDescription() . '" class="form-control filter-autocomplete"'
            . ' data-name="' . $this->name() . '" data-field="' . $this->field . '" data-source="' . $this->table . '" data-fieldcode="' . $this->fieldcode
            . '" data-fieldtitle="' . $this->fieldtitle . '" placeholder = "' . $label . '" autocomplete="off"/>'
            . '</div>'
            . '</div>'
            . '</div>';

        return $html;
    }

    /**
     * Adds need asset to the asset manager.
     */
    protected function assets()
    {
        AssetManager::add('js', \FS_ROUTE . '/Dinamic/Assets/JS/ListFilterAutocomplete.js');
    }

    /**
     *
     * @return string
     */
    protected function getDescription()
    {
        $codeModel = new CodeModel();
        return $codeModel->getDescription($this->table, $this->fieldcode, $this->value, $this->fieldtitle);
    }
}
