<?php

namespace FacturaScripts\Plugins\qarawiyyin\Lib\ListFilter;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;

use FacturaScripts\Dinamic\Lib\ListFilter\SelectFilter as ParentSelectFilter;
/**
 * Description of SelectFilter
 *
 * @author Jorge Mendoza <jorgmendoz@gmail.com>
 */
class SelectFilter extends ParentSelectFilter
{

    /**
     *
     * @var string
     */
    public $icon = '';

    /**
     *
     * @var array
     */
    public $values;

    /**
     *
     * @param string $key
     * @param string $field
     * @param string $label
     * @param array  $values
     */
    public function __construct($key, $field, $label, $values = [])
    {
        parent::__construct($key, $field, $label);
        $this->values = $values;
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
        if (empty($this->icon)) {
            return '<div class="col-sm-3 col-lg-2">'
                . '<div class="form-group">'
                . '<select name="' . $this->name() . '" class="form-control"' . $this->onChange() . '>'
                . $this->getHtmlOptions()
                . '</select>'
                . '</div>'
                . '</div>';
        }

        return '<div class="col-sm-3 col-lg-2">'
            . '<div class="form-group">'
            . '<div class="input-group">'
            . '<span class="input-group-prepend">'
            . '<span class="input-group-text">'
            . '<i class="' . $this->icon . ' fa-fw" aria-hidden="true"></i>'
            . '</span>'
            . '</span>'
            . '<select name="' . $this->name() . '" class="form-control"' . $this->onChange() . '>'
            . $this->getHtmlOptions()
            . '</select>'
            . '</div>'
            . '</div>'
            . '</div>';
    }

    /**
     *
     * @return string
     */
    protected function getHtmlOptions()
    {
        $html = '<option value="">' . static::$i18n->trans($this->label) . '</option>';
        foreach ($this->values as $data) {
            if (is_array($data)) {
                $extra = ('' != $this->value && $data['code'] == $this->value) ? ' selected=""' : '';
                $html .= '<option value="' . $data['code'] . '"' . $extra . '>' . $data['description'] . '</option>';
                continue;
            }

            $extra = ('' != $this->value && $data->code == $this->value) ? ' selected=""' : '';
            $html .= '<option value="' . $data->code . '"' . $extra . '>' . $data->description . '</option>';
        }

        return $html;
    }
}
