<?php

use Latte\Runtime as LR;

/** source: Resources\html\content.latte */
final class Template_c57ebc3067 extends Latte\Runtime\Template
{
	public const Source = 'Resources\\html\\content.latte';

	public const Blocks = [
		['content' => 'blockContent', 'title' => 'blockTitle', 'items' => 'blockItems'],
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
		if ($items) /* line 5 */ {
			echo '        <div class="heading">
';
			$this->renderBlock('title', get_defined_vars()) /* line 7 */;
			if ($action == 'listAction') /* line 14 */ {
				echo '                    <h2>';
				echo LR\Filters::escapeHtmlText((($this->global->fn->first)($this, $items))->getItemCategory()->getMainCategoryName()) /* line 15 */;
				echo '&nbsp;<span class="seperator">=></span>&nbsp;';
				echo LR\Filters::escapeHtmlText((($this->global->fn->first)($this, $items))->getItemCategory()->getSubCategoryName()) /* line 15 */;
				echo '</h2>
';
			} else /* line 16 */ {
				echo '                    <h2>Favorite Items</h2>
';
			}
			echo '        </div>
';
			$this->renderBlock('items', get_defined_vars()) /* line 20 */;
		}
	}


	/** {block title} on line 7 */
	public function blockTitle(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		if ($action == 'listAction') /* line 8 */ {
			echo '                    <h1>List-View of Items</h1>
';
		} else /* line 10 */ {
			echo '                    <h1>Homepage</h1>
';
		}
	}


	/** {block items } on line 20 */
	public function blockItems(array $ʟ_args): void
	{
	}
}
