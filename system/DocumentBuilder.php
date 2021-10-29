<?php

class DocumentBuilder
{
	public function start(string $filename)
	{
		$content = file_get_contents('pages/' . $filename);

		is_dir(__DIR__ . '/public') ?: mkdir(__DIR__ . '/public');

		$this->appendContent($content)->saveHTMLFile(__DIR__ . '/public/' . $filename);
	}

	private function appendContent(string $content): DOMDocument
	{
		$document = new DOMDocument;
		@$document->loadHTML($content);

		$nodes = $document->getElementsByTagName('z');

		foreach ($nodes as $node) {
			$inner = file_get_contents(
				'blocks/' . $node->textContent . '.html'
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
}
