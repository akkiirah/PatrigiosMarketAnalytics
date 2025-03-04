<?php

use Latte\Runtime as LR;

/** source: Resources/html/templates/login.latte */
final class Template_6b4973757e extends Latte\Runtime\Template
{
	public const Source = 'Resources/html/templates/login.latte';

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
		$this->renderBlock('footer', get_defined_vars()) /* line 47 */;
	}


	public function prepare(): array
	{
		extract($this->params);

		$this->parentName = '../@layout.latte';
		return get_defined_vars();
	}


	/** {block title} on line 3 */
	public function blockTitle(array $ʟ_args): void
	{
		echo '    Login
';
	}


	/** {block content} on line 7 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '    <form action="/php/actions/signIn.php" method="post" class="input-login">
        <div class="left-wrap">
            <div class="notice-wrap">
                <span class="notice">Login to Your Account</span>
                <p class="notice-text">using your credentials</p>
            </div>

            <input 
                type="text" 
                name="username" 
                class="username-input input" 
                placeholder="e.g. xXdAnKwEaBooXx" 
                required>
            
            <input 
                type="password" 
                name="password" 
                class="password-input input" 
                placeholder="e.g. password12345" 
                required>
            
            <button type="submit" class="send-button button" title="Login" name="submitlogin">Sign In</button>

';
		if (isset($msg)) /* line 31 */ {
			echo '                <span>';
			echo LR\Filters::escapeHtmlText($msg) /* line 32 */;
			echo '</span>
';
		}
		echo '        </div>
        <div class="right-wrap">
            <div class="notice-wrap">
                <span class="notice">New Here?</span>
                <p class="notice-text">Sign Up and gain access to new features!<br/>Get started with <span>Patrigios Market Analytics</span> today!</p>
            </div>
            <a href="?controller=User&action=register" class="switch-button button">
                Sign Up
            </a>
        </div>
    </form>
';
	}


	/** {block footer} on line 47 */
	public function blockFooter(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		$this->createTemplate('footer.latte', $this->params, 'include')->renderToContentType('html') /* line 48 */;
	}
}
