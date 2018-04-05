<?php

namespace Symfony\Component\Console\Style\Fiasco;

use Symfony\Component\Console\Style\SymfonyStyle;

class MarkdownStyle extends SymfonyStyle {

  /**
     * {@inheritdoc}
     */
    public function title($message)
    {
        $this->autoPrependBlock();
        $this->writeln(array(
            sprintf('<comment># %s</>', OutputFormatter::escapeTrailingBackslash($message)),
        ));
        $this->newLine();
    }
}


 ?>
