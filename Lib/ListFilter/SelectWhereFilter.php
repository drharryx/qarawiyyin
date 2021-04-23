<?php

namespace FacturaScripts\Plugins\qarawiyyin\Lib\ListFilter;


use FacturaScripts\Dinamic\Lib\ListFilter\SelectFilter;
/**
 * Description of SelectFilter
 *
 * @author Jorge Mendoza <jorgmendoz@gmail.com>
 */
class SelectWhereFilter extends SelectFilter
{

    /**
     *
     * @param string $key
     * @param array  $values
     */
    public function __construct($key, $values = [])
    {
        parent::__construct($key, '', '', $values);
    }

    /**
     *
     * @param array $where
     *
     * @return bool
     */
    public function getDataBaseWhere(array &$where): bool
    {
        $value = ($this->value == '' || $this->value == null) ? 0 : $this->value;
        foreach ($this->values[$value]['where'] as $condition) {
            $where[] = $condition;
        }

        return ($value > 0);
    }

    /**
     *
     * @return string
     */
    protected function getHtmlOptions()
    {
        $html = '';
        foreach ($this->values as $key => $data) {
            $extra = ('' != $this->value && $key == $this->value) ? ' selected=""' : '';
            $html .= '<option value="' . $key . '"' . $extra . '>' . $data['label'] . '</option>';
        }

        return $html;
    }
}
