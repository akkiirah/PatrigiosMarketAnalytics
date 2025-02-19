<?php

use Latte\Runtime as LR;

/** source: Resources/html/templates/detail.latte */
final class Template_0c03a16621 extends Latte\Runtime\Template
{
	public const Source = 'Resources/html/templates/detail.latte';

	public const Blocks = [
		['title' => 'blockTitle', 'content' => 'blockContent', 'footer' => 'blockFooter'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo "\n";
		$this->renderBlock('title', get_defined_vars()) /* line 3 */;
		echo "\n";
		$this->renderBlock('content', get_defined_vars()) /* line 7 */;
		echo "\n";
		$this->renderBlock('footer', get_defined_vars()) /* line 22 */;
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['itemData' => '15'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		$this->parentName = '../@layout.latte';
		return get_defined_vars();
	}


	/** {block title} on line 3 */
	public function blockTitle(array $ʟ_args): void
	{
		echo '    Detail-View of Item
';
	}


	/** {block content} on line 7 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '    <div class="heading">
        <div class="title">
            <h1>Detail-View</h1>
        </div>
    </div>
    <div id="itemsContainer" class="detail">
        <div class="items-wrap">
';
		foreach ($item as $itemData) /* line 15 */ {
			$this->createTemplate('partials/_item-detail.latte', ['item' => $itemData] + $this->params, 'include')->renderToContentType('html') /* line 16 */;
		}

		echo '        </div>
    </div>
';
	}


	/** {block footer} on line 22 */
	public function blockFooter(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		$this->createTemplate('footer.latte', $this->params, 'include')->renderToContentType('html') /* line 23 */;
	}
}
