<?php

use Latte\Runtime as LR;

/** source: Resources/html/templates/partials/_item-start.latte */
final class Template_f8949a5826 extends Latte\Runtime\Template
{
	public const Source = 'Resources/html/templates/partials/_item-start.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<a href="?controller=Item&action=detail&params=&#123id:';
		echo LR\Filters::escapeHtmlAttr($item->getItemId()) /* line 1 */;
		echo '&#125" class="item-wrap" data-item-id="';
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
		echo '">
    <div class="border-horizontal top"></div>
    <div class="border-horizontal bottom"></div>
    <div class="item-head">
        <img src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($item->getItemImage())) /* line 5 */;
		echo '" alt="Item Image" />
        <h2 class="item-heading">[';
		echo LR\Filters::escapeHtmlText($item->getItemId()) /* line 6 */;
		echo '] - ';
		echo LR\Filters::escapeHtmlText($item->getItemName()) /* line 6 */;
		echo '</h2>
';
		if ($user) /* line 7 */ {
			echo '            <button class="item-pin active" id="item-pin-';
			echo LR\Filters::escapeHtmlAttr($item->getItemId()) /* line 8 */;
			echo '"></button>
';
		}
		echo '    </div>
    <div class="item-body-wrap">
        <div class="item-body">
            <span class="item-info-desc item-baseprice-desc">Basispreis: </span>
            <span class="item-info-value item-baseprice-value">
                <div class="item-baseprice-button-wrap">
                    <p';
		echo ($ʟ_tmp = array_filter([$item->getItemPriceHistory()['vor_5'] < $item->getItemBasePrice() ? 'stonks' : ($item->getItemPriceHistory()['vor_5'] > $item->getItemBasePrice() ? 'stinks' : null)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 16 */;
		echo '>
                        ';
		echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemBasePrice(), 0, ',', '.')) /* line 17 */;
		echo ' 
                    </p>
                    
                    <button class="button price-button" id="priceButton-';
		echo LR\Filters::escapeHtmlAttr($item->getItemId()) /* line 20 */;
		echo '" data-id="';
		echo LR\Filters::escapeHtmlAttr($key + 1) /* line 20 */;
		echo '"></button>
                </div>
';
		if ($item->getItemPriceHistory() != []) /* line 22 */ {
			echo '                    <div class="item-info-value item-pricehistory-wrap">
';
			for ($day = 5;
			$day <= 90;
			$day += 5) /* line 24 */ {
				echo '                            <span class="item-info-value item-pricehistory-desc">Vor ';
				echo LR\Filters::escapeHtmlText($day) /* line 25 */;
				echo ' Tagen:</span>
                            <p';
				echo ($ʟ_tmp = array_filter([$item->getItemPriceHistory()['vor_' . $day] > $item->getItemBasePrice() ? 'stonks' : ($item->getItemPriceHistory()['vor_' . $day] < $item->getItemBasePrice() ? 'stinks' : null)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 26 */;
				echo '>
                                ';
				echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemPriceHistory()['vor_' . $day], 0, ',', '.')) /* line 31 */;
				echo '
                            </p>
';

			}
			echo '                    </div>
';
		}
		echo '            </span>
';
		if ($item->getItemLastSalePrice() != 0) /* line 37 */ {
			echo '                <span class="item-info-desc item-last-desc">Zuletzt: </span>
                <span class="item-info-value item-last-value">
                    <p';
			echo ($ʟ_tmp = array_filter([$item->getItemLastSalePrice() > $item->getItemBasePrice() ? 'stonks' : ($item->getItemLastSalePrice() < $item->getItemBasePrice() ? 'stinks' : null)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 40 */;
			echo '>
                        ';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemLastSalePrice(), 0, ',', '.')) /* line 41 */;
			echo '
                    </p>
                    <p class="item-last-time">';
			echo LR\Filters::escapeHtmlText($item->getItemLastSaleTime()) /* line 43 */;
			echo '</p>
                </span>
';
		} else /* line 45 */ {
			echo '                <span class="item-info-desc item-last-desc">Zuletzt: </span>
                <span class="item-info-value item-last-value">Datenfehler?</span>
';
		}
		echo '            <span class="item-info-desc item-stock-desc">Vorrat: </span>
            <span class="item-info-value item-stock-value">
                ';
		echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemCurrentStock(), 0, ',', '.')) /* line 51 */;
		echo '
            </span>
        </div>
        <div class="item-body">
';
		if ($item->getItemHardCapMin() != 0) /* line 55 */ {
			echo '                <span class="item-info-desc item-minprice-desc">Minpreis: </span>
                <span class="item-info-value item-minprice-value">
                    ';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemHardCapMin(), 0, ',', '.')) /* line 58 */;
			echo '
                </span>
';
		}
		if ($item->getItemHardCapMax() != 0) /* line 61 */ {
			echo '                <span class="item-info-desc item-maxprice-desc">Maxpreis: </span>
                <span class="item-info-value item-maxprice-desc">
                    ';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemHardCapMax(), 0, ',', '.')) /* line 64 */;
			echo '
                </span>
';
		}
		echo '            <span class="item-info-etc item-cat-desc">Kategorie: </span>
            <span class="item-info-value item-cat-value">
                ';
		echo LR\Filters::escapeHtmlText($item->getItemCategory()->getMainCategoryName()) /* line 69 */;
		echo '/';
		echo LR\Filters::escapeHtmlText($item->getItemCategory()->getSubCategoryName()) /* line 69 */;
		echo '
            </span>
        </div>
    </div>
</a>
 ';
	}
}
