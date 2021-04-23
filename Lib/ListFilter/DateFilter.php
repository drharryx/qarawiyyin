<?php

namespace FacturaScripts\Plugins\qarawiyyin\Lib\ListFilter;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;

use FacturaScripts\Dinamic\Lib\ListFilter\DateFilter as ParentDateFilter;
/**
 * Description of DateFilter
 *
 * @author Jorge Mendoza <jorgmendoz@gmail.com>
 */
class DateFilter extends ParentDateFilter
{

    /**
     *
     * @var string
     */
    public $operation;

    /**
     *
     * @param string $key
     * @param string $field
     * @param string $label
     * @param string $operation
     */
    public function __construct($key, $field = '', $label = '', $operation = '>=')
    {
        parent::__construct($key, $field, $label);
        $this->operation = $operation;
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
            $where[] = new DataBaseWhere($this->field, $this->value, $this->operation);
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
        $cssClass = $this->readonly ? '' : ' datepicker';
        $label = static::$i18n->trans($this->label);
        return '<div class="col-sm-3 col-lg-2">'
            . '<div class="form-group">'
            . '<div class="input-group">'
            . '<span class="input-group-prepend" title="' . $label . '">'
            . '<span class="input-group-text">'
            . '<i class="far fa-calendar-alt fa-fw" aria-hidden="true"></i>'
            . '</span>'
            . '</span>'
            . '<input type="text" name="' . $this->name() . '" value="' . $this->value . '" class="form-control' . $cssClass . '"'
            . ' placeholder="' . $label . '" autocomplete="off"' . $this->onChange() . $this->readonly() . '/>'
            . '</div>'
            . '</div>'
            . '</div>';
    }
}
