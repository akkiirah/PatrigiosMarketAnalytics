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

		echo '<div class="item-wrap">
    <div class="item-body">
        <img src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($item->getItemImage())) /* line 3 */;
		echo '" alt="Item Image" />
        <h2 class="item-heading">[';
		echo LR\Filters::escapeHtmlText($item->getItemId()) /* line 4 */;
		echo '] - ';
		echo LR\Filters::escapeHtmlText($item->getItemName()) /* line 4 */;
		echo '</h2>
        <div class="item-values">
            <span class="item-info-desc item-baseprice-desc">Basispreis: </span>
            <span class="item-info-desc item-baseprice-desc">Letzter Preis: </span>
            <span class="item-info-desc item-baseprice-desc">Zeitpunkt: </span>
            <span class="item-info-desc item-baseprice-desc">Vorrat: </span>
            <span class="item-info-value item-baseprice-value">
                ';
		echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemBasePrice(), 0, ',', '.')) /* line 11 */;
		echo '
            </span>
';
		if ($item->getItemLastSalePrice() != 0) /* line 13 */ {
			echo '                <span class="item-info-value item-last-value">
                    <p';
			echo ($ʟ_tmp = array_filter([$item->getItemLastSalePrice() > $item->getItemBasePrice() ? 'stonks' : ($item->getItemLastSalePrice() < $item->getItemBasePrice() ? 'stinks' : null)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 15 */;
			echo '>
                        ';
			echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemLastSalePrice(), 0, ',', '.')) /* line 16 */;
			echo '
                    </p>
                </span>
                <span class="item-info-value item-last-time-value">
                    ';
			echo LR\Filters::escapeHtmlText($item->getItemLastSaleTime()) /* line 20 */;
			echo '
                </span>
';
		} else /* line 22 */ {
			echo '                <span class="item-info-value item-last-value">-</span>
                <span class="item-info-value item-last-time-value">-</span>
';
		}
		echo '            <span class="item-info-value item-stock-value">
                ';
		echo LR\Filters::escapeHtmlText(($this->filters->number_format)($item->getItemCurrentStock(), 0, ',', '.')) /* line 27 */;
		echo '
            </span>
        </div>
    </div>
</div>
';
	}
}
