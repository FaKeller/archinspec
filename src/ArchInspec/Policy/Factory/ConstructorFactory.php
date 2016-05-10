<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Fabian Keller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace ArchInspec\Policy\Factory;

/**
 * Creates policies by passing the options to the policy class constructor.
 */
class ConstructorFactory extends AbstractPolicyFactory
{
    /** @var string */
    private $policyClassName;
    /** @var string */
    private $names;

    /**
     * Sets the class name of the policy to instantiate on factory invocation.
     *
     * @param string|string[] $names the name of the policy
     * @param string $policyClassName
     */
    public function __construct($names, $policyClassName)
    {
        if (!is_array($names)) {
            $names = [$names];
        }
        $this->names = $names;
        $this->policyClassName = $policyClassName;
    }

    /**
     * {@inheritdoc}
     */
    public function factory($name, $target = null, array $options = null)
    {
        if (!in_array($name, $this->supportedPolicies())) {
            throw new \RuntimeException(sprintf("This ConstructorFactory can only factory policies of types [%s], but type %s was requested!", join(",", $this->names), $name));
        }
        $class = $this->policyClassName;
        return new $class($target, $options);
    }


    /**
     * {@inheritdoc}
     */
    public function supportedPolicies()
    {
        return $this->names;
    }
}