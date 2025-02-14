<?php

use Latte\Runtime as LR;

/** source: Resources\html\@layout.latte */
final class Template_947481349a extends Latte\Runtime\Template
{
	public const Source = 'Resources\\html\\@layout.latte';

	public const Blocks = [
		['title' => 'blockTitle', 'content' => 'blockContent'],
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
		echo ' - Patrigios Market Analytics</title>    
		<link rel="icon" type="image/x-icon" href="Resources/assets/logos/favicon.ico">
	</head>

	<body>
';
		$this->createTemplate('header.latte', $this->params, 'include')->renderToContentType('html') /* line 11 */;
		echo '
		<main class="content-wrap">
            <div class="max-width-layout">
';
		$this->renderBlock('content', get_defined_vars()) /* line 15 */;
		echo '            </div>
		</main>

		<footer class="footer-wrap">
            <div class="max-width-layout">
';
		$this->createTemplate('footer.latte', $this->params, 'include')->renderToContentType('html') /* line 21 */;
		echo '            </div>
		</footer>
        <script type="module" src="/Resources/js/main.js"></script>
	</body>
</html>';
	}


	/** {block title|stripHtml|trim} on line 6 */
	public function blockTitle(array $ʟ_args): void
	{
	}


	/** {block content} on line 15 */
	public function blockContent(array $ʟ_args): void
	{
	}
}
