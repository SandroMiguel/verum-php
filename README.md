<p align="center"><img src="http://sandromiguel.com/host/verum-php.png" alt="Verum PHP" /></p>

# Welcome to Verum PHP Validator

[![License](https://poser.pugx.org/sandromiguel/verum-php/license)](//packagist.org/packages/sandromiguel/verum-php)
[![Latest Stable Version](https://poser.pugx.org/sandromiguel/verum-php/v)](//packagist.org/packages/sandromiguel/verum-php)
[![Dependents](https://poser.pugx.org/sandromiguel/verum-php/dependents)](//packagist.org/packages/sandromiguel/verum-php)
[![Build Status](https://travis-ci.com/SandroMiguel/verum-php.svg?branch=master)](https://travis-ci.com/SandroMiguel/verum-php)

**Server-Side Form Validation Library for PHP**

## Table of Contents

1. [Getting Started](#getting-started)
1. [Available Rules](#available-rules)
1. [Contributing](#contributing)
1. [Questions](#questions)
1. [License](#license)

## Getting Started

### Installation

Install Verum PHP with Composer

```sh
composer require sandromiguel/verum-php
```

### Usage

#### Simple usage example

Validate a simple registration form

```
use Verum\Validator;

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

#### Use `RuleEnum` class

You can use the `RuleEnum` class to access all rule names.

```
use Verum\Validator;
use Verum\Enum\RuleEnum;

$rules = [
    'name' => [
        'rules' => [
            RuleEnum::REQUIRED,
        ],
    ],
    ...
];
```

#### Specify the fields label (naming inputs)

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
use Verum\Validator;
use Verum\Enum\LangEnum;

...

$validator = new Validator($_POST, $rules, LangEnum::PT_PT);
```

#### Specify a custom error message

-   Useful to override the default error message.
-   Useful for localization.

```
...
$validator = new Validator($_POST, $rules);
$validator->addSimpleCustomMessage('min_length', 'Min Length rule custom error message');
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
                "min_length": "Min Length rule custom error message"
            }
        },
        ...
    }
}
```

#### Specify a custom error message with placeholders

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

#### Specify a custom error message for fields with and without a label

```
...
$validator = new Validator($_POST, $rules);
$validator->addCustomMessage(
    'required',
    'Custom error message with label for required rule. Label: {param:1}.',
    'Custom error message without label for required rule.'
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
                "required": 'Custom error message with label for required rule. Label: Name.'
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
                "required": "Custom error message without label for required rule."
            }
        },
        ...
    }
}
```

#### Specify multiple custom error messages at once

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

#### Specify multiple custom error messages at once for fields with and without a label

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

## Available Rules

### alpha

Checks whether the value contains only alphabetic characters.

```
$rules = [
    'nickname' => [
        'label' => 'Nickname',
        'rules' => [
            RuleEnum::ALPHA,
        ],
    ],
];
```

| Value              |       alpha        |  alpha + required  |
| ------------------ | :----------------: | :----------------: |
| null               | :heavy_check_mark: |        :x:         |
| ''                 | :heavy_check_mark: |        :x:         |
| '0'                |        :x:         |        :x:         |
| 0                  |        :x:         |        :x:         |
| false              |        :x:         |        :x:         |
| []                 |        :x:         |        :x:         |
| -1                 |        :x:         |        :x:         |
| 1                  |        :x:         |        :x:         |
| true               |        :x:         |        :x:         |
| 'text'             | :heavy_check_mark: | :heavy_check_mark: |
| 'text with spaces' |        :x:         |        :x:         |

### alpha_numeric

Checks whether the value contains only alphanumeric characters.

```
$rules = [
    'nickname' => [
        'label' => 'Nickname',
        'rules' => [
            RuleEnum::ALPHA_NUMERIC,
        ],
    ],
];
```

| Value              |   alpha_numeric    | alpha_numeric + required |
| ------------------ | :----------------: | :----------------------: |
| null               | :heavy_check_mark: |           :x:            |
| ''                 | :heavy_check_mark: |           :x:            |
| '0'                | :heavy_check_mark: |    :heavy_check_mark:    |
| 0                  | :heavy_check_mark: |    :heavy_check_mark:    |
| false              |        :x:         |           :x:            |
| []                 |        :x:         |           :x:            |
| -1                 |        :x:         |           :x:            |
| 1                  | :heavy_check_mark: |    :heavy_check_mark:    |
| true               |        :x:         |           :x:            |
| 'text'             | :heavy_check_mark: |    :heavy_check_mark:    |
| 'text with spaces' |        :x:         |           :x:            |

### between

Checks whether the value is between two values.

```
$rules = [
    'age' => [
        'label' => 'Age',
        'rules' => [
            RuleEnum::BETWEEN => [12, 29],
        ],
    ],
];
```

| Value       |  between [1, 10]   | between [1, 10] + required |
| ----------- | :----------------: | :------------------------: |
| null        | :heavy_check_mark: |            :x:             |
| ''          | :heavy_check_mark: |            :x:             |
| '0'         |        :x:         |            :x:             |
| 0           |        :x:         |            :x:             |
| false       |        :x:         |            :x:             |
| []          |        :x:         |            :x:             |
| -1          |        :x:         |            :x:             |
| 1           | :heavy_check_mark: |     :heavy_check_mark:     |
| true        |        :x:         |            :x:             |
| 'some text' |        :x:         |            :x:             |

### between_length

Checks whether the number of characters of the value is between min and max values.

```
$rules = [
    'nickname' => [
        'label' => 'Nickname',
        'rules' => [
            RuleEnum::BETWEEN_LENGTH => [3, 15],
        ],
    ],
];
```

| Value                     | between_length [5,25] | between_length [5,25] + required |
| ------------------------- | :-------------------: | :------------------------------: |
| null                      |  :heavy_check_mark:   |               :x:                |
| ''                        |  :heavy_check_mark:   |               :x:                |
| '0'                       |          :x:          |               :x:                |
| 0                         |          :x:          |               :x:                |
| false                     |          :x:          |               :x:                |
| []                        |          :x:          |               :x:                |
| -1                        |          :x:          |               :x:                |
| 1                         |          :x:          |               :x:                |
| 12345                     |  :heavy_check_mark:   |        :heavy_check_mark:        |
| true                      |          :x:          |               :x:                |
| 'text'                    |          :x:          |               :x:                |
| 'text with 23 characters' |  :heavy_check_mark:   |        :heavy_check_mark:        |

### boolean_value

Checks whether the value is a boolean value.
Returns true for 1/0, '1'/'0', 'on'/'off', 'yes'/'no', true/false.

```
$rules = [
    'light' => [
        'label' => 'Light',
        'rules' => [
            RuleEnum::BOOLEAN_VALUE,
        ],
    ],
];
```

| Value  |   boolean_value    | boolean_value + required |
| ------ | :----------------: | :----------------------: |
| null   | :heavy_check_mark: |           :x:            |
| ''     | :heavy_check_mark: |           :x:            |
| '0'    | :heavy_check_mark: |    :heavy_check_mark:    |
| 0      | :heavy_check_mark: |    :heavy_check_mark:    |
| false  | :heavy_check_mark: |    :heavy_check_mark:    |
| []     |        :x:         |           :x:            |
| -1     |        :x:         |           :x:            |
| '1'    | :heavy_check_mark: |    :heavy_check_mark:    |
| 1      | :heavy_check_mark: |    :heavy_check_mark:    |
| true   | :heavy_check_mark: |    :heavy_check_mark:    |
| 'text' |        :x:         |           :x:            |
| 'on'   | :heavy_check_mark: |    :heavy_check_mark:    |
| 'off'  | :heavy_check_mark: |    :heavy_check_mark:    |
| 'yes'  | :heavy_check_mark: |    :heavy_check_mark:    |
| 'no'   | :heavy_check_mark: |    :heavy_check_mark:    |

### contains

Checks whether the value is in an array.

```
$rules = [
    'priority' => [
        'label' => 'Priority',
        'rules' => [
            RuleEnum::CONTAINS => ['low', 'high'],
        ],
    ],
];
```

### date

Checks whether the value is a valid date (Y-m-d) or a custom format.

```
$rules = [
    'dob' => [
        'label' => 'Date of birth',
        'rules' => [
            RuleEnum::DATE,
        ],
    ],
];
```

### email

Checks whether the value has a valid email format.

```
$rules = [
    'email' => [
        'label' => 'Email',
        'rules' => [
            RuleEnum::EMAIL,
        ],
    ],
];
```

### equals

Checks whether the value is equal to another.

```
$rules = [
    'repeat_password' => [
        'label' => 'Repeat Password',
        'rules' => [
            RuleEnum::EQUALS => ['password'],
        ],
    ],
];
```

### file_max_size

Checks whether the file size does not exceed a given value.

Enter a value in bytes.

```
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::FILE_MAX_SIZE => [102400],
        ],
    ],
];
```

### file_mime_type

Checks whether the file type is allowed.

```
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::FILE_MIME_TYPE => ['image/png', 'image/jpeg'],
        ],
    ],
];
```

### float_number

Checks whether the value is a floating point number.

```
$rules = [
    'price' => [
        'label' => 'Price',
        'rules' => [
            RuleEnum::FLOAT_NUMBER,
        ],
    ],
];
```

### image_max_height

Checks whether the image height does not exceed a given value.

```
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::IMAGE_MAX_HEIGHT => [600],
        ],
    ],
];
```

### image_max_width

Checks whether the image width does not exceed a given value.

```
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::IMAGE_MAX_WIDTH => [1000],
        ],
    ],
];
```

### image_min_height

Checks whether the image height is not less than a given value.

```
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::IMAGE_MIN_HEIGHT => [300],
        ],
    ],
];
```

### image_min_width

Checks whether the image width is not less than a given value.

```
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::IMAGE_MIN_WIDTH => [500],
        ],
    ],
];
```

### ip

Checks whether the value is a valid IP address.

```
$rules = [
    'ip' => [
        'label' => 'IP',
        'rules' => [
            RuleEnum::IP,
        ],
    ],
];
```

### ipv4

Checks whether the value is a valid IPv4 address.

```
$rules = [
    'ipv4' => [
        'label' => 'IPv4',
        'rules' => [
            RuleEnum::IPV4,
        ],
    ],
];
```

### ipv6

Checks whether the value is a valid IPv6 address.

```
$rules = [
    'ipv6' => [
        'label' => 'IPv6',
        'rules' => [
            RuleEnum::IPV6,
        ],
    ],
];
```

### max

Checks whether the value does not exceed a given value.

```
$rules = [
    'people' => [
        'label' => 'People',
        'rules' => [
            RuleEnum::MAX => [5],
        ],
    ],
];
```

### max_length

Checks whether the number of characters of the value does not exceed a given value.

```
$rules = [
    'nickname' => [
        'label' => 'Nickname',
        'rules' => [
            RuleEnum::MAX_LENGTH => [15],
        ],
    ],
];
```

### min

Checks whether the value is not less than a given value.

```
$rules = [
    'people' => [
        'label' => 'People',
        'rules' => [
            RuleEnum::MIN => [2],
        ],
    ],
];
```

### min_length

Checks whether the number of characters of the value is not less than a given value.

```
$rules = [
    'nickname' => [
        'label' => 'Nickname',
        'rules' => [
            RuleEnum::MIN_LENGTH => [2],
        ],
    ],
];
```

### numeric

Checks whether the value is numeric.

```
$rules = [
    'age' => [
        'label' => 'Age',
        'rules' => [
            RuleEnum::NUMERIC,
        ],
    ],
];
```

### regex

Checks whether the value matches a given regular expression.

```
$rules = [
    'path' => [
        'label' => 'Path',
        'rules' => [
            RuleEnum::REGEX => ['/client/[0-9a-f]+$'],
        ],
    ],
];
```

### required

Checks whether the value is not empty.

```
$rules = [
    'name' => [
        'label' => 'Name',
        'rules' => [
            RuleEnum::REQUIRED,
        ],
    ],
];
```

| Value       | required           |
| ----------- | ------------------ |
| null        | :x:                |
| ''          | :x:                |
| '0'         | :heavy_check_mark: |
| 0           | :heavy_check_mark: |
| false       | :heavy_check_mark: |
| []          | :x:                |
| -1          | :heavy_check_mark: |
| 1           | :heavy_check_mark: |
| true        | :heavy_check_mark: |
| 'some text' | :heavy_check_mark: |

### slug

Checks whether the value is a valid Slug (e.g. hello-world_123).

```
$rules = [
    'slug' => [
        'label' => 'Slug',
        'rules' => [
            RuleEnum::SLUG,
        ],
    ],
];
```

### url

Checks whether the value is a valid URL.

```
$rules = [
    'url' => [
        'label' => 'URL',
        'rules' => [
            RuleEnum::URL,
        ],
    ],
];
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
