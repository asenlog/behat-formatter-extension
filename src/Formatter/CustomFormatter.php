<?php
/**
 * Created by PhpStorm.
 * User: Vasileios Poulios (v.poulios@cubility.gr)
 * Date: 05/04/18
 * Time: 12:50
 */

namespace App\Formatter;

use Behat\Behat\EventDispatcher\Event\AfterFeatureTested;
use Behat\Behat\EventDispatcher\Event\AfterOutlineTested;
use Behat\Behat\EventDispatcher\Event\AfterScenarioTested;
use Behat\Behat\EventDispatcher\Event\AfterStepTested;
use Behat\Behat\EventDispatcher\Event\BeforeFeatureTested;
use Behat\Behat\EventDispatcher\Event\BeforeOutlineTested;
use Behat\Behat\EventDispatcher\Event\BeforeScenarioTested;
use Behat\Behat\EventDispatcher\Event\BeforeStepTested;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Tester\Result\ExecutedStepResult;
use Behat\Behat\Tester\Result\StepResult;
use Behat\Testwork\Counter\Memory;
use Behat\Testwork\Counter\Timer;
use Behat\Testwork\EventDispatcher\Event\AfterExerciseCompleted;
use Behat\Testwork\EventDispatcher\Event\AfterSuiteTested;
use Behat\Testwork\EventDispatcher\Event\BeforeExerciseCompleted;
use Behat\Testwork\EventDispatcher\Event\BeforeSuiteTested;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Output\Printer\OutputPrinter;
use App\Models\Feature;
use App\Models\Scenario;
use App\Models\Step;
use App\Models\Suite;
use App\Printer\FileOutputPrinter;
use App\Renderer\BaseRenderer;

/**
 * Class CustomFormatter
 * @package tests\features\formatter
 */
class CustomFormatter implements Formatter
{

    /**
     * The html output path
     *
     * @var string
     */
    private static $outputPath;

    /**
     * The screenshot full path
     *
     * @var string
     */
    private static $screenshotFullPath;

    /**
     * The screenshot relative path
     *
     * @var string
     */
    private static $screenshotRelativePath;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $timer;

    /**
     * @var
     */
    private $memory;

    /**
     * @param String $base_path Behat base path
     */
    private $base_path;

    /**
     * Printer used by this Formatter
     * @param $printer OutputPrinter
     */
    private $printer;

    /**
     * Renderer used by this Formatter
     * @param $renderer BaseRenderer
     */
    private $renderer;

    /**
     * Flag used by this Formatter
     * @param $print_args boolean
     */
    private $print_args;

    /**
     * Flag used by this Formatter
     * @param $print_outp boolean
     */
    private $print_outp;

    /**
     * Flag used by this Formatter
     * @param $loop_break boolean
     */
    private $loop_break;

    /**
     * Screenshot Support for your test using selenium
     *
     * @var boolean
     */
    private $screenshot_support = false;

    /**
     * The arguments passed to the behat cli
     *
     * @var array
     */
    private $cli_args;

    /**
     * @var array
     */
    private $suites;

    /**
     * @var Suite
     */
    private $currentSuite;

    /**
     * @var int
     */
    private $featureCounter = 1;

    /**
     * @var Feature
     */
    private $currentFeature;

    /**
     * @var Scenario
     */
    private $currentScenario;

    /**
     * @var Scenario[]
     */
    private $failedScenarios;

    /**
     * @var Scenario[]
     */
    private $pendingScenarios;

    /**
     * @var Scenario[]
     */
    private $passedScenarios;

    /**
     * @var Feature[]
     */
    private $failedFeatures;

    /**
     * @var Feature[]
     */
    private $pendingFeatures;

    /**
     * @var Feature[]
     */
    private $passedFeatures;

    /**
     * @var Step[]
     */
    private $failedSteps;

    /**
     * @var Step[]
     */
    private $passedSteps;

    /**
     * @var Step[]
     */
    private $pendingSteps;

    /**
     * @var Step[]
     */
    private $skippedSteps;

