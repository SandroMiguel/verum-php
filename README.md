<p align="center"><img src="http://sandromiguel.com/host/verum-php.png" alt="Verum PHP" /></p>

[![License](https://poser.pugx.org/sandromiguel/verum-php/license)](//packagist.org/packages/sandromiguel/verum-php)
[![Latest Stable Version](https://poser.pugx.org/sandromiguel/verum-php/v)](//packagist.org/packages/sandromiguel/verum-php)
[![Dependents](https://poser.pugx.org/sandromiguel/verum-php/dependents)](//packagist.org/packages/sandromiguel/verum-php)

# Verum PHP

Verum PHP is a server-side validation library for PHP that allows you to validate arrays (with file support) with ease. It comes with custom error messages, rules, built-in translations, and zero dependencies.

**Server-Side Validation Library for PHP**

-   Validate arrays (with file support)
-   Custom error messages
-   Custom rules
-   Built-in translations
-   Zero dependencies

## Table of Contents

1. [Getting Started](#getting-started)
1. [Usage](#usage)
1. [Custom validations](#custom-validations)
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

Validate a simple registration form (name, email and age)

```php
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

```json
[
    'name' => 'John Doe',
    'email' => 'johndoe@example.com',
    'age' => '20',
]
```

Output:

```json
{
    "valid": true,
    "errors": []
}
```

##### Invalid form example

Input:

```json
[
    'name' => '',
    'email' => 'some text',
    'age' => 'some text',
]
```

Output:

```json
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

```php
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

```php
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

```json
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

```php
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

```json
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

You can use some built-in translations:

-   `'en'` -> English (default)
-   `'nl-nl'` -> Dutch
-   `'pt-pt'` -> Portuguese-Portugal
-   `'pt-br'` -> Portuguese-Brazil

```php
$validator = new Validator($_POST, $rules, 'pt-pt');
```

#### Specify the messages language using the `LangEnum` class

```php
use Verum\Validator;
use Verum\Enum\LangEnum;

...

$validator = new Validator($_POST, $rules, LangEnum::PT_PT);
```

#### Specify a custom error message

-   Useful to override the default error message.
-   Useful for localization.

```php
...
$validator = new Validator($_POST, $rules);
$validator->addSimpleCustomMessage('min_length', 'Min Length rule custom error message');
...
```

Output example:

```json
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

```php
...
$validator = new Validator($_POST, $rules);
$validator->addSimpleCustomMessage('min_length', 'Number of characters detected: {param:1}. Field name: "{param:2}".');
...
```

Output example:

```json
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

```php
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

```json
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

```json
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

```php
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

```php
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

#### Handling Multi-Name Fields

With Verum PHP, you can handle multi-name fields more effectively. These are fields that include language identifiers or other variations in their names. For example, if you have fields like `title.en`, `title.pt`, `description.en`, and `description.pt`, you can specify rules for them using wildcards.

```php
$rules = [
    'title.*' => [
        'rules' => [
            RuleEnum::REQUIRED,
        ],
    ],
    'description.*' => [
        'rules' => [
            RuleEnum::REQUIRED,
            RuleEnum::MIN_LENGTH => 10,
        ],
    ],
];

$validator = new Validator($_POST, $rules);
// ...
```

Output example:

```json
{
    "valid": false,
    "errors": {
        "title.en": {
            "label": null,
            "rules": {
                "required": "This field is required."
            }
        },
        "title.pt": {
            "label": null,
            "rules": {
                "required": "This field is required."
            }
        },
        "description.en": {
            "label": null,
            "rules": {
                "required": "This field is required.",
                "min_length": "This field must be at least 10 characters long."
            }
        },
        "description.pt": {
            "label": null,
            "rules": {
                "required": "This field is required.",
                "min_length": "This field must be at least 10 characters long."
            }
        }
    }
}
```

## Custom validations

You can use your custom validations and inject the error message.

```php
if ($myCustomValidationFail) {
    $validator->addError(
        'someFieldName',
        'Some field name',
        ['no_duplicate' => 'A user already exists with that username')]
    );
    // ...
}
```

## Available Rules

1. [alpha](#alpha)
1. [alpha_numeric](#alpha_numeric)
1. [between](#between)
1. [between_length](#between_length)
1. [boolean_value](#boolean_value)
1. [contains](#contains)
1. [date](#date)
1. [email](#email)
1. [equals](#equals)
1. [file_max_size](#file_max_size)
1. [file_mime_type](#file_mime_type)
1. [float_number](#float_number)
1. [image_max_height](#image_max_height)
1. [image_max_width](#image_max_width)
1. [image_min_height](#image_min_height)
1. [image_min_width](#image_min_width)
1. [integer](#integer)
1. [ip](#ip)
1. [ipv4](#ipv4)
1. [ipv6](#ipv6)
1. [max](#max)
1. [max_length](#max_length)
1. [min](#min)
1. [min_length](#min_length)
1. [numeric](#numeric)
1. [regex](#regex)
1. [required](#required)
1. [slug](#slug)
1. [url](#url)

### alpha

Checks whether the value contains only alphabetic characters.

```php
$rules = [
    'nickname' => [
        'label' => 'Nickname',
        'rules' => [
            RuleEnum::ALPHA,
        ],
    ],
];
```

| Value                |       alpha        |  alpha + required  |
| -------------------- | :----------------: | :----------------: |
| `null`               | :heavy_check_mark: |        :x:         |
| `''`                 | :heavy_check_mark: |        :x:         |
| `'0'`                |        :x:         |        :x:         |
| `0`                  |        :x:         |        :x:         |
| `false`              |        :x:         |        :x:         |
| `[]`                 |        :x:         |        :x:         |
| `-1`                 |        :x:         |        :x:         |
| `1`                  |        :x:         |        :x:         |
| `true`               |        :x:         |        :x:         |
| `'text'`             | :heavy_check_mark: | :heavy_check_mark: |
| `'text with spaces'` |        :x:         |        :x:         |

### alpha_numeric

Checks whether the value contains only alphanumeric characters.

```php
$rules = [
    'nickname' => [
        'label' => 'Nickname',
        'rules' => [
            RuleEnum::ALPHA_NUMERIC,
        ],
    ],
];
```

| Value                |   alpha_numeric    | alpha_numeric + required |
| -------------------- | :----------------: | :----------------------: |
| `null`               | :heavy_check_mark: |           :x:            |
| `''`                 | :heavy_check_mark: |           :x:            |
| `'0'`                | :heavy_check_mark: |    :heavy_check_mark:    |
| `0`                  | :heavy_check_mark: |    :heavy_check_mark:    |
| `false`              |        :x:         |           :x:            |
| `[]`                 |        :x:         |           :x:            |
| `-1`                 |        :x:         |           :x:            |
| `1`                  | :heavy_check_mark: |    :heavy_check_mark:    |
| `true`               |        :x:         |           :x:            |
| `'text'`             | :heavy_check_mark: |    :heavy_check_mark:    |
| `'text with spaces'` |        :x:         |           :x:            |

### between

Checks whether the value is between two values.

```php
$rules = [
    'age' => [
        'label' => 'Age',
        'rules' => [
            RuleEnum::BETWEEN => [12, 29],
        ],
    ],
];
```

| Value         |  between [1, 10]   | between [1, 10] + required |
| ------------- | :----------------: | :------------------------: |
| `null`        | :heavy_check_mark: |            :x:             |
| `''`          | :heavy_check_mark: |            :x:             |
| `'0'`         |        :x:         |            :x:             |
| `0`           |        :x:         |            :x:             |
| `false`       |        :x:         |            :x:             |
| `[]`          |        :x:         |            :x:             |
| `-1`          |        :x:         |            :x:             |
| `1`           | :heavy_check_mark: |     :heavy_check_mark:     |
| `true`        |        :x:         |            :x:             |
| `'some text'` |        :x:         |            :x:             |

### between_length

Checks whether the number of characters of the value is between min and max values.

```php
$rules = [
    'nickname' => [
        'label' => 'Nickname',
        'rules' => [
            RuleEnum::BETWEEN_LENGTH => [3, 15],
        ],
    ],
];
```

| Value                       | between_length [5,25] | between_length [5,25] + required |
| --------------------------- | :-------------------: | :------------------------------: |
| `null`                      |  :heavy_check_mark:   |               :x:                |
| `''`                        |  :heavy_check_mark:   |               :x:                |
| `'0'`                       |          :x:          |               :x:                |
| `0`                         |          :x:          |               :x:                |
| `false`                     |          :x:          |               :x:                |
| `[]`                        |          :x:          |               :x:                |
| `-1`                        |          :x:          |               :x:                |
| `1`                         |          :x:          |               :x:                |
| `12345`                     |  :heavy_check_mark:   |        :heavy_check_mark:        |
| `true`                      |          :x:          |               :x:                |
| `'text'`                    |          :x:          |               :x:                |
| `'text with 23 characters'` |  :heavy_check_mark:   |        :heavy_check_mark:        |

### boolean_value

Checks whether the value is a boolean value.
Returns true for 1/0, '1'/'0', 'on'/'off', 'yes'/'no', true/false.

```php
$rules = [
    'light' => [
        'label' => 'Light',
        'rules' => [
            RuleEnum::BOOLEAN_VALUE,
        ],
    ],
];
```

| Value    |   boolean_value    | boolean_value + required |
| -------- | :----------------: | :----------------------: |
| `null`   | :heavy_check_mark: |           :x:            |
| `''`     | :heavy_check_mark: |           :x:            |
| `'0'`    | :heavy_check_mark: |    :heavy_check_mark:    |
| `0`      | :heavy_check_mark: |    :heavy_check_mark:    |
| `false`  | :heavy_check_mark: |    :heavy_check_mark:    |
| `[]`     |        :x:         |           :x:            |
| `-1`     |        :x:         |           :x:            |
| `'1'`    | :heavy_check_mark: |    :heavy_check_mark:    |
| `1`      | :heavy_check_mark: |    :heavy_check_mark:    |
| `true`   | :heavy_check_mark: |    :heavy_check_mark:    |
| `'text'` |        :x:         |           :x:            |
| `'on'`   | :heavy_check_mark: |    :heavy_check_mark:    |
| `'off'`  | :heavy_check_mark: |    :heavy_check_mark:    |
| `'yes'`  | :heavy_check_mark: |    :heavy_check_mark:    |
| `'no' `  | :heavy_check_mark: |    :heavy_check_mark:    |

### contains

Checks whether the value is in an array.

```php
$rules = [
    'priority' => [
        'label' => 'Priority',
        'rules' => [
            RuleEnum::CONTAINS => ['low', 'high'],
        ],
    ],
];
```

| Value    | contains ['low','high'] | contains ['low','high'] + required |
| -------- | :---------------------: | :--------------------------------: |
| `null`   |   :heavy_check_mark:    |                :x:                 |
| `''`     |   :heavy_check_mark:    |                :x:                 |
| `'0'`    |           :x:           |                :x:                 |
| `0`      |           :x:           |                :x:                 |
| `false`  |           :x:           |                :x:                 |
| `[]`     |           :x:           |                :x:                 |
| `-1`     |           :x:           |                :x:                 |
| `1`      |           :x:           |                :x:                 |
| `true`   |           :x:           |                :x:                 |
| `'text'` |           :x:           |                :x:                 |
| `'low'`  |   :heavy_check_mark:    |         :heavy_check_mark:         |
| `'high'` |   :heavy_check_mark:    |         :heavy_check_mark:         |

### date

Checks whether the value is a valid date (Y-m-d) or a custom format.

#### Default format (Y-m-d)

```php
$rules = [
    'dob' => [
        'label' => 'Date of birth',
        'rules' => [
            RuleEnum::DATE,
        ],
    ],
];
```

#### Custom format (e.g. d.m.Y)

```php
$rules = [
    'dob' => [
        'label' => 'Date of birth',
        'rules' => [
            RuleEnum::DATE => ['d.m.Y'],
        ],
    ],
];
```

| Value          |    date [Y-m-d]    | date [Y-m-d] + required |
| -------------- | :----------------: | :---------------------: |
| `null`         | :heavy_check_mark: |           :x:           |
| `''`           | :heavy_check_mark: |           :x:           |
| `'0'`          |        :x:         |           :x:           |
| `0`            |        :x:         |           :x:           |
| `false`        |        :x:         |           :x:           |
| `[]`           |        :x:         |           :x:           |
| `-1`           |        :x:         |           :x:           |
| `1`            |        :x:         |           :x:           |
| `true`         |        :x:         |           :x:           |
| `'text'`       |        :x:         |           :x:           |
| `'2020-09-30'` | :heavy_check_mark: |   :heavy_check_mark:    |

### email

Checks whether the value has a valid email format.

```php
$rules = [
    'email' => [
        'label' => 'Email',
        'rules' => [
            RuleEnum::EMAIL,
        ],
    ],
];
```

| Value                |       email        |  email + required  |
| -------------------- | :----------------: | :----------------: |
| `null`               | :heavy_check_mark: |        :x:         |
| `''`                 | :heavy_check_mark: |        :x:         |
| `'0'`                |        :x:         |        :x:         |
| `0`                  |        :x:         |        :x:         |
| `false`              |        :x:         |        :x:         |
| `[]`                 |        :x:         |        :x:         |
| `-1`                 |        :x:         |        :x:         |
| `1`                  |        :x:         |        :x:         |
| `true`               |        :x:         |        :x:         |
| `'text'`             |        :x:         |        :x:         |
| `'john@example.com'` | :heavy_check_mark: | :heavy_check_mark: |

### equals

Checks whether the value is equal to another.

```php
$rules = [
    'repeat_password' => [
        'label' => 'Repeat Password',
        'rules' => [
            RuleEnum::EQUALS => ['password'],
        ],
    ],
];
```

Comparison with `'text'`

| Value            |       equals       | equals + required  |
| ---------------- | :----------------: | :----------------: |
| `null`           | :heavy_check_mark: |        :x:         |
| `''`             | :heavy_check_mark: |        :x:         |
| `'0'`            |        :x:         |        :x:         |
| `0`              |        :x:         |        :x:         |
| `false`          |        :x:         |        :x:         |
| `[]`             |        :x:         |        :x:         |
| `-1`             |        :x:         |        :x:         |
| `1`              |        :x:         |        :x:         |
| `true`           |        :x:         |        :x:         |
| `'text'`         | :heavy_check_mark: | :heavy_check_mark: |
| `'another text'` |        :x:         |        :x:         |

### file_max_size

Checks whether the file size does not exceed a given value.

Enter a value in bytes.

```php
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::FILE_MAX_SIZE => [102400],
        ],
    ],
];
```

Comparison with `102400` bytes

| Value    |   file_max_size    | file_max_size + required |
| -------- | :----------------: | :----------------------: |
| `null`   | :heavy_check_mark: |           :x:            |
| `50000`  | :heavy_check_mark: |    :heavy_check_mark:    |
| `150000` |        :x:         |           :x:            |

### file_mime_type

Checks whether the file type is allowed.

```php
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::FILE_MIME_TYPE => ['image/png', 'image/jpeg'],
        ],
    ],
];
```

| Value        |   file_mime_type   | file_mime_type + required |
| ------------ | :----------------: | :-----------------------: |
| `null`       | :heavy_check_mark: |            :x:            |
| `image/png`  | :heavy_check_mark: |    :heavy_check_mark:     |
| `text/plain` |        :x:         |            :x:            |

### float_number

Checks whether the value is a floating point number.

```php
$rules = [
    'price' => [
        'label' => 'Price',
        'rules' => [
            RuleEnum::FLOAT_NUMBER,
        ],
    ],
];
```

| Value                |    float_number    | float_number + required |
| -------------------- | :----------------: | :---------------------: |
| `null`               | :heavy_check_mark: |           :x:           |
| `''`                 | :heavy_check_mark: |           :x:           |
| `'0'`                |        :x:         |           :x:           |
| `0`                  |        :x:         |           :x:           |
| `false`              |        :x:         |           :x:           |
| `[]`                 |        :x:         |           :x:           |
| `-1`                 |        :x:         |           :x:           |
| `1`                  |        :x:         |           :x:           |
| `12345`              |        :x:         |           :x:           |
| `123.45`             | :heavy_check_mark: |   :heavy_check_mark:    |
| `true`               |        :x:         |           :x:           |
| `'text'`             |        :x:         |           :x:           |
| `'text with spaces'` |        :x:         |           :x:           |

### image_max_height

Checks whether the image height does not exceed a given value.

```php
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::IMAGE_MAX_HEIGHT => [600],
        ],
    ],
];
```

| Value  |  image_max_height  | image_max_height + required |
| ------ | :----------------: | :-------------------------: |
| `null` | :heavy_check_mark: |             :x:             |
| 500px  | :heavy_check_mark: |     :heavy_check_mark:      |
| 1000px |        :x:         |             :x:             |

### image_max_width

Checks whether the image width does not exceed a given value.

```php
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::IMAGE_MAX_WIDTH => [1000],
        ],
    ],
];
```

| Value  |  image_max_width   | image_max_width + required |
| ------ | :----------------: | :------------------------: |
| `null` | :heavy_check_mark: |            :x:             |
| 500px  | :heavy_check_mark: |     :heavy_check_mark:     |
| 1500px |        :x:         |            :x:             |

### image_min_height

Checks whether the image height is not less than a given value.

```php
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::IMAGE_MIN_HEIGHT => [300],
        ],
    ],
];
```

| Value  |  image_min_height  | image_min_height + required |
| ------ | :----------------: | :-------------------------: |
| `null` | :heavy_check_mark: |             :x:             |
| 100px  |        :x:         |             :x:             |
| 500px  | :heavy_check_mark: |     :heavy_check_mark:      |

### image_min_width

Checks whether the image width is not less than a given value.

```php
$rules = [
    'profile_photo' => [
        'label' => 'Profile Photo',
        'rules' => [
            RuleEnum::IMAGE_MIN_WIDTH => [500],
        ],
    ],
];
```

| Value  |  image_min_width   | image_min_width + required |
| ------ | :----------------: | :------------------------: |
| `null` | :heavy_check_mark: |            :x:             |
| 400px  |        :x:         |            :x:             |
| 600px  | :heavy_check_mark: |     :heavy_check_mark:     |

### integer

Checks whether the value is integer.

```php
$rules = [
    'distance' => [
        'label' => 'Distance',
        'rules' => [
            RuleEnum::INTEGER,
        ],
    ],
];
```

| Value    |      numeric       | numeric + required |
| -------- | :----------------: | :----------------: |
| `null`   | :heavy_check_mark: |        :x:         |
| `''`     | :heavy_check_mark: |        :x:         |
| `'0'`    |        :x:         |        :x:         |
| `0`      | :heavy_check_mark: | :heavy_check_mark: |
| `false`  |        :x:         |        :x:         |
| `[]`     |        :x:         |        :x:         |
| `-1`     | :heavy_check_mark: | :heavy_check_mark: |
| `1`      | :heavy_check_mark: | :heavy_check_mark: |
| `true`   |        :x:         |        :x:         |
| `'text'` |        :x:         |        :x:         |

### ip

Checks whether the value is a valid IP address.

```php
$rules = [
    'ip' => [
        'label' => 'IP',
        'rules' => [
            RuleEnum::IP,
        ],
    ],
];
```

| Value                    |         ip         |   ip + required    |
| ------------------------ | :----------------: | :----------------: |
| `null`                   | :heavy_check_mark: |        :x:         |
| `''`                     | :heavy_check_mark: |        :x:         |
| `'0'`                    |        :x:         |        :x:         |
| `0`                      |        :x:         |        :x:         |
| `false`                  |        :x:         |        :x:         |
| `[]`                     |        :x:         |        :x:         |
| `-1`                     |        :x:         |        :x:         |
| `1`                      |        :x:         |        :x:         |
| `true`                   |        :x:         |        :x:         |
| `'text'`                 |        :x:         |        :x:         |
| `'10.10.10.10'`          | :heavy_check_mark: | :heavy_check_mark: |
| `'2607:f0d0:1002:51::4'` | :heavy_check_mark: | :heavy_check_mark: |

### ipv4

Checks whether the value is a valid IPv4 address.

```php
$rules = [
    'ipv4' => [
        'label' => 'IPv4',
        'rules' => [
            RuleEnum::IPV4,
        ],
    ],
];
```

| Value                    |        ipv4        |  ipv4 + required   |
| ------------------------ | :----------------: | :----------------: |
| `null`                   | :heavy_check_mark: |        :x:         |
| `''`                     | :heavy_check_mark: |        :x:         |
| `'0'`                    |        :x:         |        :x:         |
| `0`                      |        :x:         |        :x:         |
| `false`                  |        :x:         |        :x:         |
| `[]`                     |        :x:         |        :x:         |
| `-1`                     |        :x:         |        :x:         |
| `1`                      |        :x:         |        :x:         |
| `true`                   |        :x:         |        :x:         |
| `'text'`                 |        :x:         |        :x:         |
| `'10.10.10.10'`          | :heavy_check_mark: | :heavy_check_mark: |
| `'2607:f0d0:1002:51::4'` |        :x:         |        :x:         |

### ipv6

Checks whether the value is a valid IPv6 address.

```php
$rules = [
    'ipv6' => [
        'label' => 'IPv6',
        'rules' => [
            RuleEnum::IPV6,
        ],
    ],
];
```

| Value                    |        ipv6        |  ipv6 + required   |
| ------------------------ | :----------------: | :----------------: |
| `null`                   | :heavy_check_mark: |        :x:         |
| `''`                     | :heavy_check_mark: |        :x:         |
| `'0'`                    |        :x:         |        :x:         |
| `0`                      |        :x:         |        :x:         |
| `false`                  |        :x:         |        :x:         |
| `[]`                     |        :x:         |        :x:         |
| `-1`                     |        :x:         |        :x:         |
| `1`                      |        :x:         |        :x:         |
| `true`                   |        :x:         |        :x:         |
| `'text'`                 |        :x:         |        :x:         |
| `'10.10.10.10'`          |        :x:         |        :x:         |
| `'2607:f0d0:1002:51::4'` | :heavy_check_mark: | :heavy_check_mark: |

### max

Checks whether the value does not exceed a given value.

```php
$rules = [
    'people' => [
        'label' => 'People',
        'rules' => [
            RuleEnum::MAX => [5],
        ],
    ],
];
```

| Value     |        max         |   max + required   |
| --------- | :----------------: | :----------------: |
| `null`    | :heavy_check_mark: |        :x:         |
| `''`      | :heavy_check_mark: |        :x:         |
| `'0'`     | :heavy_check_mark: | :heavy_check_mark: |
| `0`       | :heavy_check_mark: | :heavy_check_mark: |
| `false`   |        :x:         |        :x:         |
| `[]`      |        :x:         |        :x:         |
| `-1`      | :heavy_check_mark: | :heavy_check_mark: |
| `1`       | :heavy_check_mark: | :heavy_check_mark: |
| `true`    |        :x:         |        :x:         |
| `'text'`  |        :x:         |        :x:         |
| `12345`   |        :x:         |        :x:         |
| `'12345'` |        :x:         |        :x:         |

### max_length

Checks whether the number of characters of the value does not exceed a given value.

```php
$rules = [
    'nickname' => [
        'label' => 'Nickname',
        'rules' => [
            RuleEnum::MAX_LENGTH => [2],
        ],
    ],
];
```

| Value     |     max_length     | max_length + required |
| --------- | :----------------: | :-------------------: |
| `null`    | :heavy_check_mark: |          :x:          |
| `''`      | :heavy_check_mark: |          :x:          |
| `'0'`     | :heavy_check_mark: |  :heavy_check_mark:   |
| `0`       | :heavy_check_mark: |  :heavy_check_mark:   |
| `false`   | :heavy_check_mark: |  :heavy_check_mark:   |
| `[]`      |        :x:         |          :x:          |
| `-1`      | :heavy_check_mark: |  :heavy_check_mark:   |
| `1`       | :heavy_check_mark: |  :heavy_check_mark:   |
| `true`    | :heavy_check_mark: |  :heavy_check_mark:   |
| `'text'`  |        :x:         |          :x:          |
| `12345`   |        :x:         |          :x:          |
| `'12345'` |        :x:         |          :x:          |

### min

Checks whether the value is not less than a given value.

```php
$rules = [
    'people' => [
        'label' => 'People',
        'rules' => [
            RuleEnum::MIN => [2],
        ],
    ],
];
```

| Value     |        min         |   min + required   |
| --------- | :----------------: | :----------------: |
| `null`    | :heavy_check_mark: |        :x:         |
| `''`      | :heavy_check_mark: |        :x:         |
| `'0'`     |        :x:         |        :x:         |
| `0`       |        :x:         |        :x:         |
| `false`   |        :x:         |        :x:         |
| `[]`      |        :x:         |        :x:         |
| `-1`      |        :x:         |        :x:         |
| `1`       |        :x:         |        :x:         |
| `true`    |        :x:         |        :x:         |
| `'text'`  |        :x:         |        :x:         |
| `12345`   | :heavy_check_mark: | :heavy_check_mark: |
| `'12345'` | :heavy_check_mark: | :heavy_check_mark: |

### min_length

Checks whether the number of characters of the value is not less than a given value.

```php
$rules = [
    'nickname' => [
        'label' => 'Nickname',
        'rules' => [
            RuleEnum::MIN_LENGTH => [2],
        ],
    ],
];
```

| Value     |     max_length     | max_length + required |
| --------- | :----------------: | :-------------------: |
| `null`    | :heavy_check_mark: |          :x:          |
| `''`      |        :x:         |          :x:          |
| `'0'`     |        :x:         |          :x:          |
| `0`       |        :x:         |          :x:          |
| `false`   |        :x:         |          :x:          |
| `[]`      |        :x:         |          :x:          |
| `-1`      | :heavy_check_mark: |  :heavy_check_mark:   |
| `1`       |        :x:         |          :x:          |
| `true`    |        :x:         |          :x:          |
| `'text'`  | :heavy_check_mark: |  :heavy_check_mark:   |
| `12345`   | :heavy_check_mark: |  :heavy_check_mark:   |
| `'12345'` | :heavy_check_mark: |  :heavy_check_mark:   |

### numeric

Checks whether the value is numeric.

```php
$rules = [
    'age' => [
        'label' => 'Age',
        'rules' => [
            RuleEnum::NUMERIC,
        ],
    ],
];
```

| Value    |      numeric       | numeric + required |
| -------- | :----------------: | :----------------: |
| `null`   | :heavy_check_mark: |        :x:         |
| `''`     | :heavy_check_mark: |        :x:         |
| `'0'`    | :heavy_check_mark: | :heavy_check_mark: |
| `0`      | :heavy_check_mark: | :heavy_check_mark: |
| `false`  |        :x:         |        :x:         |
| `[]`     |        :x:         |        :x:         |
| `-1`     | :heavy_check_mark: | :heavy_check_mark: |
| `1`      | :heavy_check_mark: | :heavy_check_mark: |
| `true`   |        :x:         |        :x:         |
| `'text'` |        :x:         |        :x:         |

### regex

Checks whether the value matches a given regular expression.

```php
$rules = [
    'path' => [
        'label' => 'Path',
        'rules' => [
            RuleEnum::REGEX => ['/\/client\/[0-9a-f]+$/'],
        ],
    ],
];
```

Validation with the `'/\/client\/[0-9a-f]+$/'` pattern

| Value                                        |       regex        |  regex + required  |
| -------------------------------------------- | :----------------: | :----------------: |
| `null`                                       | :heavy_check_mark: |        :x:         |
| `''`                                         | :heavy_check_mark: |        :x:         |
| `'0'`                                        |        :x:         |        :x:         |
| `0`                                          |        :x:         |        :x:         |
| `false`                                      |        :x:         |        :x:         |
| `[]`                                         |        :x:         |        :x:         |
| `-1`                                         |        :x:         |        :x:         |
| `1`                                          |        :x:         |        :x:         |
| `true`                                       |        :x:         |        :x:         |
| `'text'`                                     |        :x:         |        :x:         |
| `'/client/77c9e105d1f548b29958f0512967de87'` | :heavy_check_mark: | :heavy_check_mark: |
| `'/client/invalid-uuid'`                     |        :x:         |        :x:         |

### required

Checks whether the value is not empty.

```php
$rules = [
    'name' => [
        'label' => 'Name',
        'rules' => [
            RuleEnum::REQUIRED,
        ],
    ],
];
```

| Value         |      required      |
| ------------- | :----------------: |
| `null`        |        :x:         |
| `''`          |        :x:         |
| `'0'`         | :heavy_check_mark: |
| `0`           | :heavy_check_mark: |
| `false`       | :heavy_check_mark: |
| `[]`          |        :x:         |
| `-1`          | :heavy_check_mark: |
| `1`           | :heavy_check_mark: |
| `true`        | :heavy_check_mark: |
| `'some text'` | :heavy_check_mark: |

### slug

Checks whether the value is a valid Slug (e.g. hello-world_123).

```php
$rules = [
    'slug' => [
        'label' => 'Slug',
        'rules' => [
            RuleEnum::SLUG,
        ],
    ],
];
```

| Value                |        slug        |  slug + required   |
| -------------------- | :----------------: | :----------------: |
| `null`               | :heavy_check_mark: |        :x:         |
| `''`                 | :heavy_check_mark: |        :x:         |
| `'0'`                |        :x:         |        :x:         |
| `0`                  |        :x:         |        :x:         |
| `false`              |        :x:         |        :x:         |
| `[]`                 |        :x:         |        :x:         |
| `-1`                 |        :x:         |        :x:         |
| `1`                  |        :x:         |        :x:         |
| `true`               |        :x:         |        :x:         |
| `'text'`             | :heavy_check_mark: | :heavy_check_mark: |
| `'text with spaces'` |        :x:         |        :x:         |
| `'hello-world_123'`  | :heavy_check_mark: | :heavy_check_mark: |

### url

Checks whether the value is a valid URL.

```php
$rules = [
    'url' => [
        'label' => 'URL',
        'rules' => [
            RuleEnum::URL,
        ],
    ],
];
```

| Value                          |        url         |   url + required   |
| ------------------------------ | :----------------: | :----------------: |
| `null`                         | :heavy_check_mark: |        :x:         |
| `''`                           | :heavy_check_mark: |        :x:         |
| `'0'`                          |        :x:         |        :x:         |
| `0`                            |        :x:         |        :x:         |
| `false`                        |        :x:         |        :x:         |
| `[]`                           |        :x:         |        :x:         |
| `-1`                           |        :x:         |        :x:         |
| `1`                            |        :x:         |        :x:         |
| `true`                         |        :x:         |        :x:         |
| `'text'`                       |        :x:         |        :x:         |
| `'http://www.some-domain.com'` | :heavy_check_mark: | :heavy_check_mark: |

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
