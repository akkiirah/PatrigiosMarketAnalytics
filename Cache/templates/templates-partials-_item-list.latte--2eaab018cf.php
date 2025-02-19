<?php

use Latte\Runtime as LR;

/** source: Resources\html\templates\partials\_item-list.latte */
final class Template_2eaab018cf extends Latte\Runtime\Template
{
	public const Source = 'Resources\\html\\templates\\partials\\_item-list.latte';


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
		echo '" data-item-stock="';
		echo LR\Filters::escapeHtmlAttr($item->getItemCurrentStock()) /* line 1 */;
		echo '">
    <div class="border-horizontal top"></div>
    <div class="border-horizontal bottom"></div>
    <div class="item-body">
        <img src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($item->getItemImage())) /* line 5 */;
		echo '" alt="Item Image" />
        <h2 class="item-heading">[';
		echo LR\Filters::escapeHtmlText($item->getItemId()) /* line 6 */;
		echo '] - ';
		echo LR\Filters::escapeHtmlText($item->getItemName()) /* line 6 */;
		echo '</h2>
        <div class="item-values">
            <span class="item-info-desc item-baseprice-desc">Basispreis: </span>
            <span class="item-info-desc item-baseprice-desc">Letzter Preis: </span>
            <span class="item-info-desc item-baseprice-desc">Zeitpunkt: </span>
            <span class="item-info-desc item-baseprice-desc">Vorrat: </span>
            <span class="item-info-value item-baseprice-value">
                ';
		echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemBasePrice(), 0, ',', '.')) /* line 13 */;
		echo '
            </span>
';
		if ($item->getItemLastSalePrice() != 0) /* line 15 */ {
			echo '                <span class="item-info-value item-last-value">
                    <p';
			echo ($ʟ_tmp = array_filter([$item->getItemLastSalePrice() > $item->getItemBasePrice() ? 'stonks' : ($item->getItemLastSalePrice() < $item->getItemBasePrice() ? 'stinks' : null)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 17 */;
			echo '>
                        ';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemLastSalePrice(), 0, ',', '.')) /* line 18 */;
			echo '
                    </p>
                </span>
                <span class="item-info-value item-last-time-value">
                    ';
			echo LR\Filters::escapeHtmlText($item->getItemLastSaleTime()) /* line 22 */;
			echo '
                </span>
';
		} else /* line 24 */ {
			echo '                <span class="item-info-value item-last-value">-</span>
                <span class="item-info-value item-last-time-value">-</span>
';
		}
		echo '            <span class="item-info-value item-stock-value">
                ';
		echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemCurrentStock(), 0, ',', '.')) /* line 29 */;
		echo '
            </span>
        </div>
    </div> 
</a>
';
	}
}
