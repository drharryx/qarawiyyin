<?php

namespace FacturaScripts\Plugins\qarawiyyin\Lib\ListFilter;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;

use FacturaScripts\Dinamic\Lib\ListFilter\NumberFilter as ParentNumberFilter;
/**
 * Description of NumberFilter
 *
 * @author Jorge Mendoza <jorgmendoz@gmail.com>
 */
class NumberFilter extends ParentNumberFilter
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
        return '<div class="col-sm-3 col-lg-2">'
            . '<div class="form-group">'
            . '<input type="text" name="' . $this->name() . '" value="' . $this->value . '" class="form-control" placeholder="'
            . $this->operation . ' ' . static::$i18n->trans($this->label) . '" autocomplete="off"' . $this->onChange() . '/>'
            . '</div>'
            . '</div>';
    }
}
