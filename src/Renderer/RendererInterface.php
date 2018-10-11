<?php
/**
 * Created by PhpStorm.
 * User: Vasileios Poulios (v.poulios@cubility.gr)
 * Date: 12/08/15
 * Time: 10:45
 */

namespace App\Renderer;

use App\Formatter\CustomFormatter;

interface RendererInterface
{

    /**
     * Renders before an exercice.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeExercise(CustomFormatter $obj): string;

    /**
     * Renders after an exercice.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterExercise(CustomFormatter $obj): string;

    /**
     * Renders before a suite.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeSuite(CustomFormatter $obj): string;

    /**
     * Renders after a suite.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterSuite(CustomFormatter $obj): string;

    /**
     * Renders before a feature.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeFeature(CustomFormatter $obj): string;

    /**
     * Renders after a feature.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterFeature(CustomFormatter $obj): string;

    /**
     * Renders before a scenario.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeScenario(CustomFormatter $obj): string;

    /**
     * Renders after a scenario.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterScenario(CustomFormatter $obj): string;

    /**
     * Renders before an outline.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeOutline(CustomFormatter $obj): string;

    /**
     * Renders after an outline.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterOutline(CustomFormatter $obj): string;

    /**
     * Renders before a step.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderBeforeStep(CustomFormatter $obj): string;

    /**
     * Renders after a step.
     * @param CustomFormatter $obj
     * @return string  : HTML generated
     */
    public function renderAfterStep(CustomFormatter $obj): string;

    /**
     * To include CSS
     * @return string  : HTML generated
     */
    public function getCSS(): string;

    /**
     * To include JS
     * @return string  : HTML generated
     */
    public function getJS(): string;
}
