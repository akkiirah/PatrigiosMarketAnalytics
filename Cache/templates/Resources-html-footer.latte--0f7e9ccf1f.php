<?php

use Latte\Runtime as LR;

/** source: Resources\html\footer.latte */
final class Template_0f7e9ccf1f extends Latte\Runtime\Template
{
	public const Source = 'Resources\\html\\footer.latte';

	public const Blocks = [
		['footer' => 'blockFooter'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		$this->renderBlock('footer', get_defined_vars()) /* line 1 */;
		echo ' ';
	}


	/** {block footer} on line 1 */
	public function blockFooter(array $ʟ_args): void
	{
		echo '    &copy; Copyright ';
		echo LR\Filters::escapeHtmlText(date('Y')) /* line 2 */;
		echo ' by <a href="https://github.com/akkiirah">akkiirah</a>
';
	}
}
