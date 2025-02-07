<?php

use Latte\Runtime as LR;

/** source: Resources\html\content.latte */
final class Template_4b8fe01b86 extends Latte\Runtime\Template
{
	public const Source = 'Resources\\html\\content.latte';

	public const Blocks = [
		['content' => 'blockContent', 'item' => 'blockItem'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '

';
		$this->renderBlock('content', get_defined_vars()) /* line 3 */;
	}


	/** {block content} on line 3 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo "\n";
		if ($item) /* line 5 */ {
			$this->renderBlock('item', get_defined_vars()) /* line 6 */;
		}
		echo "\n";
	}


	/** {block item } on line 6 */
	public function blockItem(array $ʟ_args): void
	{
	}
}
