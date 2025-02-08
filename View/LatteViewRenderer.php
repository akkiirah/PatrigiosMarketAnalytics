<?php

namespace View;

class LatteViewRenderer extends AbstractViewRenderer
{
    public function renderItem(array $params): void
    {
        $this->latte->render($this->fileName, $params);

        $output = $this->latte->renderToString($this->fileName, $params);
    }
}