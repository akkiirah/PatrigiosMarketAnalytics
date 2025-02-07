<?php

use Latte\Runtime as LR;

/** source: Resources\html\@layout.latte */
final class Template_23e1166897 extends Latte\Runtime\Template
{
	public const Source = 'Resources\\html\\@layout.latte';

	public const Blocks = [
		['title' => 'blockTitle', 'header' => 'blockHeader', 'content' => 'blockContent', 'footer' => 'blockFooter'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '
<!DOCTYPE html>
<html>
	<head>
        <link rel="stylesheet" href="/Resources/css/main.css" />
        <title>';
		$this->renderBlock('title', get_defined_vars(), function ($s, $type) {
			$ʟ_fi = new LR\FilterInfo($type);
			return LR\Filters::convertTo($ʟ_fi, 'html', $this->filters->filterContent('trim', $ʟ_fi, $this->filters->filterContent('stripHtml', $ʟ_fi, $s)));
		}) /* line 6 */;
		echo ' - My Webpage</title>    
	</head>

	<body>
        <header class="header-wrap">
            <div class="max-width-layout">
';
		$this->renderBlock('header', get_defined_vars()) /* line 12 */;
		echo '            </div>
        </header>

		<main class="content-wrap">
            <div class="max-width-layout">
';
		$this->renderBlock('content', get_defined_vars()) /* line 18 */;
		echo '            </div>
		</main>

		<footer class="footer-wrap">
            <div class="max-width-layout">
';
		$this->renderBlock('footer', get_defined_vars()) /* line 24 */;
		echo '            </div>
		</footer>
        <script src="/Resources/js/main.js"></script>
	</body>
</html>';
	}


	/** {block title|stripHtml|trim} on line 6 */
	public function blockTitle(array $ʟ_args): void
	{
	}


	/** {block header} on line 12 */
	public function blockHeader(array $ʟ_args): void
	{
	}


	/** {block content} on line 18 */
	public function blockContent(array $ʟ_args): void
	{
	}


	/** {block footer} on line 24 */
	public function blockFooter(array $ʟ_args): void
	{
	}
}
