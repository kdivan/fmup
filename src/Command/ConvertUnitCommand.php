<?php

namespace App\Command;

use App\Model\Unit;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\InvalidArgumentException;
use Symfony\Component\Console\Style\SymfonyStyle;


/**
 * Class ConvertUnitCommand
 *
 * @package App\Command
 */
class ConvertUnitCommand extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:convert:unit')
            ->addOption('from', null, InputOption::VALUE_REQUIRED, 'from')
            ->addOption('to', null, InputOption::VALUE_REQUIRED, 'to')
            ->setDescription('Dump unit convert factor')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        if ($input->getOption('from') && $input->getOption('to')) {
           $from = $input->getOption('from');
            $to = $input->getOption('to');
        } else {
            throw new InvalidArgumentException('No option found');
        }

        $g = new Unit('g', null, null);
        $caf = new Unit('caf', 5, $g);
        $cs = new Unit('cs', 4, $caf);
        $kg = new Unit('kg', 1000, $g);
        $pce = new Unit('pce', 3, $kg);
        $l8pce = new Unit('l8pce', 8, $pce);
        $l6pce = new Unit('l6pce', 6, $pce);
        $l4pce = new Unit('l4pce', 4, $pce);
        $l3pce = new Unit('l3pce', 3, $pce);

        $fromUnitChain = $this->getUnitChain(${$from});
        $toUnitChain = $this->getUnitChain(${$to});
        $firstCommonUnit = current(array_intersect($fromUnitChain, $toUnitChain));

        $fromValue = 1;
        foreach ($fromUnitChain as $unitName) {
            if ($unitName === $firstCommonUnit) {
                break;
            }
            if (${$unitName}->getQuantity()) {
                $fromValue = $fromValue * ${$unitName}->getQuantity();
            }
        }

        $toValue = 1;
        foreach ($toUnitChain as $unitName) {
            if ($unitName === $firstCommonUnit) {
                break;
            }
            if (${$unitName}->getQuantity()) {
                $toValue = $toValue * ${$unitName}->getQuantity();
            }
        }

        $style->success($fromValue/$toValue);
    }

    /**
     * @param Unit  $unit
     * @param array $unitChain
     *
     * @return array
     */
    private function getUnitChain(Unit $unit, $unitChain = [])
    {
        /** @var Unit */
        $unitChain[] = $unit->getName();
        if ($unit->getReferenceUnit()) {
            return $this->getUnitChain($unit->getReferenceUnit(), $unitChain);
        }

        return $unitChain;
    }
}