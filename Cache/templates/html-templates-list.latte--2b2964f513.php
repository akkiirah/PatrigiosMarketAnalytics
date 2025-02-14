<?php

use Latte\Runtime as LR;

/** source: Resources/html/templates/list.latte */
final class Template_2b2964f513 extends Latte\Runtime\Template
{
	public const Source = 'Resources/html/templates/list.latte';

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
		$this->renderBlock('footer', get_defined_vars()) /* line 37 */;
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['item' => '24'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		$this->parentName = '../@layout.latte';
		return get_defined_vars();
	}


	/** {block title} on line 3 */
	public function blockTitle(array $ʟ_args): void
	{
		echo '    List-View of Items
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
            <h1>List-View of Items</h1>
            <h2>';
		echo LR\Filters::escapeHtmlText((($this->global->fn->first)($this, $items))->getItemCategory()->getMainCategoryName()) /* line 11 */;
		echo ' &nbsp;&rarr;&nbsp; ';
		echo LR\Filters::escapeHtmlText((($this->global->fn->first)($this, $items))->getItemCategory()->getSubCategoryName()) /* line 11 */;
		echo '</h2>
        </div>
        <div class="amount-select">
            <select class="button amount-button" id="amountButton">
                <option value="10" ';
		if ($itemsPerPage == 10) /* line 15 */ {
			echo 'selected';
		}
		echo '>10</option>
                <option value="20" ';
		if ($itemsPerPage == 20) /* line 16 */ {
			echo 'selected';
		}
		echo '>20</option>
                <option value="50" ';
		if ($itemsPerPage == 50) /* line 17 */ {
			echo 'selected';
		}
		echo '>50</option>
                <option value="100" ';
		if ($itemsPerPage == 100) /* line 18 */ {
			echo 'selected';
		}
		echo '>100</option>
            </select>
        </div>
    </div>
    <div id="itemsContainer" class="list">
        <div class="items-wrap">
';
		foreach ($items as $item) /* line 24 */ {
			$this->createTemplate('partials/_item-list.latte', ['item' => $item] + $this->params, 'include')->renderToContentType('html') /* line 25 */;
		}

		echo '        </div>
';
		$this->createTemplate('partials/_pagination.latte', ['currentPage' => $currentPage, 'lastPage' => $lastPage, 'nextPage' => $nextPage, 'hasMoreItems' => $hasMoreItems] + $this->params, 'include')->renderToContentType('html') /* line 28 */;
		echo '    </div>
';
	}


	/** {block footer} on line 37 */
	public function blockFooter(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		$this->createTemplate('footer.latte', $this->params, 'include')->renderToContentType('html') /* line 38 */;
	}
}
