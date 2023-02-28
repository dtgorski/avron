<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\CLI;

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
     * @param ?Options $options
     * @param ?Commands $commands
     */
    public function __construct(
        private readonly array $argv,
        private readonly ?Options $options,
        private readonly ?Commands $commands
    ) {
    }

    /** @throws ArgumentException */
    public function createArguments(): Arguments
    {
        $_ = $this->argv[0];

        $arguments = $this->orderArguments(array_slice($this->argv, 1));

        /** @var ArrayIterator<int,Arg> $it */
        $it = new ArrayIterator($arguments);

        $globals = $this->readOptions($it, $this->options);
        $command = $this->readCommand($it, $this->commands);
        $operands = $this->readOperands($it);

        return Arguments::fromParams($globals, $command, $operands);
    }

    /**
     * @param ArrayIterator<int,Arg> $it
     * @param ?Options $options
     * @return ?Options|null
     * @throws ArgumentException
     */
    private function readOptions(ArrayIterator $it, ?Options $options): ?Options
    {
        if (!$options) {
            return null;
        }

        $opts = [];
        while (($arg = $it->current()) && $arg->isOption()) {

            // Argument is not a supported option?
            if (!$opt = $options->getByName($arg->getValue())) {
                $this->throw(self::$errUnsupportedOption, $arg->getValue());
            }

            // Option is standalone? Must not have any value assigned via "=" (preset).
            if ($opt->get(Option::OPT_MODE) == Option::MODE_ARG_NONE) {
                if ($arg->getPreset()) {
                    $this->throw(self::$errOptionNoArguments, $arg->getValue());
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
                if (!($op = $it->current()) || $op->getType() == ArgType::OPERAND) {
                    $opts[] = Option::fromOption($opt, [Option::OPT_VALUE => $op->getValue()]);
                    $it->next();
                    continue;
                }
                $this->throw(self::$errOptionReqArgument, $arg->getValue());
            }
            $this->throw(self::$errGetOptMadeABooBoo);
        }
        return sizeof($opts) ? Options::fromArray($opts) : null;
    }

    /**
     * @param ArrayIterator<int,Arg> $it
     * @param ?Commands $commands
     * @return ?Command
     * @throws ArgumentException
     */
    private function readCommand(ArrayIterator $it, ?Commands $commands): ?Command
    {
        if (!$commands) {
            return null;
        }
        if (!($arg = $it->current()) || !$arg->isOperand()) {
            return null;
        }
        if (!$cmd = $commands->getByName($arg->getValue())) {
            $this->throw(self::$errUnsupportedCommand, $arg->getValue());
        }
        $it->next();

        return Command::fromParams(
            $cmd->getName(),
            $cmd->getDescription(),
            $cmd->getHandler(),
            $this->readOptions($it, $cmd->getOptions())
        );
    }

    /**
     * @param ArrayIterator<int,Arg> $it
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
     * @return Arg[]
     */
    private function orderArguments(array $array): array
    {
        $args = [];
        $rest = false;

        foreach ($array as $arg) {
            if ($rest) {
                $args[] = Arg::fromOperand($arg);
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
                $args[] = Arg::fromOption($value, $preset);
                continue;
            }

            // -fLAGs[=bar], split into individual flags, last gets value.
            if (preg_match("/^-([a-z0-9]+)(=\S*)?$/iS", $arg, $m)) {
                $values = str_split($m[1]);
                $preset = isset($m[2]) ? substr($m[2], 1) : null;

                for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
                    $args[] = Arg::fromOption($values[$i], ($i === $n - 1) ? $preset : null);
                }
                continue;
            }

            // Option argument, rest operand or broken.
            $args[] = Arg::fromOperand($arg);
        }
        return $args;
    }

    /** @throws ArgumentException */
    private function throw(string $format, string ...$values): void
    {
        throw new ArgumentException(sprintf($format, ...$values));
    }
}
