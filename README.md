# Crud Assistant

Crud Assistant is a a set of utilities that helps crud management and component reuse. There is one main goal CA is set to solve: **Organization**. Mainly, to keep all input related info in one place. This a project is meant to be used on small project such as landing pages since that is the main reason it was created. We just needed a fast way to create promotional landing pages very fast but still or them to be flexible enough to add custom functionality if needed.


## Use

Consult the [Documentation](https://link-to-documentation) for more detail.

*Note*: We keep a repository of reusable components and part of the implementation [here](http://link-to-extras)


### Input - [Docs](https://link-to-documentation)

An `Input` can represent many things:

- A form input
- A cell on the database table
- A column on a CSV file, etc.

To summarize, it encapsulates a single peace of data.

There are different types of `Inputs`, loosely associated with form input types:

- `TextInput`
- `SelectInput`
- `TextareaInput`
- `FileInput`
- `CheckboxInput`
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
$hobby = new SelectInput($inputName = 'hobbies', $inputLabel = 'Your Hobbies', $inputVersion = 1);
$hobby->setSubElements([
    'Read',
    'Watch movies',
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

### CrudAssistant (Crud Manager) - [Docs](https://link-to-documentation)

The `CrudAssistant` helps with the creation of an `InputCollection`:

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;

$manager = CrudAssistant::make([
    new TextInput('name')
]);
```


