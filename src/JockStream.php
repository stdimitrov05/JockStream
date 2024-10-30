<?php

namespace Stdimitrov\Jockstream;

use Stdimitrov\Jockstream\Config\Injectable;

class JockStream extends Injectable
{

    public function listSingleJoke(): array
    {
        return $this->getService('jockStreamController')->fetchJoke();
    }

    public function listMultipleJoke(int $limit): array
    {
        return $this->getService('jockStreamController')->fetchJokes($limit);
    }
}