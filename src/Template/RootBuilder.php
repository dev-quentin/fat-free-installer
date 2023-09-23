<?php

namespace FatFreeInstaller\Template;

class RootBuilder
{
    protected string $path;

    protected string $pathBuilder;

    final public function __construct(string $path)
    {
        $this->path = trim($path, "/");
        if (!is_dir($this->path) && !mkdir($this->path)) {
            throw new Exception("Can't create dir {$this->path}", 1);
        }

        
        $reflector = new \ReflectionClass(static::class);
        $pathinfo = pathinfo($reflector->getFileName());
        $this->pathBuilder = $pathinfo['dirname'];
    }

    public function builProject()
    {
        copy($this->getComposerFile(), join(DIRECTORY_SEPARATOR, [$this->path, "composer.json"]));

        $this->buildFolder();
        $this->buildFile();
    }

    public function fetchTree(): array
    {
        return [];
    }

    public function fileList(): array
    {
        return [];
    }

    final protected function buildFolder()
    {
        foreach ($this->fetchTree() as $pathFolder) {
            if (!mkdir(join(DIRECTORY_SEPARATOR, [$this->path, $pathFolder]), 775, true)) {
                throw new Exception("Can't create dir " . join(DIRECTORY_SEPARATOR, [$this->path, $pathFolder]), 1);
            }
        }
    }

    final protected function buildFile()
    {
        foreach ($this->fileList() as $file => $pathFolder) {
            if (!copy(join(DIRECTORY_SEPARATOR, [$this->pathBuilder, "Files", $file]), join(DIRECTORY_SEPARATOR, [$this->path, $pathFolder, str_replace('.exemple', '', $file)]))) {
                throw new Exception("Can't create file " . $file, 1);
            }
        }
    }

    final protected function getComposerFile()
    {
        return join(DIRECTORY_SEPARATOR, [$this->pathBuilder, 'composer.json.exemple']);
    }
}