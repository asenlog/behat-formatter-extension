<?php

namespace App\Renderer;

class BaseRenderer
{
    const DOCUMENTATION_RENDERER = 'Documentation';
    const REPORT_RENDERER = 'Report';
    const TESTRAIL_RENDERER = 'Testrail';

    /**
     * @var : List of the renderer names
     */
    private $nameList;

    /**
     * @var : List of the renderer objects
     */
    private $rendererList;

    /**
     * Constructor : load the renderers
     * @param string : list of the renderer
     * @param string : base_path
     */
    public function __construct($renderers, $base_path)
    {
        $rendererList = explode(',', $renderers);

        $this->nameList = array();
        $this->rendererList = array();

        //let's load the renderer dynamically
        foreach ($rendererList as $renderer) {
            $this->nameList[] = $renderer;
            if (in_array($renderer, array(
                self::DOCUMENTATION_RENDERER,
                self::REPORT_RENDERER,
                self::TESTRAIL_RENDERER
            ))) {
                $className = __NAMESPACE__ . '\\' . $renderer . 'Renderer';
            } else {
                $className = $renderer;
            }
            $this->rendererList[$renderer] = new $className();
        }
    }

    /**
     * Return the list of the name of the renderers
     * @return array
     */
    public function getNameList(): array
    {
        return $this->nameList;
    }

    /**
     * Renders before an exercice.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderBeforeExercise($obj): array
    {

        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderBeforeExercise($obj);
        }

        return $print;
    }

    /**
     * Renders after an exercice.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderAfterExercise($obj): array
    {
        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderAfterExercise($obj);
        }

        return $print;
    }

    /**
     * Renders before a suite.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderBeforeSuite($obj): array
    {
        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderBeforeSuite($obj);
        }

        return $print;
    }

    /**
     * Renders after a suite.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderAfterSuite($obj): array
    {
        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderAfterSuite($obj);
        }

        return $print;
    }

    /**
     * Renders before a feature.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderBeforeFeature($obj): array
    {
        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderBeforeFeature($obj);
        }

        return $print;
    }

    /**
     * Renders after a feature.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderAfterFeature($obj): array
    {
        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderAfterFeature($obj);
        }

        return $print;
    }

    /**
     * Renders before a scenario.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderBeforeScenario($obj): array
    {
        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderBeforeScenario($obj);
        }

        return $print;
    }

    /**
     * Renders after a scenario.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderAfterScenario($obj): array
    {
        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderAfterScenario($obj);
        }

        return $print;
    }

    /**
     * Renders before an outline.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderBeforeOutline($obj): array
    {
        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderBeforeOutline($obj);
        }

        return $print;
    }

    /**
     * Renders after an outline.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderAfterOutline($obj): array
    {
        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderAfterOutline($obj);
        }

        return $print;
    }

    /**
     * Renders before a step.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderBeforeStep($obj): array
    {
        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderBeforeStep($obj);
        }

        return $print;
    }

    /**
     * Renders after a step.
     * @param object : object
     * @return string|array  : HTML generated
     */
    public function renderAfterStep($obj): array
    {
        $print = array();
        foreach ($this->rendererList as $name => $renderer) {
            $print[$name] = $renderer->renderAfterStep($obj);
        }

        return $print;
    }
}
