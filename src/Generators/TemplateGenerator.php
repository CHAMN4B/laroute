<?php

namespace Chamnab\Laroute\Generators;

use Illuminate\Filesystem\Filesystem;
use Chamnab\Laroute\Compilers\CompilerInterface as Compiler;

class TemplateGenerator implements GeneratorInterface
{
    /**
     * The compiler instance.
     *
     * @var \Chamnab\Laroute\Compilers\CompilerInterface
     */
    protected $compiler;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Create a new template generator instance.
     *
     * @param $compiler   \Chamnab\Laroute\Compilers\CompilerInterface
     * @param $filesystem \Illuminate\Filesystem\Filesystem
     */
    public function __construct(Compiler $compiler, Filesystem $filesystem)
    {
        $this->compiler = $compiler;

        $this->filesystem = $filesystem;
    }

    /**
     * Compile the template.
     *
     * @param $templatePath
     * @param $templateData
     * @param $filePath
     *
     * @return string
     */
    public function compile($templatePath, array $templateData, $filePath)
    {
        $template = $this->filesystem->get($templatePath);

        $compiled = $this->compiler->compile($template, $templateData);

        $this->makeDirectory(dirname($filePath));

        $this->filesystem->put($filePath, $compiled);

        return $filePath;
    }

    public function makeDirectory($directory)
    {
        if (! $this->filesystem->isDirectory($directory)) {
            $this->filesystem->makeDirectory($directory, 0777, true);
        }
    }
}
