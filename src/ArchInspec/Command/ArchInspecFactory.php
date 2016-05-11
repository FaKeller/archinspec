<?php
/**
 * This file is part of the "archinspec" project.
 *
 * (c) Fabian Keller <hello@fabian-keller.de>
 *
 * For the full copyright and license information, please view the LICENSE 
 * file that was distributed with this source code.
 */

namespace ArchInspec\Command;

use Symfony\Component\Console\Application;

class ArchInspecFactory
{
    /**
     * @return Application
     */
    public function create()
    {
        $app = new Application(CliMessage::NAME, CliMessage::VERSION);
        $app->setDefaultCommand(CliMessage::COMMAND);
        $app->add($this->createInspectCommand());

        return $app;
    }

    private function createInspectCommand()
    {
        $command = new InspectCommand(CliMessage::COMMAND);

        $command->setHelp(CliMessage::HELP);
        $command->setDescription(CliMessage::NAME . ' (' . CliMessage::VERSION . ')');
        return $command;
    }
}