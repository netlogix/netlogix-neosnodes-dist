Demo distribution combining jsonapi.org and cqrs with NeosDemoTypo3Org
======================================================================


About this distribution
-----------------------

* provides Flow, Neos and the NeosDemoTypo3Org package, 
* installs the Netlogix.JsonApiOrg package,
* installs the Netlogix.Cqrs package and
* contains an application package bringing those together.

The application package was created in response to the [thread on discuss.neos.io about "RFC: Neos API - next
steps"](https://discuss.neos.io/t/rfc-neos-api-next-steps/966/1).

The target this package tries to accomplish is giving an overview about how jsonapi.org requests and responses
can look like in a Neos backend environment.

For futher details, [see the package documentation](Packages/Application/Netlogix.JsonApiOrg.NeosNodes/Resources/Documentation/readme.md).


Install instructions
--------------------

1. Install packages

        composer install

2. Adjust database settings

3. Migrate database

        ./flow doctrine:migrate