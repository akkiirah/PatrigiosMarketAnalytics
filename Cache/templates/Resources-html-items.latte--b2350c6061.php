<?php

use Latte\Runtime as LR;

/** source: Resources\html\items.latte */
final class Template_b2350c6061 extends Latte\Runtime\Template
{
	public const Source = 'Resources\\html\\items.latte';

	public const Blocks = [
		['items' => 'blockItems', 'item' => 'blockItem'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		$this->renderBlock('items', get_defined_vars()) /* line 1 */;
		echo "\n";
		$this->renderBlock('item', get_defined_vars()) /* line 25 */;
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['item' => '5'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}


	/** {block items} on line 1 */
	public function blockItems(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<div id="itemsContainer"';
		echo ($ʟ_tmp = array_filter([$action == 'listAction' ? 'list' : 'start'])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 2 */;
		echo '>

    <div class="items-wrap">
';
		foreach ($iterator = $ʟ_it = new Latte\Essential\CachingIterator($items, $ʟ_it ?? null) as $item) /* line 5 */ {
			$this->renderBlock('item', get_defined_vars(), 'html') /* line 6 */;
		}
		$iterator = $ʟ_it = $ʟ_it->getParent();

		echo '    </div>
';
		if ($action == 'listAction') /* line 9 */ {
			echo '        <nav class="pagination">
            <button class="button nav-button" id="prevButton" data-page="';
			echo LR\Filters::escapeHtmlAttr($currentPage - 1) /* line 11 */;
			echo '" ';
			if ($currentPage <= 1) /* line 11 */ {
				echo 'disabled';
			}
			echo '>
                Prev
            </button>
            <span id="currentPage" disabled="disabled">
                ';
			echo LR\Filters::escapeHtmlText($currentPage) /* line 15 */;
			echo ' / ';
			echo LR\Filters::escapeHtmlText($lastPage) /* line 15 */;
			echo '
            </span>
            <button class="button nav-button" id="nextButton" data-page="';
			echo LR\Filters::escapeHtmlAttr($nextPage) /* line 17 */;
			echo '" ';
			if (!$hasMoreItems) /* line 17 */ {
				echo 'disabled';
			}
			echo '>
                Next
            </button>
        </nav>
';
		}
		echo '</div>
';
	}


	/** {block item} on line 25 */
	public function blockItem(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '    <div class="item-wrap">
        <div class="item-head">
            <img src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($item->getItemImage())) /* line 28 */;
		echo '"/>
            <h2 class="item-heading">[';
		echo LR\Filters::escapeHtmlText($item->getItemId()) /* line 29 */;
		echo '] - ';
		echo LR\Filters::escapeHtmlText($item->getItemName()) /* line 29 */;
		echo '</h2>
        </div>
        <div class="item-body-wrap">
';
		if ($action == 'listAction') /* line 32 */ {
			echo '                    <div class="item-body">

                        <div class="item-values">
                            <span class="item-info-desc item-baseprice-desc">Basispreis: </span>
                            <span class="item-info-value item-baseprice-value">';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemBasePrice(), 0, ',', '.')) /* line 37 */;
			echo '</span>
                        </div>
                        <div class="item-values">
';
			if ($item->getItemLastSalePrice() != 0) /* line 40 */ {
				echo '                                <span class="item-info-desc item-last-desc">Zuletzt: </span>
                                <span class="item-info-value item-last-value" >
                                    ';
				echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemLastSalePrice(), 0, ',', '.')) /* line 43 */;
				echo ' , <p class="item-last-time">';
				echo LR\Filters::escapeHtmlText($item->getItemLastSaleTime()) /* line 43 */;
				echo '</p>
                                </span>
';
			} else /* line 45 */ {
				echo '                                <span class="item-info-desc item-last-desc">Zuletzt: </span>
                                <span class="item-info-value item-last-value">Noch nie... angeblich lol</span>
';
			}
			echo '                        </div>
                        <div class="item-values">
                            <span class="item-info-desc item-stock-desc">Vorrat: </span>
                            <span class="item-info-value item-stock-value">';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemCurrentStock(), 0, ',', '.')) /* line 52 */;
			echo '</span>
                        </div>
                    </div>
                    <div class="item-body">
                        <div class="item-values">
';
			if ($item->getItemHardCapMin() != 0) /* line 57 */ {
				echo '                                <span class="item-info-desc item-minprice-desc">Minpreis: </span>
                                <span class="item-info-value item-minprice-value">';
				echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemHardCapMin(), 0, ',', '.')) /* line 59 */;
				echo '</span>
';
			}
			echo '                        </div>
                        <div class="item-values">
';
			if ($item->getItemHardCapMax() != 0) /* line 63 */ {
				echo '                                <span class="item-info-desc item-maxprice-desc">Maxpreis: </span>
                                <span class="item-info-value item-maxprice-value">';
				echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemHardCapMax(), 0, ',', '.')) /* line 65 */;
				echo '</span>
';
			}
			echo '                        </div>
                        <div class="item-values">
                            <span class="item-info-etc item-cat-desc">Kategorie: </span>
                            <span class="item-info-value item-cat-value">
                                ';
			echo LR\Filters::escapeHtmlText($item->getItemCategory()->getMainCategoryName()) /* line 71 */;
			echo '/';
			echo LR\Filters::escapeHtmlText($item->getItemCategory()->getSubCategoryName()) /* line 71 */;
			echo '
                            </span>
                        </div>
                    </div>
