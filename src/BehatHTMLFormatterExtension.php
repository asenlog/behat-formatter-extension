<?php

namespace BehatHTMLFormatter;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class BehatHTMLFormatterExtension
 * @package Features\Formatter
 */
class BehatHTMLFormatterExtension implements ExtensionInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
    }

    /**
     * Returns the extension config key.
     *
     * @return string
     */
    public function getConfigKey()
    {
        return "behatreporting";
    }

    /**
     * Initializes other extensions.
     *
     * This method is called immediately after all extensions are activated but
     * before any extension `configure()` method is called. This allows extensions
     * to hook into the configuration of other extensions providing such an
     * extension point.
     *
     * @param ExtensionManager $extensionManager
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * Setups configuration for the extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder->children()->scalarNode("name")->defaultValue("behathtml");
        $builder->children()->scalarNode("renderer")->defaultValue("Report");
        $builder->children()->scalarNode("file_names")->defaultValue("Report");
        $builder->children()->scalarNode("print_args")->defaultValue("false");
        $builder->children()->scalarNode("print_outp")->defaultValue("false");
        $builder->children()->scalarNode("loop_break")->defaultValue("false");
        $builder->children()->scalarNode("screenshot_support")->defaultValue("false");
    }

    /**
     * Loads extension services into temporary container.
     *
     * @param ContainerBuilder $container
     * @param array $config
     *
     * @throws \Exception
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $definition = new Definition("BehatHTMLFormatter\\Formatter\\BehatHTMLFormatter");
        $definition->addArgument($config['name']);
        $definition->addArgument($config['renderer']);
        $definition->addArgument($config['file_names']);
        $definition->addArgument($config['print_args']);
        $definition->addArgument($config['print_outp']);
        $definition->addArgument($config['loop_break']);
        $definition->addArgument('%paths.base%');
        $definition->addArgument($config['screenshot_support']);
        $container
            ->setDefinition("html.formatter", $definition)
            ->addTag("output.formatter");
        $definition->addArgument($this->getCliArgs($container));
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return array
     * @throws \Exception
     */
    private function getCliArgs(ContainerBuilder $container)
    {
        $keyValues = array();
        $cliInput = $container->get('cli.input')->__toString();
        $args = explode(' ', $cliInput);
        foreach ($args as $arg) {
            $arg = trim($arg);
            if (strstr($arg, '=')) {
                $parts = explode('=', $arg);
                $key = str_replace('--', "", $parts[0]);
                $key = ucfirst($key);
                $value = str_replace("'", "", $parts[1]);
                if (strstr($value, ',')) {
                    $value = explode(',', $value);
                }
                $keyValues[$key] = $value;
            }
        }
        return (!empty($keyValues)) ? $keyValues : null;
    }

}
