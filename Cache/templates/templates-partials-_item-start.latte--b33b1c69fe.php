<?php

use Latte\Runtime as LR;

/** source: Resources\html\templates\partials\_item-start.latte */
final class Template_b33b1c69fe extends Latte\Runtime\Template
{
	public const Source = 'Resources\\html\\templates\\partials\\_item-start.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<div class="item-wrap">
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
                    <p';
		echo ($ʟ_tmp = array_filter([$item->getItemPriceHistory()['vor_5'] < $item->getItemBasePrice() ? 'stonks' : ($item->getItemPriceHistory()['vor_5'] > $item->getItemBasePrice() ? 'stinks' : null)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 11 */;
		echo '>
                        ';
		echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemBasePrice(), 0, ',', '.')) /* line 12 */;
		echo ' 
                    </p>
                    
                    <button class="button price-button" id="priceButton" data-id="';
		echo LR\Filters::escapeHtmlAttr($key + 1) /* line 15 */;
		echo '"></button>
                </div>
';
		if ($item->getItemPriceHistory() != []) /* line 17 */ {
			echo '                    <div class="item-info-value item-pricehistory-wrap">
';
			for ($day = 5;
			$day <= 90;
			$day += 5) /* line 19 */ {
				echo '                            <span class="item-info-value item-pricehistory-desc">Vor ';
				echo LR\Filters::escapeHtmlText($day) /* line 20 */;
				echo ' Tagen:</span>
                            <p';
				echo ($ʟ_tmp = array_filter([$item->getItemPriceHistory()['vor_' . $day] > $item->getItemBasePrice() ? 'stonks' : ($item->getItemPriceHistory()['vor_' . $day] < $item->getItemBasePrice() ? 'stinks' : null)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 21 */;
				echo '>
                                ';
				echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemPriceHistory()['vor_' . $day], 0, ',', '.')) /* line 26 */;
				echo '
                            </p>
';

			}
			echo '                    </div>
';
		}
		echo '            </span>
';
		if ($item->getItemLastSalePrice() != 0) /* line 32 */ {
			echo '                <span class="item-info-desc item-last-desc">Zuletzt: </span>
                <span class="item-info-value item-last-value">
                    <p';
			echo ($ʟ_tmp = array_filter([$item->getItemLastSalePrice() > $item->getItemBasePrice() ? 'stonks' : ($item->getItemLastSalePrice() < $item->getItemBasePrice() ? 'stinks' : null)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 35 */;
			echo '>
                        ';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemLastSalePrice(), 0, ',', '.')) /* line 36 */;
			echo '
                    </p>
                    <p class="item-last-time">';
			echo LR\Filters::escapeHtmlText($item->getItemLastSaleTime()) /* line 38 */;
			echo '</p>
                </span>
';
		} else /* line 40 */ {
			echo '                <span class="item-info-desc item-last-desc">Zuletzt: </span>
                <span class="item-info-value item-last-value">Noch nie... angeblich lol</span>
';
		}
		echo '            <span class="item-info-desc item-stock-desc">Vorrat: </span>
            <span class="item-info-value item-stock-value">
                ';
		echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemCurrentStock(), 0, ',', '.')) /* line 46 */;
		echo '
            </span>
        </div>
        <div class="item-body">
';
		if ($item->getItemHardCapMin() != 0) /* line 50 */ {
			echo '                <span class="item-info-desc item-minprice-desc">Minpreis: </span>
                <span class="item-info-value item-minprice-value">
                    ';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemHardCapMin(), 0, ',', '.')) /* line 53 */;
			echo '
                </span>
';
		}
		if ($item->getItemHardCapMax() != 0) /* line 56 */ {
			echo '                <span class="item-info-desc item-maxprice-desc">Maxpreis: </span>
                <span class="item-info-value item-maxprice-desc">
                    ';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemHardCapMax(), 0, ',', '.')) /* line 59 */;
			echo '
                </span>
';
		}
		echo '            <span class="item-info-etc item-cat-desc">Kategorie: </span>
            <span class="item-info-value item-cat-value">
                ';
		echo LR\Filters::escapeHtmlText($item->getItemCategory()->getMainCategoryName()) /* line 64 */;
		echo '/';
		echo LR\Filters::escapeHtmlText($item->getItemCategory()->getSubCategoryName()) /* line 64 */;
		echo '
            </span>
        </div>
    </div>
</div>
';
	}
}
