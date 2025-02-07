<?php

use Latte\Runtime as LR;

/** source: Resources\html\header.latte */
final class Template_aa0ae8a680 extends Latte\Runtime\Template
{
	public const Source = 'Resources\\html\\header.latte';

	public const Blocks = [
		['header' => 'blockHeader', 'title' => 'blockTitle'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		$this->renderBlock('header', get_defined_vars()) /* line 1 */;
	}


	/** {block header} on line 1 */
	public function blockHeader(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		$this->renderBlock('title', get_defined_vars()) /* line 2 */;
	}


	/** n:block="title" on line 2 */
	public function blockTitle(array $ʟ_args): void
	{
		echo '	<h1>Black Desert API</h1>
';
	}
}
