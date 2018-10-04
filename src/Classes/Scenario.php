<?php
/**
 * Created by PhpStorm.
 * User: Angelos Roussakis (aggelos.roussakis@gmail.com)
 * Date: 05/04/18
 * Time: 14:39
 */

namespace BehatHTMLFormatter\Classes;

class Scenario
{
    /**
     * @var int
     */
    private $id;
    private $title;
    private $line;
    private $tags;

    private $loopCount;

    /**
     * @var bool
     */
    private $passed;

    /**
     * @var bool
     */
    private $pending;

    /**
     * @var Step[]
     */
    private $steps;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getLoopCount()
    {
        return $this->loopCount;
    }

    /**
     * @param int $loopCount
     */
    public function setLoopCount($loopCount)
    {
        $this->loopCount = $loopCount;
    }

    /**
     * @return mixed
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param mixed $line
     */
    public function setLine($line)
    {
        $this->line = $line;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return boolean
     */
    public function isPassed()
    {
        return $this->passed;
    }

    /**
     * @param boolean $passed
     */
    public function setPassed($passed)
    {
        $this->passed = $passed;
    }

    /**
     * @return boolean
     */
    public function isPending()
    {
        return $this->pending;
    }

    /**
     * @param boolean $pending
     */
    public function setPending($pending)
    {
        $this->pending = $pending;
    }

    /**
     * @return Step[]
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * @param Step[] $steps
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;
    }

    /**
     * @param Step $step
     */
    public function addStep($step)
    {
        $this->steps[] = $step;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLoopSize()
    {
        //behat
        return $this->loopCount > 0 ? sizeof($this->steps) / $this->loopCount : sizeof($this->steps);
    }
}
