<?php declare(strict_types = 1);

namespace Libs\Api;

class Ares
{
    private string $ares_url = 'https://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=';

    /** @var int */
    private $ic;

    /** @var int */
    private $xml;

    /**
     *  @param int $ic IČ of subject
     */
    public function __construct($ic = 0)
    {
        $this->ic = (int) $ic;
        $url = $this->ares_url . $this->ic;
        $this->xml = $this->getXML($url);
    }

    /**
     *  @return array Data
     */
    public function getData()
    {
        if ($this->ic == $this->getIntValueFromXML('D:ICO')) {
            $address = $this->getTextValueFromXML('D:NU').'+'.$this->getIntValueFromXML('D:CD').'+'.$this->getTextValueFromXML('D:N');
            return array (
                'name' => $this->getTextValueFromXML('D:OF'),
                'street' =>($this->getTextValueFromXML('D:NU').' '.$this->getIntValueFromXML('D:CD').($this->getIntValueFromXML('D:CO')?'/'.$this->getIntValueFromXML('D:CO'):'')),
                'ic' => $this->ic,
                'dic' => $this->getDicFromXML()?:'CZ'.$this->ic,
                'form' => $this->getTextValueFromXML('D:KPF'),
                'city' => $this->getTextValueFromXML('D:N'),
                'employee' => $this->getTextValueFromXML('D:KPP'),
                'founded' => date('Y', strtotime($this->getTextValueFromXML('D:DV'))),
                'postal' => $this->getIntValueFromXML('D:PSC')
            );
        }
        return false;
    }

    /**
     * @param string $field
     * @return string
     */
    private function getIntValueFromXML($field)
    {
        $pattern = '/([0-9]*)<\/'.$field.'>/';
        preg_match($pattern,  $this->xml, $matches);
        return isset($matches[1])?$matches[1]:false;
    }

    /**
     * @param string $field
     * @return string
     */
    private function getTextValueFromXML($field)
    {
        $pattern = '/(.*)<\/'.$field.'>/';
        preg_match($pattern,  $this->xml, $matches);
        return isset($matches[1])?strip_tags($matches[1]):false;
    }

    /**
     * @return string
     */
    private function getDicFromXML()
    {
        $pattern = '/([0-9]*)<\/D:DIC>/';
        preg_match($pattern,  $this->xml, $matches);
        return isset($matches[1])?'CZ'.$matches[1]:false;
    }

    /**
     * @param string $url
     * @return string
     */
    private function getXML($url)
    {
        return file_get_contents($url);
    }
}
