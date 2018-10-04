<?php
/**
 * Created by PhpStorm.
 * User: Angelos Roussakis (aggelos.roussakis@gmail.com)
 * Date: 05/04/18
 * Time: 14:39
 */

namespace BehatHTMLFormatter\Classes;

class Feature
{
    private $id;
    private $title;
    private $description;
    private $tags;
    private $line;

    private $failedScenarios = 0;
    private $pendingScenarios = 0;
    private $passedScenarios = 0;
    private $scenarioCounter = 1;

    /**
     * @var Scenario[]
     */
    private $scenarios;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $name
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return Scenario[]
     */
    public function getScenarios()
    {
        return $this->scenarios;
    }

    /**
     * @param Scenario[] $scenarios
     */
    public function setScenarios($scenarios)
    {
        $this->scenarios = $scenarios;
    }

    /**
     * @param $scenario Scenario
     */
    public function addScenario($scenario)
    {
        $scenario->setId($this->scenarioCounter);
        $this->scenarioCounter++;
        $this->scenarios[] = $scenario;
    }

    /**
     * @return mixed
     */
    public function getFailedScenarios()
    {
        return $this->failedScenarios;
    }

    /**
     * @param mixed $failedScenarios
     */
    public function setFailedScenarios($failedScenarios)
    {
        $this->failedScenarios = $failedScenarios;
    }

    public function addFailedScenario($number = 1)
    {
        $this->failedScenarios += $number;
    }

    /**
     * @return mixed
     */
    public function getPendingScenarios()
    {
        return $this->pendingScenarios;
    }

    /**
     * @param mixed $pendingScenarios
     */
    public function setPendingScenarios($pendingScenarios)
    {
        $this->pendingScenarios = $pendingScenarios;
    }

    public function addPendingScenario($number = 1)
    {
        $this->pendingScenarios += $number;
    }

    /**
     * @return mixed
     */
    public function getPassedScenarios()
    {
        return $this->passedScenarios;
    }

    /**
     * @param mixed $passedScenarios
     */
    public function setPassedScenarios($passedScenarios)
    {
        $this->passedScenarios = $passedScenarios;
    }

    public function addPassedScenario($number = 1)
    {
        $this->passedScenarios += $number;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function allPassed()
    {
        if ($this->failedScenarios == 0 && $this->pendingScenarios == 0) {
            return true;
        }
        return false;
    }

    public function getPassedClass()
    {
        if ($this->allPassed()) {
            return "passed";
        }
        return "failed";
    }

    public function getPercentPassed()
    {
        return ($this->getPassedScenarios() / ($this->getTotalAmountOfScenarios())) * 100;
    }

    public function getPercentPending()
    {
        return ($this->getPendingScenarios() / ($this->getTotalAmountOfScenarios())) * 100;
    }

    public function getPercentFailed()
    {
        return ($this->getFailedScenarios() / ($this->getTotalAmountOfScenarios())) * 100;
    }

    public function getTotalAmountOfScenarios()
    {
        return $this->getPassedScenarios() + $this->getPendingScenarios() + $this->getFailedScenarios();
    }
}
