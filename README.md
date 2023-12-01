# Crud Assistant

Crud Assistant is a set of utilities that helps with crud management and component re-use. 

There is one main goal Crud Assistant is set to solve: **Organization**.

**The Problem**: You create a landing page with a simple form using, for example, Laravel. Once approved you move it to the production server. After that, the client calls with more changes: You have to add an additional form fields or make changes to the existing ones. That involves changes to the html form, validation, migration, model, etc. 

This is where this package shines. It allows the you to, depending on your implementation, make changes only in a couple of places. With Crud Assistant you can consolidate all business logic in `Inputs` and all implementation code in `Actions`. This also promotes code isolation and code re-use.

*Disclaimer: This a package is meant to be used on small projects. We needed an easy way to create promotional landing pages and a fast way to apply changes to them. We still have not tested how this solution would scale in large projects.*

## Use

Consult the [documentation] for more detail.

*Note: We keep a repository of reusable components and part of the implementation [here]*

## License
This package is licensed with the [MIT License](https://choosealicense.com/licenses/mit/#).