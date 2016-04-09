<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Fabian Keller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace ArchInspec\Command;

use ArchInspec\Application\AIConfig;
use ArchInspec\Application\ArchInspec;
use PhpDA\Command\MessageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InspectCommand extends Command
{
    const EXIT_SUCCESS = 0, EXIT_VIOLATION = 1;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $defaultConfig = __DIR__ . '/../../../archinspec.yml.dist';
        $this->addArgument('config', InputArgument::OPTIONAL, MessageInterface::ARGUMENT_CONFIG, $defaultConfig);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = $input->getArgument('config');

        $output->writeln($this->getDescription() . PHP_EOL);
        $output->writeln(MessageInterface::READ_CONFIG_FROM . $configFile . PHP_EOL);

        $config = AIConfig::fromYamlFile($configFile);
        $archInspec = new ArchInspec($config);
        if ($archInspec->analyze()) {
            return self::EXIT_SUCCESS;
        } else {
            return self::EXIT_VIOLATION;
        }
    }


}