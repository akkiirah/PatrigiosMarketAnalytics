<?php

namespace View;

class LatteViewRenderer extends AbstractViewRenderer
{
    public function renderList(array $params): void
    {
        $this->latte->render($this->fileList, $params);

        $output = $this->latte->renderToString($this->fileList, $params);
    }

    public function renderStart(array $params): void
    {
        $this->latte->render($this->fileStart, $params);

        $output = $this->latte->renderToString($this->fileStart, $params);
    }

    public function renderDetail(array $params): void
    {
        $this->latte->render($this->fileDetail, $params);

        $output = $this->latte->renderToString($this->fileDetail, $params);
    }
}