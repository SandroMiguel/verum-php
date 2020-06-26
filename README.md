<p align="center"><img src="http://sandromiguel.com/host/verum-php.png" alt="Verum PHP" /></p>

# Welcome to Verum PHP Validator

[![license](https://img.shields.io/badge/License-MIT-blue.svg?style=flat)](LICENSE)

**Server-Side Form Validation Library for PHP**

## Table of Contents

1. [Getting Started](#getting-started)
1. [Contributing](#contributing)
1. [Questions](#questions)
1. [License](#license)

## Getting Started

### Installation

Install Verum PHP with Composer

`composer require sandromiguel/verum-php`

### Usage

#### Simple usage example

Validate a simple registration form

```
$rules = [
    'name' => [
        'rules' => [
            'required',
        ],
    ],
    'email' => [
        'rules' => [
            'required',
            'email',
        ],
    ],
    'age' => [
        'rules' => [
            'numeric',
        ],
    ],
];

$validator = new Validator($_POST, $rules);

echo json_encode(
    [
        'valid'  => $validator->validate(),
        'errors' => $validator->getErrors(),
    ]
);
```

##### Valid form example

Input:

```
[
    'name' => 'John Doe',
    'email' => 'johndoe@example.com',
    'age' => '20',
]
```

Output:

```
{
    "valid": true,
    "errors": []
}
```

##### Invalid form example

Input:

```
[
    'name' => '',
    'email' => 'some text',
    'age' => 'some text',
]
```

Output:

```
{
    "valid": false,
    "errors": {
        "name": {
            "label": null,
            "rules": {
                "required": "This field is required."
            }
        },
        "email": {
            "label": null,
            "rules": {
                "email": "This field must be a valid email address."
            }
        },
        "age": {
            "label": null,
            "rules": {
                "numeric": "This field must be numeric."
            }
        }
    }
}
```

#### Use RuleEnum class

You can use the `RuleEnum` class to access all rule names.

```
$rules = [
    'name' => [
        'rules' => [
            RuleEnum::REQUIRED,
        ],
    ],
    ...
];
```

#### Specify the fields label

```
$rules = [
    'name' => [
        'label' => 'Name',
        'rules' => [
            RuleEnum::REQUIRED,
        ],
    ],
    ...
];
```

Output:

```
{
    ...
    "errors": {
        "name": {
            "label": "Name",
            "rules": {
                "required": 'The "Name" field is required.'
            }
        },
        ...
    }
}
```

#### Specify field labels for each language

```
$rules = [
    'name' => [
        'label' => [
            'en' => 'Name',
            'pt-pt' => 'Nome',
        ],
        'rules' => [
            RuleEnum::REQUIRED,
        ],
    ],
    ...
];
```

Output (pt-pt):

```
{
    ...
    "errors": {
        "name": {
            "label": "Nome",
            "rules": {
                "required": 'O campo "Nome" é obrigatório.'
            }
        },
        ...
    }
}
```

#### Specify the messages language

```
$validator = new Validator($_POST, $rules, 'pt-pt');
```

#### Specify the messages language using the `LangEnum` class

```
$validator = new Validator($_POST, $rules, LangEnum::PT_PT);
```

#### Specify a custom message

```
...
$validator = new Validator($_POST, $rules);
$validator->addSimpleCustomMessage('min_length', 'Min Length rule custom message');
...
```

Output example:

```
{
    ...
    "errors": {
        "name": {
            "label": "Name",
            "rules": {
                "min_length": "Min Length rule custom message"
            }
        },
        ...
    }
}
```

#### Specify a custom message with placeholders

```
...
$validator = new Validator($_POST, $rules);
$validator->addSimpleCustomMessage('min_length', 'Number of characters detected: {param:1}. Field name: "{param:2}".');
...
```

Output example:

```
{
    ...
    "errors": {
        "name": {
            "label": "Name",
            "rules": {
                "min_length": 'Number of characters detected: 5. Field name: "Name".'
            }
        },
        ...
    }
}
```

#### Specify a custom message for fields with and without a label

```
...
$validator = new Validator($_POST, $rules);
$validator->addCustomMessage(
    'required',
    'Custom message with label for required rule. Label: {param:1}.',
    'Custom message without label for required rule.'
);
...
```

Output - Field with label:

```
{
    ...
    "errors": {
        "name": {
            "label": "Name",
            "rules": {
                "required": 'Custom message with label for required rule. Label: Name.'
            }
        },
        ...
    }
}
```

Output - Field without label:

```
{
    ...
    "errors": {
        "name": {
            "label": null,
            "rules": {
                "required": "Custom message without label for required rule."
            }
        },
        ...
    }
}
```

#### Specify multiple custom messages at once

```
...
$validator = new Validator($_POST, $rules);
$validator->addCustomMessages(
    [
        'min_length' => 'Custom message for the "min_length" rule.',
        'required' => 'Custom message for the "required" rule.',
        // other messages ...
    ]
);
...
```

#### Specify multiple custom messages at once for fields with and without a label

```
...
$validator = new Validator($_POST, $rules);
$validator->addCustomMessages(
    [
        'numeric' => [
            'withLabel' => 'Custom message with label for "numeric" rule. Label: {param:1}.',
            'withoutLabel' => 'Custom message without label for "numeric" rule.',
        ],
        'min_length' => [
            'withLabel' => 'Custom message with label for "min_length" rule. Label: {param:2}, value: {param:1}.',
            'withoutLabel' => 'Custom message without label for "min_length" rule. Value: {param:1}.',
        ],
        // other messages ...
    ]
);
...
```

## Contributing

Want to contribute? All contributions are welcome. Read the
[contributing guide](CONTRIBUTING.md).

## Questions

If you have questions tweet me at [@sandro_m_m](https://twitter.com/sandro_m_m)
or [open an issue](../../issues/new).

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file
for details

**~ sharing is caring ~**
