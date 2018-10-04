<?php
/**
 * Created by PhpStorm.
 * User: Angelos Roussakis (aggelos.roussakis@gmail.com)
 *       Vasileios Poulios (v.poulios@cubility.gr)
 *       Theodoros Temourtzidis (temourtzidis@gmail.com)
 * Date: 05/04/18
 * Time: 12:50
 */

namespace BehatHTMLFormatter\Renderer;

use BehatHTMLFormatter\Formatter\BehatHTMLFormatter;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Twig renderer for Behat report
 *
 * Class TestrailRenderer
 * @package BehatHTMLFormatter\Renderer
 */
class TestrailRenderer
{
    /**
     * Renders before an exercise.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeExercise(BehatHTMLFormatter $obj)
    {
        return '';
    }

    /**
     * Renders after an exercise.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     *
     * @throws \Exception
     */
    public function renderAfterExercise(BehatHTMLFormatter $obj)
    {

        $templatePath = dirname(__FILE__) . '/../../templates';
        $loader = new Twig_Loader_Filesystem($templatePath);
        $twig = new Twig_Environment($loader, array());
        $print = $twig->render(
            'testrail.xml.twig',
            array(
                'cliArgs' => $obj->getCliArgs(),
                'suites' => $obj->getSuites()
            )
        );

        return $print;
    }

    /**
     * Renders before a suite.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeSuite(BehatHTMLFormatter $obj)
    {
        return '';
    }

    /**
     * Renders after a suite.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterSuite(BehatHTMLFormatter $obj)
    {
        return '';
    }

    /**
     * Renders before a feature.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeFeature(BehatHTMLFormatter $obj)
    {
        return '';
    }

    /**
     * Renders after a feature.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterFeature(BehatHTMLFormatter $obj)
    {
        return '';
    }

    /**
     * Renders before a scenario.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeScenario(BehatHTMLFormatter $obj)
    {
        return '';
    }

    /**
     * Renders after a scenario.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterScenario(BehatHTMLFormatter $obj)
    {
        return '';
    }

    /**
     * Renders before an outline.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeOutline(BehatHTMLFormatter $obj)
    {
        return '';
    }

    /**
     * Renders after an outline.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterOutline(BehatHTMLFormatter $obj)
    {
        return '';
    }

    /**
     * Renders before a step.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeStep(BehatHTMLFormatter $obj)
    {
        return '';
    }

    /**
     * Renders after a step.
     *
     * @param BehatHTMLFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterStep(BehatHTMLFormatter $obj)
    {
        return '';
    }

    /**
     * To include CSS
     *
     * @return string  : HTML generated
     */
    public function getCSS()
    {
        return '';
    }

    /**
     * To include JS
     *
     * @return string  : HTML generated
     */
    public function getJS()
    {
        return '';
    }
}
