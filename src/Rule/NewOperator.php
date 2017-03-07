<?php

namespace anasinnyk\Rule;

use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Rule\MethodAware;

class NewOperator extends AbstractRule implements MethodAware
{
    const ANONYMOUS_CLASS = 1;

    public function apply(AbstractNode $node)
    {
        $ignoreList = explode(',', $this->getStringProperty('ignoreList')) ?? [];
        foreach ($node->findChildrenOfType('AllocationExpression') as $new) {
            $classNode = $new->findChildrenOfType('ClassReference');
            $anonymousNode = $new->findChildrenOfType('AnonymousClass');

            if (count($classNode)) {
                $class = ltrim(array_shift($classNode)->getImage(), '\\');

                $allow = preg_match('/Exception$/', $class)
                    ? $this->getBooleanProperty('isAllowException')
                    : in_array($class, $ignoreList);
                if (!$allow) {
                    $this->addViolation($new, [$class]);
                }
            }

            if (count($anonymousNode) && !$this->getBooleanProperty('isAllowAnonymous')) {
                $this->addViolation($new, ['anonymous']);
            }
        }
    }
}
