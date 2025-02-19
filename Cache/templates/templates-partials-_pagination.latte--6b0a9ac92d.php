<?php

use Latte\Runtime as LR;

/** source: Resources/html/templates/partials/_pagination.latte */
final class Template_6b0a9ac92d extends Latte\Runtime\Template
{
	public const Source = 'Resources/html/templates/partials/_pagination.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<nav class="pagination">
    <button class="button nav-button" id="prevButton" data-page="';
		echo LR\Filters::escapeHtmlAttr($currentPage - 1) /* line 2 */;
		echo '" ';
		if ($currentPage <= 1) /* line 2 */ {
			echo 'disabled';
		}
		echo '>
        Prev
    </button>
    <span id="currentPage" disabled="disabled">
        ';
		echo LR\Filters::escapeHtmlText($currentPage) /* line 6 */;
		echo ' / ';
		echo LR\Filters::escapeHtmlText($lastPage) /* line 6 */;
		echo '
    </span>
    <button class="button nav-button" id="nextButton" data-page="';
		echo LR\Filters::escapeHtmlAttr($nextPage) /* line 8 */;
		echo '" ';
		if (!$hasMoreItems) /* line 8 */ {
			echo 'disabled';
		}
		echo '>
        Next
    </button>
</nav>
';
	}
}
