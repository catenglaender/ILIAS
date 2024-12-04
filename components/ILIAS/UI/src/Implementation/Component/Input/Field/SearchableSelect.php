<?php

declare (strict_types=1);

namespace ILIAS\UI\Implementation\Component\Input\Field;

use _PHPStan_9815bbba4\Symfony\Component\Console\Exception\LogicException;
use ILIAS\Data\Factory as DataFactory;
use ILIAS\Language\Language;
use ILIAS\Refinery\Constraint;
use ILIAS\UI\Component as C;
use ILIAS\UI\Component\Input\Field\MultiSelect;
use ILIAS\UI\Component\Input\Field\Radio;
use ILIAS\UI\Implementation\Component\Input\Field\FormInput;
use ILIAS\UI\Implementation\Component\Input\Group as GroupInternals;
use ILIAS\UI\Implementation\Component\Input\Field\Group as Group;
use ILIAS\UI\Implementation\Component\Input\InputData;
use ILIAS\UI\Implementation\Component\JavaScriptBindable;
use ILIAS\UI\Implementation\Component\Triggerer;

class SearchableSelect extends Group implements C\Input\Field\SearchableSelect {
    public function __construct(
        DataFactory $data_factory,
        \ILIAS\Refinery\Factory $refinery,
        Language $lng,
        MultiSelect|Radio $input,
        string $label,
        ?string $byline = null
    ) {
        parent::__construct($data_factory, $refinery, $lng, [$input], $label, $byline);
    }
}
