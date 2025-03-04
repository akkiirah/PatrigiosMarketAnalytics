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

    public function renderLogin(array $params): void
    {
        $this->latte->render($this->fileLogin, $params);

        $output = $this->latte->renderToString($this->fileLogin, $params);
    }
    public function renderRegister(array $params): void
    {
        $this->latte->render($this->fileRegister, $params);

        $output = $this->latte->renderToString($this->fileRegister, $params);
    }
}
