<?php

use Latte\Runtime as LR;

/** source: Resources/html/templates/register.latte */
final class Template_ddb6cd7fce extends Latte\Runtime\Template
{
	public const Source = 'Resources/html/templates/register.latte';

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
		$this->renderBlock('footer', get_defined_vars()) /* line 60 */;
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
		echo '    Register
';
	}


	/** {block content} on line 7 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '    <form action="/php/actions/signUp.php" method="post" class="input-register">
        <div class="left-wrap">
            <div class="notice-wrap">
                <span class="notice">Create a new Account</span>
                <p class="notice-text">get started with <span>Patrigios Market Analytics</span> today!</p>
            </div>
            <input 
                type="text" 
                name="username" 
                class="username-input input" 
                placeholder="e.g. xXdAnKwEaBooXx" 
                required>

                <input 
                type="email" 
                name="email" 
                class="email-input input" 
                placeholder="e.g. your@mom.adult" 
                required>
            
            <input 
                type="password" 
                name="password" 
                class="password-input input" 
                placeholder="e.g. password12345" 
                required>
            
            <input 
                type="password" 
                name="confirm_password" 
                class="confirm-password-input input" 
                placeholder="↑ this" 
                required>

';
		if (isset($msg)) /* line 42 */ {
			echo '                <span>';
			echo LR\Filters::escapeHtmlText($msg) /* line 43 */;
			echo '</span>
';
		}
		echo '            
            <button type="submit" class="send-button button" title="Register" name="submitregister">Sign Up</button> 
        </div>
        <div class="right-wrap">
            <div class="notice-wrap">
                <span class="notice">Already Here?</span>
                <p class="notice-text">Sign In and get started</p>
            </div>
            <a href="?controller=User&action=login" class="switch-button button">
                Sign In
            </a>
        </div>
    </form>
';
	}


	/** {block footer} on line 60 */
	public function blockFooter(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		$this->createTemplate('footer.latte', $this->params, 'include')->renderToContentType('html') /* line 61 */;
	}
}
