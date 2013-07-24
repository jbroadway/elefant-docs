# Elefant design principles

Here are some of the principles we try to follow in developing Elefant:

### Conciseness wins

Less typing leads to clearer code and fewer bugs. It also saves our wrists from early wear. That doesn't mean we shouldn't think hard before typing, but the more verbose something is, the more opaque it becomes as well.

### Balance of convention and configuration

Conventions define a single way of doing things. Configuration aims to provide the most options and solve more edge cases by leaving the approach to the developer.

We think the right way lies somewhere in the middle. We try to provide only as much configuration as needed for most people, but don't try to be everything to everyone. Making things too configurable adds needless complexity.

A good example is our convention of having automatic output filtering in templates, but the ability to override that when you need to.

### Don't be afraid to break from conventional wisdom

If it doesn't hurt readability and maintainability, sometimes the status quo needs to be challenged. Otherwise, how would JSON + REST have superseded XML-RPC, which superseded SOAP? So we choose to ignore the naysayers and go with what we can verify for ourselves works.

Finding the right solution means looking careful at the problem itself, and thinking differently about how you solve it can often lead to more succinct and cleaner solutions.

Solutions that work in one language or context often yield poorer results in another, and playing on the strengths of the platform at hand is a key to achieving concise solutions.

### Don't over-architect

This could also be written as: Don't be Java.

The Java world is rife with over-architected APIs and frameworks. PHP has been in a crisis of sorts since being deemed not a serious language, and the reaction has largely been to over-architect our solutions and be more like Java in order to be taken seriously. This has taken away from the simplicity that was PHP's main attractor.

We don't believe you need to over-architect to be a serious platform. Minimalism wins, but requires discipline on the part of the developer, and we believe PHP belongs in that camp.

### Play nice with others

Being that Elefant is specifically a *web* framework, we deliberately leave out some things other frameworks already have. For example, there's no need for us to include Adobe AMF or barcode and PDF generation libraries in Elefant like the Zend Framework, a general-purpose framework, does. Instead, we strive to keep Elefant compatible with other libraries and frameworks you may need to use to augment your apps.

### 'Worse is better'

Most of the above boils down to this point. We prescribe loosely to the [Worse is better](http://en.wikipedia.org/wiki/Worse_is_better) notion that simplicity is the most important design consideration. This is what made PHP popular to begin with, and is reflected throughout the Elefant API and its user interface. This is also where we disagree fundamentally with the approach taken by almost all of the major PHP frameworks today.

## Non-principles

We don't include things like security, unit testing, and speed here because these aren't principles, they are simply things to always strive for in every software project. Nobody strives for insecure, untested, and slow code, so it goes without saying that we consider these to be important things.

----

References:

* [Worse is better](http://en.wikipedia.org/wiki/Worse_is_better)
* [You ain't gonna need it](http://en.wikipedia.org/wiki/You_ain't_gonna_need_it)
* [The MicroPHP Manifesto](http://microphp.org/)
* [KISS principle](http://en.wikipedia.org/wiki/KISS_principle)
* [Don't repeat yourself](http://en.wikipedia.org/wiki/Don%27t_repeat_yourself)
