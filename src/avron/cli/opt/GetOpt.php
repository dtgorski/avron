<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use ArrayIterator;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class GetOpt
{
    private static string $errGetOptMadeABooBoo = "unsupported argument order";
    private static string $errOptionNoArguments = "option '%s' does not support arguments";
    private static string $errOptionReqArgument = "option '%s' requires an argument";
    private static string $errUnsupportedCommand = "unsupported command '%s'";
    private static string $errUnsupportedOption = "unsupported option '%s'";

    /**
     * @param string[] $argv
     * @param Options $options
     * @param Commands $commands
     */
    public function __construct(
        private readonly array $argv,
        private readonly Options $options,
        private readonly Commands $commands
    ) {
    }

    /** @throws Exception */
    public function createParameters(): Parameters
    {
        $arguments = $this->orderArguments(array_slice($this->argv, 1));

        /** @var ArrayIterator<int,Argument> $it */
        $it = new ArrayIterator($arguments);

        $options = $this->readOptions($it, $this->options);
        $command = $this->readCommand($it, $this->commands);
        $operands = $this->readOperands($it);

        return Parameters::fromParams($options, $command, $operands);
    }

    /**
     * @param ArrayIterator<int,Argument> $it
     * @param Options $options
     * @return Options
     * @throws Exception
     */
    private function readOptions(ArrayIterator $it, Options $options): Options
    {
        $opts = [];
        while (($arg = $it->current()) && $arg->isOption()) {

            // Argument is not a supported option?
            if (!$opt = $options->getByName($arg->getValue())) {
                throw new Exception(sprintf(self::$errUnsupportedOption, $arg->getValue()));
            }

            // Option is standalone? Must not have any value assigned via "=" (preset).
            if ($opt->get(Option::OPT_MODE) == Option::MODE_ARG_NONE) {
                if ($arg->getPreset()) {
                    throw new Exception(sprintf(self::$errOptionNoArguments, $arg->getValue()));
                }
                $opts[] = $opt;
                $it->next();
                continue;
            }

            // Option needs one operand. Either it's assigned via "=" or it's the next in stream.
            if ($opt->get(Option::OPT_MODE) == Option::MODE_ARG_SINGLE) {
                if ($arg->getPreset()) {
                    $opts[] = Option::fromOption($opt, [Option::OPT_VALUE => $arg->getPreset()]);
                    $it->next();
                    continue;
                }
                $it->next();
                if (!($op = $it->current()) || $op->getType() == Argument::OPERAND) {
                    $opts[] = Option::fromOption($opt, [Option::OPT_VALUE => $op->getValue()]);
                    $it->next();
                    continue;
                }
                throw new Exception(sprintf(self::$errOptionReqArgument, $arg->getValue()));
            }
            throw new Exception(self::$errGetOptMadeABooBoo);
        }
        return Options::fromArray($opts);
    }

    /**
     * @param ArrayIterator<int,Argument> $it
     * @param Commands $commands
     * @return ?Command
     * @throws Exception
     */
    private function readCommand(ArrayIterator $it, Commands $commands): ?Command
    {
        if ($commands->size() == 0) {
            return null;
        }
        if (!($arg = $it->current()) || !$arg->isOperand()) {
            return null;
        }
        if (!$cmd = $commands->getByName($arg->getValue())) {
            throw new Exception(sprintf(self::$errUnsupportedCommand, $arg->getValue()));
        }
        $it->next();

        return Command::fromParams(
            $cmd->getName(),
            $cmd->getUsageArgs(),
            $cmd->getDescription(),
            $this->readOptions($it, $cmd->getOptions()),
            $cmd->getHandler(),
        );
    }

    /**
     * @param ArrayIterator<int,Argument> $it
     * @return Operands|null
     */
    private function readOperands(ArrayIterator $it): ?Operands
    {
        return null;
    }

    /**
     * Put arguments into a more processable form.
     *
     * @param string[] $array
     * @return Argument[]
     */
    private function orderArguments(array $array): array
    {
        $args = [];
        $rest = false;

        foreach ($array as $arg) {
            if ($rest) {
                $args[] = Argument::fromOperand($arg);
                continue;
            }
            if ($arg == "--") {
                $rest = true;
                continue;
            }

            // --foo-option[=bar], consume if pattern matches.
            if (preg_match("/^--([a-z0-9]+[a-z0-9-]*[a-z0-9])(=\S*)?$/iS", $arg, $m)) {
                $value = $m[1];
                $preset = isset($m[2]) ? substr($m[2], 1) : null;
                $args[] = Argument::fromOption($value, $preset);
                continue;
            }

            // -fLAGs[=bar], split into individual flags, last gets value.
            if (preg_match("/^-([a-z0-9]+)(=\S*)?$/iS", $arg, $m)) {
                $values = str_split($m[1]);
                $preset = isset($m[2]) ? substr($m[2], 1) : null;

                for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
                    $args[] = Argument::fromOption($values[$i], ($i === $n - 1) ? $preset : null);
                }
                continue;
            }

            // Option argument, rest operand or broken.
            $args[] = Argument::fromOperand($arg);
        }
        return $args;
    }
}
