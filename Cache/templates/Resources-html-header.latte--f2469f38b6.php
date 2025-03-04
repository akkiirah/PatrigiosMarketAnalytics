<?php

use Latte\Runtime as LR;

/** source: Resources/html/header.latte */
final class Template_f2469f38b6 extends Latte\Runtime\Template
{
	public const Source = 'Resources/html/header.latte';

	public const Blocks = [
		['header' => 'blockHeader'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		$this->renderBlock('header', get_defined_vars()) /* line 1 */;
	}


	/** {block header} on line 1 */
	public function blockHeader(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '	<header class="header-wrap">
		<div class="max-width-layout">
			<div class="logo-wrap">
				<img src="/Resources/assets/logos/logo.webp" class="logo-img"/>
				<img src="/Resources/assets/logos/logo-text.webp" class="logo-img-text"/>
			</div>
			<nav class="menu" id="menu">
				<button id="menu-categories-button"><span>Categories</span></button>
			</nav>
';
		if ($user) /* line 11 */ {
			echo '				<div class="user-wrap">
					<span class="username">';
			echo LR\Filters::escapeHtmlText($user->getUserName()) /* line 13 */;
			echo '</span>	
					<a href="?controller=User&action=logout" class="logout-btn"></a>
				</div>

';
		} else /* line 17 */ {
			echo '				<a href="?controller=User&action=login" class="login-btn"></a>
';
		}
		echo '		</div>
	</header>
	<div id="menu-categories-content" class="max-width-layout"></div>
	<div class="menu-overlay"></div>
';
	}
}
