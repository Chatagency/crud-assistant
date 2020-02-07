# Crud Assistant

Crud Assistant is a a set of utilities that helps crud management and component reuse. There is one main goal CA is set to solve: **Organization**. Mainly, to keep all input related info in one place. This a project is meant to be used on small project such as landing pages since that is the main reason it was created. We just needed a fast way to create promotional landing pages very fast but still or them to be flexible enough to add custom functionality if needed.


## Use

Consult the [Documentation](https://link-to-documentation) for more detail.

*Note*: We keep a repository of reusable components and implementation [here](http://link-to-extras)


### Input - [Docs](https://link-to-documentation)

The `Input` can represent many things:

- A form input
- A cell on the database table
- A column on a CSV file, etc.

To summarize up, they encapsulate a single peace of data.

There are different types of `Input`s, loosely associated with form input types:

- `TextInput`
- `SelectInput`
- `TextareaInput`
- `FileInput`
- `CheckboxInput`
- `RadioInput` (but you would usually use the...)
- `RadioGroupInput`
- `HiddenInput`

Other input types can be created easily.

`Inputs` area containers that hold the main data itself but also the instructions/transformations that the data might experience. It can hold: `name`, `type`, `label`, `version` (to manage change over time), `attributes` and, when it make sense,  `subElements`:

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
$name = new TextInput($inputName = 'email', $inputLabel = 'Your Email', $inputVersion = 1);
$name->setType('email');
$name->setAttribute('required', 'required');

use Chatagency\CrudAssistant\Inputs\SelectInput;
$hobby = new SelectInput($inputName = 'hobbies', $inputLabel = 'Your Hobbies', $inputVersion = 1);
$hobby->setSubElements([
    'Read',
    'Watch movies',
]);
```
But (arguably) more important, it can hold `Recipes` for `Actions`.

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$name->addRecipe(\Chatagency\CrudAssistant\Actions\Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
```

### InputCollection - [Docs](https://link-to-documentation)

The `InputCollection` holds one or multiple `Input`s.

```php
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\ActionFactory;

$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$collection = new InputCollection([$name], new ActionFactory([]))
```
An action can be called on an `InputCollection`:

```php
$actionResult = $collection->execute(\Chatagency\CrudAssistant\Actions\Sanitation::class);
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

### Actions

`Action`s are arbitrary functionality ran on an `InputCollection`.

```php
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Actions\LaravelValidationRules;

$name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
$name->addRecipe(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
$name->addRecipe(LaravelValidationRules::class, [
    'required',
    'max:250'
]);

$manager = CrudAssistant::make([$name]);
$sanitized = $manager->execute(Sanitation::class);
$rules = $manager->execute(LaravelValidationRules::class);
```

## Todo

- HiddenInput tests
- Add independent `Migration` version
- Redo `ActionController` to have only extra ones in config()
