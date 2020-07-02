# Crud Assistant

Crud Assistant is a set of utilities that helps with crud management and component re-use. 

There is one main goal Crud Assistant is set to solve: **Organization**.

**The Problem**: You create a landing page with a simple form using Laravel. Once approved you move it to the production server. After that, the client calls with more changes: You have to add an additional fields or make changes to the existing ones. That involves changes to the html form, validation, migration, model, etc. 

This is where this package shines. It allows the you, depending on your implementation, to make all changes in just a couple of places and they will be reflected everywhere in your application. With Crud Assistant you can consolidate all business logic in `inputs` and all runtime variables are passed to the `actions`. This also promotes code isolation and code re-use.

*Disclaimer: This a package is meant to be used on small project such as landing pages since that is the main reason it was created. We needed an easy way to create promotional landing pages and a fast way to apply changes to them*

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

`Inputs` area containers that hold the main description of the data but also the instructions/transformations that data might experience. It can hold: `name`, `type`, `label`, `version` (to manage change over time), `attributes` and, when it make cases,  `subElements`:

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\Inputs\OptionInput;

$email = new TextInput($inputName = 'email', $inputLabel = 'Your Email', $inputVersion = 1);
$email->setType('email');
$email->setAttribute('required', 'required');

$hobby = new SelectInput($inputName = 'hobbies', $inputLabel = 'Your Hobbies', $inputVersion = 1);

$hobby->setSubElements(new InputCollection([
    new OptionInput('Read'),
    new OptionInput('Watch movies'),
]));
```
This way we can group all content/instructions in one place. But (arguably) more important, it can hold `Recipes` for `Actions`.

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$name->setRecipe(\Chatagency\CrudAssistant\Actions\Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
```

### InputCollection - [docs link]

The `InputCollection` holds one or multiple `Inputs`.

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\DataContainer;

$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$email = new TextInput($inputName = 'email', $inputLabel = 'Your Email', $inputVersion = 1);
$email->setType('email');

$collection = new InputCollection([$name, $email]);
```
An action can be called on an `InputCollection` using the execute method:

```php
$data = new DataContainer([
  'requestArray' => []
]);
$actionResult = $collection->execute(new \Chatagency\CrudAssistant\Actions\Sanitation($data));
```

### Actions - [docs link]

`Actions` are arbitrary functionality ran on an `InputCollection`. If runtime parameters must be passed to the action a `DataContainer` must be used:

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Actions\Sanitation;
use Chatagency\CrudAssistant\Actions\Filter;

// Input
$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$name->setRecipe(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
$name->setRecipe(Filter::class, [
    'required',
    'max:250'
]);

$collection = new InputCollection([$name]);

// sanitizes values
$sanitized = $collection->execute(new Sanitation(
    new DataContainer([
        'requestArray' => []
    ])
));
// returns Laravel validation rules
$rules = $collection->execute(new Filter(
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
use Chatagency\CrudAssistant\Actions\Filter;

$name = new TextInput('name');
  $name->setRecipe(Filter::class, [
      'filter' => true
  ]);
  
  $manager = CrudAssistant::make([$name]);
  
  $rules = $manager->execute(new Filter(
      new DataContainer([
          'data' => [
              'name' => 'John Doe'
          ]
      ])
  ));
```

## License
This package is licensed with the [MIT License](https://choosealicense.com/licenses/mit/#).