<?php
namespace EMT\Tret;

class Etc extends AbstractTret
{

    public $classes = array(
        'nowrap' => 'word-spacing:nowrap;',
    );

    /**
     * Базовые параметры тофа
     *
     * @var array
     */
    public $title = "Прочее";
    public $rules = array(
        'acute_accent' => array(
            'description' => 'Акцент',
            'pattern' => '/(у|е|ы|а|о|э|я|и|ю|ё)\`(\w)/i',
            'replacement' => '\1&#769;\2'
        ),

        'word_sup' => array(
            'description' => 'Надстрочный текст после символа ^',
            'pattern' => '/((\s|\&nbsp\;|^)+)\^([a-zа-яё0-9\.\:\,\-]+)(\s|\&nbsp\;|$|\.$)/ieu',
            'replacement' => '"" . $this->tag($this->tag($m[3],"small"),"sup") . $m[4]'
        ),
        'century_period' => array(
            'description' => 'Тире между диапозоном веков',
            'pattern' => '/(\040|\t|\&nbsp\;|^)([XIV]{1,5})(-|\&mdash\;)([XIV]{1,5})(( |\&nbsp\;)?(в\.в\.|вв\.|вв|в\.|в))/eu',
            'replacement' => '$m[1] .$this->tag($m[2]."&mdash;".$m[4]." вв.","span", array("class"=>"nowrap"))'
        ),
        'time_interval' => array(
            'description' => 'Тире и отмена переноса между диапозоном времени',
            'pattern' => '/([^\d\>]|^)([\d]{1,2}\:[\d]{2})(-|\&mdash\;|\&minus\;)([\d]{1,2}\:[\d]{2})([^\d\<]|$)/eui',
            'replacement' => '$m[1] . $this->tag($m[2]."&mdash;".$m[4],"span", array("class"=>"nowrap")).$m[5]'
        ),
        'expand_no_nbsp_in_nobr' => array(
            'description' => 'Удаление nbsp в nobr/nowrap тэгах',
            'function' => 'remove_nbsp'
        ),
    );

    protected function remove_nbsp()
    {
        $thetag = $this->tag("###", 'span', array('class' => "nowrap"));
        $arr = explode("###", $thetag);
        $b = preg_quote($arr[0], '/');
        $e = preg_quote($arr[1], '/');

        $match = '/(^|[^a-zа-яё])([a-zа-яё]+)\&nbsp\;(' . $b . ')/iu';
        do {
            $this->_text = preg_replace($match, '\1\3\2 ', $this->_text);
        } while (preg_match($match, $this->_text));

        $match = '/(' . $e . ')\&nbsp\;([a-zа-яё]+)($|[^a-zа-яё])/iu';
        do {
            $this->_text = preg_replace($match, ' \2\1\3', $this->_text);
        } while (preg_match($match, $this->_text));

        $this->_text = $this->preg_replace_e('/' . $b . '.*?' . $e . '/iue', 'str_replace("&nbsp;"," ",$m[0]);', $this->_text);
    }

}
