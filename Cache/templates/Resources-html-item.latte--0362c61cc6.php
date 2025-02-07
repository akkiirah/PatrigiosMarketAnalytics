<?php

use Latte\Runtime as LR;

/** source: Resources\html\item.latte */
final class Template_0362c61cc6 extends Latte\Runtime\Template
{
	public const Source = 'Resources\\html\\item.latte';

	public const Blocks = [
		['item' => 'blockItem'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		$this->renderBlock('item', get_defined_vars()) /* line 1 */;
	}


	/** {block item} on line 1 */
	public function blockItem(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Basispreis</th>
        </tr>
        <tr>
            <td>';
		echo LR\Filters::escapeHtmlText($item->getItemId()) /* line 9 */;
		echo '</td>
            <td>';
		echo LR\Filters::escapeHtmlText($item->getItemName()) /* line 10 */;
		echo '</td>
            <td>';
		echo LR\Filters::escapeHtmlText($item->getItemBasePrice()) /* line 11 */;
		echo '</td>
        </tr>
    </table>
';
	}
}
