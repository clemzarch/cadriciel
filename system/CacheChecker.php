<?php

require('DocumentBuilder.php');

use DocumentBuilder as Builder;

class CacheChecker {
	public function check (string $filename) {
		$history = $this->getHistory();

		if (
			!array_key_exists($filename, $history) ||
			filemtime('pages/' . $filename) > $history[$filename] ||
			!file_exists(__DIR__ . '/public/' . $filename)
		) {
			(new Builder)->start($filename);
			$history[$filename] = filemtime('pages/' . $filename);
			file_put_contents(__DIR__ . '/cache-history.json', json_encode($history));
		}
	}

	private function getHistory(): array
	{
		if (!file_exists(__DIR__ . '/cache-history.json')) {
			return [];
		}

		try {
			$file = file_get_contents(__DIR__ . '/cache-history.json');

			return json_decode(
				$file,
				true,
				512,
				JSON_THROW_ON_ERROR
			);
		} catch (Exception $e) {
			return []; // don't care, i'm rebuilding
		}
	}
}
