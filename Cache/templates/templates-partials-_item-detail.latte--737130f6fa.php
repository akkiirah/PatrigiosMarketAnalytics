<?php

use Latte\Runtime as LR;

/** source: Resources\html\templates\partials\_item-detail.latte */
final class Template_737130f6fa extends Latte\Runtime\Template
{
	public const Source = 'Resources\\html\\templates\\partials\\_item-detail.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<div class="item-wrap" data-item-id="';
		echo LR\Filters::escapeHtmlAttr($item->getItemId()) /* line 1 */;
		echo '" data-item-name="';
		echo LR\Filters::escapeHtmlAttr($item->getItemName()) /* line 1 */;
		echo '" data-item-base="';
		echo LR\Filters::escapeHtmlAttr($item->getItemBasePrice()) /* line 1 */;
		echo '" data-item-last="';
		echo LR\Filters::escapeHtmlAttr($item->getItemLastSalePrice()) /* line 1 */;
		echo '" data-item-last-time="';
		echo LR\Filters::escapeHtmlAttr($item->getItemLastSaleTime()) /* line 1 */;
		echo '" data-item-stock="';
		echo LR\Filters::escapeHtmlAttr($item->getItemCurrentStock()) /* line 1 */;
		echo '" data-item-minprice="';
		echo LR\Filters::escapeHtmlAttr($item->getItemHardCapMin()) /* line 1 */;
		echo '" data-item-maxprice="';
		echo LR\Filters::escapeHtmlAttr($item->getItemHardCapMax()) /* line 1 */;
		echo '">
    <div class="item-head">
        <img src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($item->getItemImage())) /* line 3 */;
		echo '" alt="Item Image" />
        <h2 class="item-heading">[';
		echo LR\Filters::escapeHtmlText($item->getItemId()) /* line 4 */;
		echo '] - ';
		echo LR\Filters::escapeHtmlText($item->getItemName()) /* line 4 */;
		echo '</h2>
    </div>
    <div class="item-body-wrap">
        <div class="item-body">
            <span class="item-info-desc item-baseprice-desc">Basispreis: </span>
            <span class="item-info-value item-baseprice-value">
                <div class="item-baseprice-button-wrap">
                    <p>
                        ';
		echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemBasePrice(), 0, ',', '.')) /* line 12 */;
		echo ' 
                    </p>
                </div>
            </span>
';
		if ($item->getItemLastSalePrice() != 0) /* line 16 */ {
			echo '                <span class="item-info-desc item-last-desc">Zuletzt: </span>
                <span class="item-info-value item-last-value">
                    <p';
			echo ($ʟ_tmp = array_filter([$item->getItemLastSalePrice() > $item->getItemBasePrice() ? 'stonks' : ($item->getItemLastSalePrice() < $item->getItemBasePrice() ? 'stinks' : null)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 19 */;
			echo '>
                        ';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemLastSalePrice(), 0, ',', '.')) /* line 20 */;
			echo '
                    </p>
                    <p class="item-last-time">';
			echo LR\Filters::escapeHtmlText($item->getItemLastSaleTime()) /* line 22 */;
			echo '</p>
                </span>
';
		} else /* line 24 */ {
			echo '                <span class="item-info-desc item-last-desc">Zuletzt: </span>
                <span class="item-info-value item-last-value">Datenfehler?</span>
';
		}
		echo '            <span class="item-info-desc item-stock-desc">Vorrat: </span>
            <span class="item-info-value item-stock-value">
                ';
		echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemCurrentStock(), 0, ',', '.')) /* line 30 */;
		echo '
            </span>
        </div>
        <div class="item-body">
';
		if ($item->getItemHardCapMin() != 0) /* line 34 */ {
			echo '                <span class="item-info-desc item-minprice-desc">Minpreis: </span>
                <span class="item-info-value item-minprice-value">
                    ';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemHardCapMin(), 0, ',', '.')) /* line 37 */;
			echo '
                </span>
';
		}
		if ($item->getItemHardCapMax() != 0) /* line 40 */ {
			echo '                <span class="item-info-desc item-maxprice-desc">Maxpreis: </span>
                <span class="item-info-value item-maxprice-desc">
                    ';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemHardCapMax(), 0, ',', '.')) /* line 43 */;
			echo '
                </span>
';
		}
		echo '            <span class="item-info-etc item-cat-desc">Kategorie: </span>
            <span class="item-info-value item-cat-value">
                ';
		echo LR\Filters::escapeHtmlText($item->getItemCategory()->getMainCategoryName()) /* line 48 */;
		echo '/';
		echo LR\Filters::escapeHtmlText($item->getItemCategory()->getSubCategoryName()) /* line 48 */;
		echo '
            </span>
        </div>
    </div>
</div>

<canvas id="preisChart" width="400" height="200"></canvas>
<p id="priceHistory" style="display:none;">';
		echo LR\Filters::escapeHtmlText(($this->filters->json_encode)($item->getItemPriceHistoryDates())) /* line 55 */;
		echo '</p>';
	}
}
