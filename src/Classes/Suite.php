<?php
/**
 * Created by PhpStorm.
 * User: Angelos Roussakis (aggelos.roussakis@gmail.com)
 * Date: 05/04/18
 * Time: 12:50
 */

namespace BehatHTMLFormatter\Classes;

class Suite
{
    private $name;
    private $features;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * @param mixed $features
     */
    public function setFeatures($features)
    {
        $this->features = $features;
    }

    /**
     * @param $feature
     */
    public function addFeature($feature)
    {
        $this->features[] = $feature;
    }
}
