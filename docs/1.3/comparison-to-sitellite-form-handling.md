# Comparison to Sitellite: Form Handling

Back to [[Comparison to Sitellite CMS]].

***

Forms in Sitellite are auto-generated, and lack the ability to easily control the form layout beyond basic CSS on auto-generated elements.

Forms in Elefant are simply handers and views, plus a convenience class for verification that borrows from Sitellite's validation rules with only slight changes (see below). Elefant also provides a jQuery plugin for automatic client-side validation based on the same validation rules that are used server-side.

Each Elefant app has an optional `forms` folder that contains INI-formatted files describing the validation rules for each field. These are heavily influenced by Sitellite's use of INI files, so they should look familiar to Sitellite developers.

For more info on forms, see [[Forms and input validation]].

## Validation rule differences

* `regex` rules use `preg_*` and there is no `preg` rule
* `ignoreEmpty` is now `skip_if_empty`
* `func` and `function` are now `callback`
* new `date`, `time`, and `datetime` rules
* new `range` rule
* `is` is now `equals` and `matches` now compares the value to another field
* `numeric` has been replaced with `type` as in `type ""numeric""` so you can verify type using any of the `is_*` functions
