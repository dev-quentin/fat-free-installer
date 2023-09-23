<?php

namespace FatFreeInstaller\Foundation;

use FatFreeInstaller\Foundation\Exception\ContainerException;

class Container
{
    private array $namespaces = [];

    private array $resolvedInstance = [];

    public function instance(string $namespace, $instance)
    {
        $this->resolvedInstance[$namespace] = $instance;
    }

    public function get(string $namespace)
    {
        return $this->resolveInstance($namespace);
    }

    public function make(string $namespace)
    {
        if (!is_null($this->resolveInstance($namespace))) {
            return $this->resolveInstance($namespace);
        }
        $this->resolvedInstance[$namespace] = $this->build($namespace);
        return $this->resolveInstance($namespace);
    }

    public function build(string $namespace)
    {
        try {
            $reflector = new \ReflectionClass($namespace);
        } catch (\ReflectionException $e) {
            throw new ContainerException(sprintf('Target class [%s] does not exist.', $namespace), 0, $e);
        }

        if (! $reflector->isInstantiable()) {
            throw new ContainerException(sprintf('Target [%s] is not instantiable.', $namespace));
        }

        $this->namespaces[] = $namespace;

        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            array_pop($this->namespaces);
            return new $namespace();
        }

        $dependencies = $constructor->getParameters();
        try {
            $instances = $this->resolveDependencies($dependencies);
        } catch (\Exception $e) {
            array_pop($this->namespaces);
            throw new ContainerException(sprintf('Dependencies classes does not exist.', $namespace), 0, $e);
        }

        return $reflector->newInstanceArgs($instances);
    }

    public function resolveDependencies(array $dependencies)
    {
        $resolveDependencies = [];

        foreach ($dependencies as $dependency) {
            if (!$dependency->hasType()) {
                return $resolveDependencies;
            }

            $type = $dependency->getType();
            $name = $type->getName();

            $class = $dependency->getDeclaringClass();
            if (!empty($class)) {
                $parent = $class->getParentClass();
                if ($type->getName() === 'self') {
                    $name = $class->getName();
                } elseif (!empty($parent) && $type->getName() === 'parent') {
                    $name = $parent->getName();
                }
            }

            if (class_exists($name)) {
                $resolveDependencies[] = $this->make($name);
            }
        }

        return $resolveDependencies;
    }

    public function resolveInstance(string $namespace)
    {
        return $this->resolvedInstance[$namespace] ?? null;
    }
}
