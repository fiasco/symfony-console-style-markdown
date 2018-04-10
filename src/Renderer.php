<?php

namespace Fiasco\SymfonyConsoleStyleMarkdown;

class Renderer {

  protected $markdown;

  protected $pointer = 0;

  public function __construct(array $markdown_lines)
  {
    $this->markdown = $markdown_lines;
  }

  public static function createFromMarkdown($markdown)
  {
    return new static(explode(PHP_EOL, $markdown));
  }

  public function __toString()
  {
    $render = $this->markdown;

    for ($this->pointer = 0; $this->pointer < count($render); $this->pointer++) {
      $line = &$render[$this->pointer];
      if ($this->isTitle($line)) {
        $line = $this->renderTitle($line);
      }
      elseif ($this->isCodeBlock($line)) {
        $this->renderCodeBlock($render);
      }
      if ($this->hasBold($line)) {
        $line = $this->renderBold($line);
      }
    }

    return implode(PHP_EOL, $render);
  }

  public function isTitle($line)
  {
    return preg_match('/^#+.+$/', $line);
  }

  public function renderTitle($line)
  {
    return '<options=bold;fg=yellow>' . $line . '</>';
  }

  public function isCodeBlock($line)
  {
    return preg_match('/^```/', $line);
  }

  public function renderCodeBlock(array &$markdown)
  {
    do {
      $markdown[$this->pointer] = '<fg=cyan>' . $markdown[$this->pointer] . '</>';
      $this->pointer++;
    }
    while (isset($markdown[$this->pointer]) && !$this->isCodeBlock($markdown[$this->pointer]));
    $markdown[$this->pointer] = '<fg=cyan>' . $markdown[$this->pointer] . '</>';
  }

  public function hasBold($line)
  {
    return preg_match('/\*\*(.+)\*\*/', $line);
  }

  public function renderBold($line)
  {
    return preg_replace('/\*\*(.+)\*\*/', '<options=bold>$1</>', $line);
  }
}


 ?>
