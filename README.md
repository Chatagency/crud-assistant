# Crud Assistant

Crud Assistant is a a set of utilities that helps crud management and component re-use. There is one main goal Crud Assistant is set to solve: **Organization**. Mainly, to keep all input related info in one place. 

**The Problem**: You create a leeds landing page with a simple form. It is approved and then it is moved to the production server. After that, the client calls with more changes: You have to add an additional fields or make changes to the existing ones. That involves changes to the html form, validation, migration, model, etc. This is where this package shines. It allows the you, depending on your implementation, to make the changes in just a couple of places and they will be reflected everywhere in your application. 

With Crud Assistant you can consolidate all business logic in `inputs` and all runtime variables are passed to the `actions`. This also promotes code isolation and cod re-use.

*Disclaimer: This a package is meant to be used on small project such as landing pages since that is the main reason it was created. We just needed a fast way to create promotional landing pages very fast but still or them to be flexible enough to add custom functionality if needed.*

## Use

Consult the [Documentation] for more detail.

*Note: We keep a repository of reusable components and part of the implementation [here]*


### Input - [Docs]

An `Input` can represent many things:

- A form input
- A cell on the database table
- A column on a CSV file, etc.

To summarize, it encapsulates a single peace of data.

There are different types of `Inputs`, loosely associated with form input types:

- `TextInput`
- `TextareaInput`
- `FileInput`
- `CheckboxInput`
- `OptionInput` for the...                                                                                             
- `SelectInput`
- `RadioInput` (but you would usually use the...)
- `RadioGroupInput`

Other input types can be easily created.

`Inputs` area containers that hold the main data itself but also the instructions/transformations that data might experience. It can hold: `name`, `type`, `label`, `version` (to manage change over time), `attributes` and, when it make sense,  `subElements`:

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
$email = new TextInput($inputName = 'email', $inputLabel = 'Your Email', $inputVersion = 1);
$email->setType('email');
$email->setAttribute('required', 'required');

use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\Inputs\OptionInput;
$hobby = new SelectInput($inputName = 'hobbies', $inputLabel = 'Your Hobbies', $inputVersion = 1);
$hobby->setSubElements([
    new OptionInput('Read'),
    new OptionInput('Watch movies'),
]);
```
This way we can group all content/instructions in one place.But (arguably) more important, it can hold `Recipes` for `Actions`.

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$name->addRecipe(\Chatagency\CrudAssistant\Actions\Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
```

### InputCollection - [Docs](https://link-to-documentation)

The `InputCollection` holds one or multiple `Inputs`.

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\ActionFactory;

$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$email = new TextInput($inputName = 'email', $inputLabel = 'Your Email', $inputVersion = 1);
$email->setType('email');

$collection = new InputCollection([$name, $email], new ActionFactory([]))
```
An action can be called on an `InputCollection`:

```php
$actionResult = $collection->execute(\Chatagency\CrudAssistant\Actions\Sanitation::class);
```

### Actions - [Docs](https://link-to-documentation)

`Actions` are arbitrary functionality ran on an `InputCollection`.

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Actions\LaravelValidationRules;


// Input
$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$name->addRecipe(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
$name->addRecipe(LaravelValidationRules::class, [
    'required',
    'max:250'
]);

$collection = new InputCollection([$name], new ActionFactory([]))

// sanitizes values
$sanitized = $collection->execute(Sanitation::class);
// returns Laravel validation rules
$rules = $manager->execute(LaravelValidationRules::class);
```

If runtime parameters must be passed to the action a `DataContainer` must be used:

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Actions\Filter;

// Input
$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$name->addRecipe(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
$name->addRecipe(Filter::class, [
  'filter' => true
]);

$collection = new InputCollection([$name], new ActionFactory([]))

// sanitizes values
$filteredData = $collection->execute(Filter::class, new DataContainer(
  'data' => $data
));
```

### CrudAssistant (Crud Manager) - [Docs](https://link-to-documentation)

The `CrudAssistant` helps with the creation of an `InputCollection`:

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;

$manager = CrudAssistant::make([
    new TextInput('name')
]);
```
It also doubles as a `InputCollection` facade. 

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Actions\LaravelValidationRules;

$manager = CrudAssistant::make([
    new TextInput('name')
]);

$rules = $manager->executes(LaravelValidationRules::class);
```

For convenience, it can also execute an action using just the name of the class:

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Actions\LaravelValidationRules;

$manager = CrudAssistant::make([
    new TextInput('name')
]);

/**
 * This
 */
$rules = $manager->executes(LaravelValidationRules::class);

/**
 * Is equal to this
 */
$rules = $manager->LaravelValidationRules();
```

If an array is passed in runtime to the action and array can be used instead of a `DataContainer`, The assistant will initiate the `DataContainer` before pass it to the collection:

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Actions\Filter;

$name = new TextInput('name');
$name->addRecipe(Filter::class, [
  'filter' => true
]);

$manager = CrudAssistant::make([
    $name
]);

/**
 * This
 */
$rules = $manager->executes(Filter::class, new DataContainer([
   'data' => $data
]));

/**
 * Is equal to this
 */
$rules = $manager->Filter(new DataContainer([
   'data' => $data
]));

/**
 * And this
 */
$rules = $manager->Filter([
   'data' => $data
]);
```