    /**
     * CustomFormatter constructor.
     * @param $name
     * @param $renderers
     * @param $filenames
     * @param $print_args
     * @param $print_outp
     * @param $loop_break
     * @param $base_path
     * @param $screenshot_support
     * @param $cli_args
     */
    public function __construct(
        $name,
        $renderers,
        $filenames,
        $print_args,
        $print_outp,
        $loop_break,
        $base_path,
        $screenshot_support,
        $cli_args
    ) {
        $this->name = $name;
        $this->base_path = $base_path;
        $this->print_args = $print_args;
        $this->print_outp = $print_outp;
        $this->loop_break = $loop_break;
        $this->renderer = new BaseRenderer($renderers, $base_path);
        $this->printer = new FileOutputPrinter($this->renderer->getNameList(), $filenames, $base_path);
        $this->timer = new Timer();
        $this->memory = new Memory();
        $this->screenshot_support = $screenshot_support;
        $this->cli_args = $cli_args;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            'tester.exercise_completed.before' => 'onBeforeExercise',
            'tester.exercise_completed.after' => 'onAfterExercise',
            'tester.suite_tested.before' => 'onBeforeSuiteTested',
            'tester.suite_tested.after' => 'onAfterSuiteTested',
            'tester.feature_tested.before' => 'onBeforeFeatureTested',
            'tester.feature_tested.after' => 'onAfterFeatureTested',
            'tester.scenario_tested.before' => 'onBeforeScenarioTested',
            'tester.scenario_tested.after' => 'onAfterScenarioTested',
            'tester.outline_tested.before' => 'onBeforeOutlineTested',
            'tester.outline_tested.after' => 'onAfterOutlineTested',
            'tester.step_tested.after' => 'onAfterStepTested',
        );
    }

    /**
     * Returns formatter name.
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->base_path;
    }

    /**
     * Returns formatter description.
     * @return string
     */
    public function getDescription(): string
    {
        return "Formatter for CI";
    }

    /**
     * Returns formatter output printer.
     * @return OutputPrinter
     */
    public function getOutputPrinter(): object
    {
        return $this->printer;
    }

    /**
     * Sets formatter parameter.
     * @param string $name
     * @param mixed $value
     */
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * Returns parameter name.
     * @param string $name
     * @return mixed
     */
    public function getParameter($name): string
    {
        return $this->parameters[$name];
    }

    /**
     * Returns output path
     * @return String output path
     */
    public function getOutputPath(): string
    {
        return $this->printer->getOutputPath();
    }

    /**
     * Returns if it should print the step arguments
     * @return boolean
     */
    public function getPrintArguments(): bool
    {
        return $this->print_args;
    }

    /**
     * Returns if it should print the step outputs
     * @return boolean
     */
    public function getPrintOutputs(): bool
    {
        return $this->print_outp;
    }

    /**
     * Returns if it should print scenario loop break
     * @return boolean
     */
    public function getPrintLoopBreak(): bool
    {
        return $this->loop_break;
    }

    /**
     * Returns If it should add screenshots support
     * @return bool
     */
    public function getScreenshotSupport(): bool
    {
        return $this->screenshot_support;
    }

    public function getCliArgs()
    {
        return $this->cli_args;
    }

    public function getTimer()
    {
        return $this->timer;
    }

    public function getMemory()
    {
        return $this->memory;
    }

    public function getSuites()
    {
        return $this->suites;
    }

    public function getCurrentSuite()
    {
        return $this->currentSuite;
    }

    public function getFeatureCounter()
    {
        return $this->featureCounter;
    }


    public function getCurrentFeature()
    {
        return $this->currentFeature;
    }

    public function getCurrentScenario()
    {
        return $this->currentScenario;
    }

    public function getFailedScenarios()
    {
        return $this->failedScenarios;
    }

    public function getPendingScenarios()
    {
        return $this->pendingScenarios;
    }

    public function getPassedScenarios()
    {
        return $this->passedScenarios;
    }

    public function getFailedFeatures()
    {
        return $this->failedFeatures;
    }

    public function getPendingFeatures()
    {
        return $this->pendingFeatures;
    }

    public function getPassedFeatures()
    {
        return $this->passedFeatures;
    }

    public function getFailedSteps()
    {
        return $this->failedSteps;
    }

    public function getPassedSteps()
    {
        return $this->passedSteps;
    }

    public function getPendingSteps()
    {
        return $this->pendingSteps;
    }

    public function getSkippedSteps()
    {
        return $this->skippedSteps;
    }

    /**
     * @param BeforeExerciseCompleted $event
     */
    public function onBeforeExercise(BeforeExerciseCompleted $event)
    {
        $this->timer->start();

        $print = $this->renderer->renderBeforeExercise($this);
        $this->printer->write($print);
        self::$outputPath = $this->getOutputPath();
    }

    /**
     * @param AfterExerciseCompleted $event
     */
    public function onAfterExercise(AfterExerciseCompleted $event)
    {
        $this->timer->stop();

        $print = $this->renderer->renderAfterExercise($this);
        $this->printer->writeln($print);
    }

    /**
     * @param BeforeSuiteTested $event
     */
    public function onBeforeSuiteTested(BeforeSuiteTested $event)
    {
        $this->currentSuite = new Suite();
        $this->currentSuite->setName($event->getSuite()->getName());

        $print = $this->renderer->renderBeforeSuite($this);
        $this->printer->writeln($print);
    }

    /**
     * @param AfterSuiteTested $event
     */
    public function onAfterSuiteTested(AfterSuiteTested $event)
    {
        $this->suites[] = $this->currentSuite;

        $print = $this->renderer->renderAfterSuite($this);
        $this->printer->writeln($print);
    }

    /**
     * @param BeforeFeatureTested $event
     */
    public function onBeforeFeatureTested(BeforeFeatureTested $event)
    {
        $feature = new Feature();
        $feature->setId($this->featureCounter);
        $this->featureCounter++;
        $feature->setTitle($event->getFeature()->getTitle());
        $feature->setLine($event->getFeature()->getLine());
        $feature->setDescription($event->getFeature()->getDescription());
        $feature->setTags($event->getFeature()->getTags());
        $this->currentFeature = $feature;

        $print = $this->renderer->renderBeforeFeature($this);
        $this->printer->writeln($print);
    }

    /**
     * @param AfterFeatureTested $event
     */
    public function onAfterFeatureTested(AfterFeatureTested $event)
    {
        $this->currentSuite->addFeature($this->currentFeature);
        if ($this->currentFeature->allPassed()) {
            $this->passedFeatures[] = $this->currentFeature;
        } elseif ($this->currentFeature->getPendingScenarios() > 0) {
            $this->pendingFeatures[] = $this->currentFeature;
        } else {
            $this->failedFeatures[] = $this->currentFeature;
        }

        $print = $this->renderer->renderAfterFeature($this);
        $this->printer->writeln($print);
    }

    /**
     * @param BeforeScenarioTested $event
     */
    public function onBeforeScenarioTested(BeforeScenarioTested $event)
    {
        $scenario = new Scenario();
        $scenario->setTitle($event->getScenario()->getTitle());
        $scenario->setTags($event->getScenario()->getTags());
        $scenario->setLine($event->getScenario()->getLine());

        $this->currentScenario = $scenario;

        $print = $this->renderer->renderBeforeScenario($this);
        $this->printer->writeln($print);
    }

    /**
     * @param AfterScenarioTested $event
     */
    public function onAfterScenarioTested(AfterScenarioTested $event)
    {
        $scenarioPassed = $event->getTestResult()->isPassed();

        if ($scenarioPassed) {
            $this->passedScenarios[] = $this->currentScenario;
            $this->currentFeature->addPassedScenario();
            $this->currentScenario->setPassed(true);
        } elseif ($event->getTestResult()->getResultCode() == StepResult::PENDING) {
            $this->pendingScenarios[] = $this->currentScenario;
            $this->currentFeature->addPendingScenario();
            $this->currentScenario->setPending(true);
        } else {
            $this->failedScenarios[] = $this->currentScenario;
            $this->currentFeature->addFailedScenario();
            $this->currentScenario->setPassed(false);
            $this->currentScenario->setPending(false);
        }

        $this->currentScenario->setLoopCount(1);
        $this->currentFeature->addScenario($this->currentScenario);

        $print = $this->renderer->renderAfterScenario($this);
        $this->printer->writeln($print);
    }

    /**
     * @param BeforeOutlineTested $event
     */
    public function onBeforeOutlineTested(BeforeOutlineTested $event)
    {
        $scenario = new Scenario();
        $scenario->setTitle($event->getOutline()->getTitle());
        $scenario->setTags($event->getOutline()->getTags());
        $scenario->setLine($event->getOutline()->getLine());
        $this->currentScenario = $scenario;

        $print = $this->renderer->renderBeforeOutline($this);
        $this->printer->writeln($print);
    }

    /**
     * @param AfterOutlineTested $event
     */
    public function onAfterOutlineTested(AfterOutlineTested $event)
    {
        $scenarioPassed = $event->getTestResult()->isPassed();

        if ($scenarioPassed) {
            $this->passedScenarios[] = $this->currentScenario;
            $this->currentFeature->addPassedScenario();
            $this->currentScenario->setPassed(true);
        } elseif ($event->getTestResult()->getResultCode() == StepResult::PENDING) {
            $this->pendingScenarios[] = $this->currentScenario;
            $this->currentFeature->addPendingScenario();
            $this->currentScenario->setPending(true);
        } else {
            $this->failedScenarios[] = $this->currentScenario;
            $this->currentFeature->addFailedScenario();
            $this->currentScenario->setPassed(false);
            $this->currentScenario->setPending(false);
        }

        $this->currentScenario->setLoopCount(sizeof($event->getTestResult()));
        $this->currentFeature->addScenario($this->currentScenario);

        $print = $this->renderer->renderAfterOutline($this);
        $this->printer->writeln($print);
    }

    /**
     * @param BeforeStepTested $event
     */
    public function onBeforeStepTested(BeforeStepTested $event)
    {
        $print = $this->renderer->renderBeforeStep($this);
        $this->printer->writeln($print);
    }

    /**
     * @param AfterStepTested $event
     */
    public function onAfterStepTested(AfterStepTested $event)
    {
        $result = $event->getTestResult();

        /** @var Step $step */
        $step = new Step();
        $step->setKeyword($event->getStep()->getKeyword());
        $step->setText($event->getStep()->getText());
        $step->setLine($event->getStep()->getLine());
        $step->setResult($result);
        $step->setResultCode($result->getResultCode());
        $step->setScreenshotSupport($this->screenshot_support);

        if ($event->getStep()->hasArguments()) {
            $object = $this->getObject($event->getStep()->getArguments());
            $step->setArgumentType($object->getNodeType());
            $step->setArguments($object);
        }

        if ($this->screenshot_support && self::$outputPath && self::$screenshotFullPath) {
            // Set screenshot path in step
            if (file_exists(self::$screenshotFullPath)) {
                $step->setScreenshot(self::$screenshotRelativePath);
            }
        }

        //What is the result of this step ?
        if (is_a($result, 'Behat\Behat\Tester\Result\UndefinedStepResult')) {
            //pending step -> no definition to load
            $this->pendingSteps[] = $step;
        } else {
            if (is_a($result, 'Behat\Behat\Tester\Result\SkippedStepResult')) {
                //skipped step
                /** @var ExecutedStepResult $result */
                $step->setDefinition($result->getStepDefinition());
                $this->skippedSteps[] = $step;
            } else {
                //failed or passed
                if ($result instanceof ExecutedStepResult) {
                    $step->setDefinition($result->getStepDefinition());
                    $exception = $result->getException();
                    if ($exception) {
                        if ($exception instanceof PendingException) {
                            $this->pendingSteps[] = $step;
                        } else {
                            $step->setException($exception->getMessage());
                            $this->failedSteps[] = $step;
                        }
                    } else {
                        $step->setOutput($result->getCallResult()->getStdOut());
                        $this->passedSteps[] = $step;
                    }
                }
            }
        }

        $this->currentScenario->addStep($step);

        $print = $this->renderer->renderAfterStep($this);
        $this->printer->writeln($print);
    }

    /**
     * @param $arguments
     * @return mixed
     */
    public function getObject($arguments)
    {
        foreach ($arguments as $argument => $args) {
            return $args;
        }
    }

    /**
     * Generate path string also created non existing folders
     *
     * @param $suite string
     * @param $feature string
     * @param $scenario string
     * @param $step string
     *
     * @return string
     */
    public static function getScreenshotFullPath($suite, $feature, $scenario, $step)
    {
        $dir = self::$outputPath . '/screenshots/'
            . self::convertToCamelcase($suite)
            . DIRECTORY_SEPARATOR
            . self::convertToCamelcase($feature)
            . DIRECTORY_SEPARATOR
            . self::convertToCamelcase($scenario);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        self::$screenshotFullPath = $dir . DIRECTORY_SEPARATOR . self::convertToCamelcase($step) . '.png';
        self::$screenshotRelativePath = str_replace(
            self::$outputPath,
            '..',
            self::$screenshotFullPath
        );
        return self::$screenshotFullPath;
    }

    /**
     * Convert any string to camelcase convension with no spaces
     *
     * @param $string
     * @return mixed
     */
    public static function convertToCamelcase($string)
    {
        return preg_replace('/\W/', '', ucwords($string));
    }
}
