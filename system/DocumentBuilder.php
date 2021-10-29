<?php

class DocumentBuilder
{
	public function start(string $filename)
	{
		$content = file_get_contents('../pages/' . $filename);

		is_dir('public') ?: mkdir('public');

		$document = $this->appendContent($content);

		$this->addCSS($filename, $document);
		$this->addJS($filename, $document);

		$document->saveHTMLFile('public/' . $filename);
	}

	private function appendContent(string $content): DOMDocument
	{
		$document = new DOMDocument;
		@$document->loadHTML($content);

		$nodes = $document->getElementsByTagName('z');

		foreach ($nodes as $node) {
			$inner = file_get_contents(
				'../blocks/' . $node->textContent . '.html'
			);

			// replace arguments
			foreach ($node->attributes as $attribute) {
				$inner = str_replace(
					'$' . $attribute->name,
					$attribute->value,
					$inner
				);
			}

			$motherfucker = $this->appendContent($inner)->lastChild->lastChild;

			$node->parentNode->replaceChild($document->importNode($motherfucker), $node);
		}

		return $document;
	}

	private function addCSS(string $filename, DOMDocument $dom)
	{
		$possibleCSS = 'pages/' . str_replace('.html', '.css', $filename);
		$rules = file_exists('../' . $possibleCSS) ? file_get_contents('../' . $possibleCSS) : null;

		if ($rules) {
			$cssTag = $dom->createElement('link');
			$cssTag->setAttribute('href', $possibleCSS);
			$cssTag->setAttribute('rel', 'stylesheet');

			$dom->appendChild($cssTag);
		}
	}

	private function addJS(string $filename, DOMDocument $dom)
	{
		$possibleJS = 'pages/' . str_replace('.html', '.js', $filename);
		$script = file_exists('../' . $possibleJS) ? file_get_contents('../' . $possibleJS) : null;

		if ($script) {
			$jsTag = $dom->createElement('script');
			$jsTag->setAttribute('src', $possibleJS);

			$dom->appendChild($jsTag);
		}
	}
}
