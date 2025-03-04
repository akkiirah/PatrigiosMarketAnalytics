<?php

use Latte\Runtime as LR;

/** source: Resources/html/templates/start.latte */
final class Template_75fa26b43c extends Latte\Runtime\Template
{
	public const Source = 'Resources/html/templates/start.latte';

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
		$this->renderBlock('footer', get_defined_vars()) /* line 23 */;
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['key' => '16', 'item' => '16'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		$this->parentName = '../@layout.latte';
		return get_defined_vars();
	}


	/** {block title} on line 3 */
	public function blockTitle(array $ʟ_args): void
	{
		echo '    Homepage - Favorite Items
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
            <h1>Hello <span class="highlight">';
		echo LR\Filters::escapeHtmlText($user->getUserName()) /* line 10 */;
		echo '</span></h1>
            <h2>Favorite Items</h2>
        </div>
    </div>
    <div id="itemsContainer" class="start">
        <div class="items-wrap">
';
		foreach ($items as $key => $item) /* line 16 */ {
			$this->createTemplate('partials/_item-start.latte', ['item' => $item, 'key' => $key] + $this->params, 'include')->renderToContentType('html') /* line 17 */;
		}

		echo '        </div>
    </div>
';
	}


	/** {block footer} on line 23 */
	public function blockFooter(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		$this->createTemplate('partials/footer.latte', $this->params, 'include')->renderToContentType('html') /* line 24 */;
	}
}
