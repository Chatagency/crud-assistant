# Crud Assistant

Crud Assistant is a set of utilities that helps with crud management and component re-use. 

There is one main goal Crud Assistant is set to solve: **Organization**.

**The Problem**: You create a landing page with a simple form using, for example, Laravel. Once approved you move it to the production server. After that, the client calls with more changes: You have to add an additional form fields or make changes to the existing ones. That involves changes to the html form, validation, migration, model, etc. 

This is where this package shines. It allows the you to, depending on your implementation, make changes only in a couple of places. With Crud Assistant you can consolidate all business logic in `Inputs` and all implementation code in `Actions`. This also promotes code isolation and code re-use.

*Disclaimer: This a package is meant to be used on small projects. We needed an easy way to create promotional landing pages and a fast way to apply changes to them. WE still have hot tested how this solution would scale in large projects.*

## Use

Consult the [documentation] for more detail.

*Note: We keep a repository of reusable components and part of the implementation [here]*


### Input - [docs link]

An `Input` can represent many things:

- A form input
- A cell on the database table
- A column on a CSV file, etc.

To summarize, it encapsulates the description of a single peace of data.

There are different types of `Inputs`, loosely associated with form input types:

- `TextInput`
- `TextareaInput`
- `FileInput`
- `CheckboxInput`
- `OptionInput` for the...                                                                                             
- `SelectInput`
- `RadioInput` (but you would usually use the...)
- `RadioGroupInput`
- `InputCollection` can also be and input that holds a collection of inputs

Other input types can be easily created.

`Inputs` area containers that hold the main description of the data but also the instructions/transformations that data might experience. It can hold: `name`, `type`, `label`, `version`, `attributes` and, when it make cases,  `subElements`:

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\Inputs\OptionInput;
use Chatagency\CrudAssistant\InputCollection;

$email = new TextInput($inputName = 'email', $inputLabel = 'Your Email');
$email->setType('email');
$email->setAttribute('required', 'required');

$hobby = new SelectInput($inputName = 'hobbies', $inputLabel = 'Your Hobbies');

$hobbies = new InputCollection();
$hobbies->setInputs([
    new OptionInput('Read'),
    new OptionInput('Watch movies'),
]);

$hobby->setSubElements($hobbies);
```
This way we can group all descriptions/instructions in one place. But (arguably) more important, it can hold `Recipes` for `Actions`.

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Recipes\SanitationActionRecipe;

$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$name->setRecipe(new SanitationActionRecipe([
    'type' => FILTER_SANITIZE_SPECIAL_CHARS
]));
```

### InputCollection - [docs link]

An `InputCollection` holds one or multiple `Inputs`.

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\DataContainer;

$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$email = new TextInput($inputName = 'email', $inputLabel = 'Your Email');
$email->setType('email');

$collection = new InputCollection();
$collection->setInputs([$name, $email]);

$data = new DataContainer([
    'requestArray' => []
]);

$actionResult = $collection->execute(new \Chatagency\CrudAssistant\Actions\SanitationAction($data));
```

An `InputCollection` can also hold other collections.

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\InputCollection;

$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$email = new TextInput($inputName = 'email', $inputLabel = 'Your Email');
$email->setType('email');

$collection = new InputCollection('sub_information');
$collection->setInputs([
    new TextInput('age', 'Your Age'),
    new TextInput('zip_code', 'Your Zip Code'),
]);

$inputs = [$name, $email, $collection];

$collection = new InputCollection();
$collection->setInputs($inputs); 
```

### Actions - [docs link]

`Actions` are arbitrary functionality executed by the `Inputs` or `InputCollection`. 

If runtime parameters must be passed to the action a `DataContainer` must be used:

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Actions\SanitationAction;
use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\Recipes\SanitationActionRecipe;

// Input
$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$name->setRecipe(new SanitationActionRecipe([
    'type' => FILTER_SANITIZE_SPECIAL_CHARS
]));
$name->setRecipe(new FilterActionRecipe([
    'filter' => true
]) );

$collection = new InputCollection();
$collection->setInputs([$name]);

// sanitizes values
$sanitized = $collection->execute(new SanitationAction(
    new DataContainer([
        'requestArray' => []
    ])
));
// returns filtered values
$rules = $collection->execute(new FilterAction(
    new DataContainer([
        'data' => []
    ])
));
```

### CrudAssistant [docs link]

The `CrudAssistant` helps with the creation of an `InputCollection`:

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;

$manager = new CrudAssistant([
    new TextInput('name')
]);

/**
 * Or
 */
$manager = CrudAssistant::make([
    new TextInput('name')
]);

```
It also doubles as a `InputCollection` facade:

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\Recipes\FilterActionRecipe;

$name = new TextInput('name');
$name->setRecipe(new FilterActionRecipe([
    'filter' => true
]));

$manager = CrudAssistant::make([$name]);

$rules = $manager->execute(new FilterAction(
    new DataContainer([
        'data' => [
            'name' => 'John Doe'
        ]
    ])
));
```

## License
This package is licensed with the [MIT License](https://choosealicense.com/licenses/mit/#).