';
		} else /* line 75 */ {
			echo '                    <div class="item-body">

                        <span class="item-info-desc item-baseprice-desc">Basispreis: </span>
                        <span class="item-info-value item-baseprice-value">';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemBasePrice(), 0, ',', '.')) /* line 79 */;
			echo '</span>
';
			if ($item->getItemLastSalePrice() != 0) /* line 80 */ {
				echo '                            <span class="item-info-desc item-last-desc">Zuletzt: </span>
                            <span class="item-info-value item-last-value">
                                ';
				echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemLastSalePrice(), 0, ',', '.')) /* line 83 */;
				echo ' , <p class="item-last-time">';
				echo LR\Filters::escapeHtmlText($item->getItemLastSaleTime()) /* line 83 */;
				echo '</p>
                            </span>
';
			} else /* line 85 */ {
				echo '                            <span class="item-info-desc item-last-desc">Zuletzt: </span>
                            <span class="item-info-value item-last-value">Noch nie... angeblich lol</span>
';
			}
			echo '                        <span class="item-info-desc item-stock-desc">Vorrat: </span>
                        <span class="item-info-value item-stock-value">';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemCurrentStock(), 0, ',', '.')) /* line 90 */;
			echo '</span>
                    </div>
                    <div class="item-body">
';
			if ($item->getItemHardCapMin() != 0) /* line 93 */ {
				echo '                            <span class="item-info-desc item-minprice-desc">Minpreis: </span>
                            <span class="item-info-value item-minprice-value">';
				echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemHardCapMin(), 0, ',', '.')) /* line 95 */;
				echo '</span>
';
			}
			if ($item->getItemHardCapMax() != 0) /* line 97 */ {
				echo '                            <span class="item-info-desc item-maxprice-desc">Maxpreis: </span>
                            <span class="item-info-value item-maxprice-desc">';
				echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemHardCapMax(), 0, ',', '.')) /* line 99 */;
				echo '</span>
';
			}
			echo '                            <span class="item-info-etc item-cat-desc">Kategorie: </span>
                            <span class="item-info-value item-cat-value">
                            ';
			echo LR\Filters::escapeHtmlText($item->getItemCategory()->getMainCategoryName()) /* line 103 */;
			echo '/';
			echo LR\Filters::escapeHtmlText($item->getItemCategory()->getSubCategoryName()) /* line 103 */;
			echo '
                        </span>
                    </div>
';
		}
		echo '
        </div>
    </div>
';
	}
}
