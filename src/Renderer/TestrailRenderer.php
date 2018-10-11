<?php
/**
 * Created by PhpStorm.
 * User: Angelos Roussakis (aggelos.roussakis@gmail.com)
 *       Vasileios Poulios (v.poulios@cubility.gr)
 *       Theodoros Temourtzidis (temourtzidis@gmail.com)
 * Date: 05/04/18
 * Time: 12:50
 */

namespace App\Renderer;

use App\Formatter\CustomFormatter;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TestrailRenderer implements RendererInterface
{
    /**
     * Renders before an exercise.
     *
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeExercise(CustomFormatter $obj): string
    {
        return '';
    }

    /**
     * Renders after an exercise.
     *
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     *
     * @throws \Exception
     */
    public function renderAfterExercise(CustomFormatter $obj): string
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
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeSuite(CustomFormatter $obj): string
    {
        return '';
    }

    /**
     * Renders after a suite.
     *
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterSuite(CustomFormatter $obj): string
    {
        return '';
    }

    /**
     * Renders before a feature.
     *
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeFeature(CustomFormatter $obj): string
    {
        return '';
    }

    /**
     * Renders after a feature.
     *
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterFeature(CustomFormatter $obj): string
    {
        return '';
    }

    /**
     * Renders before a scenario.
     *
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeScenario(CustomFormatter $obj): string
    {
        return '';
    }

    /**
     * Renders after a scenario.
     *
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterScenario(CustomFormatter $obj): string
    {
        return '';
    }

    /**
     * Renders before an outline.
     *
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeOutline(CustomFormatter $obj): string
    {
        return '';
    }

    /**
     * Renders after an outline.
     *
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterOutline(CustomFormatter $obj): string
    {
        return '';
    }

    /**
     * Renders before a step.
     *
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeStep(CustomFormatter $obj): string
    {
        return '';
    }

    /**
     * Renders after a step.
     *
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterStep(CustomFormatter $obj): string
    {
        return '';
    }

    /**
     * To include CSS
     *
     * @return string  : HTML generated
     */
    public function getCSS(): string
    {
        return '';
    }

    /**
     * To include JS
     *
     * @return string  : HTML generated
     */
    public function getJS(): string
    {
        return '';
    }
}
