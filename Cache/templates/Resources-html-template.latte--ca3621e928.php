<?php

use Latte\Runtime as LR;

/** source: Resources/html/template.latte */
final class Template_ca3621e928 extends Latte\Runtime\Template
{
	public const Source = 'Resources/html/template.latte';


	public function main(array $ʟ_args): void
	{
	}


	public function prepare(): array
	{
		extract($this->params);

		$this->parentName = '@layout.latte';
		$this->createTemplate('header.latte', $this->params, "import")->render() /* line 2 */;
		$this->createTemplate('items.latte', $this->params, "import")->render() /* line 3 */;
		$this->createTemplate('content.latte', $this->params, "import")->render() /* line 4 */;
		$this->createTemplate('footer.latte', $this->params, "import")->render() /* line 5 */;
		return get_defined_vars();
	}
}
