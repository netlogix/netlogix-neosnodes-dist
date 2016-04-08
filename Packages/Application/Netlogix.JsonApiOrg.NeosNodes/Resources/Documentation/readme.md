How Neos node requests could look like with jsonapi.org
=======================================================

This is a direct response to the [thread on discuss.neos.io about "RFC: Neos API - next
steps"](https://discuss.neos.io/t/rfc-neos-api-next-steps/966/1).

I assume the requesting client does have a link pointing at a single node.
We're not creating any search mechanism or even endpoint discovery in this example.

As for example data those requests are dealing with, I used a NeosDemoTypo3Org package for that.

This means each and every request here can easily replayed by e.g. utilizing PhpStorms "Test RESTful Web Service"
feature. Well. An exception to this are commands dealing with node publishing since they rely on user worksapces.

Since pretty-printed jsonapi.org format tends to fill all the screen you have, I decided to put every request/response
pair into a dedicated content file.


Assumed domain model:
---------------------

The attributes `_index`, `_hidden`, `_workspace` and `_creationDateTime` are taken from
the Node object.

Every other attribute is taken from the properties array.

The relationships `childNodes` and `parents` are passed directly to the corresponding
methods of the Node object.

The relationship `parents` uses an Eel query as a source which produces the rootline just like the `BreadcrumbMenu`
TypoScript does. More to that later when I show the actual response data.

We did not implement other "virtual relationships", but I can imagine e.g. `contentChildNodes`
returning recursively every content child node on the current page but no page notes.


The actual requests:
--------------------

1. [Fetch a node and it's child nodes (n levels)](Requests/1-fetch-a-node-and-its-child-nodes.md)
2. [Fetch a node and it's parents (breadcrumb)](Requests/2-fetch-a-node-and-its-parents.md)
3. [Create a new node in some context](Requests/3-create-a-new-node-in-some-context.md)
4. [Move a node](Requests/4-move-a-node.md)
5. [Publish a node and/or some workspace](Requests/5-publish-a-node-and-or-some-workspace.md)

Result data:
------------

The requests above all provide the data described by jsonapi.org, which means when creating data by POST the
result is **one of those two**:

* Status code "201 Created", holding an optional `Location` header and the object created. Relationships can be skipped
  even if they are part of the request payload. This response is meant for every POST where the server added the
  `id` part to the object identity.
* Status code "204 No Content" having no content at all. This response is intended for every POST where the identity
  is entirely provided by the client, meaning both, `type` and `id`.

See the footer for "5. Publish a node and/or some workspace" for an idea of how a response channel as event stream
could look like.

What did I do to implement this?
================================

DTOs
----

The class `Netlogix\JsonApiOrg\NeosNodes\Domain\Dto\NodeResource` is a very PHPy way of providing a DTO for nodes. Here
the API attributes are fetched from the TYPO3CR/Node object. The `parents` relationship is added here as well -  it's hidden 
at the very bottom, search for the `NodeResource::getNodesByEelExpression()` method.

I implemented the class `Netlogix\JsonApiOrg\NeosNodes\Domain\Dto\CommandResource` that basically takes the "exposing
configuration" from a Settings.yaml file. The public interface for that class is completely the same as for the
`NodeResource` class. The only differen is the source of information.

Currently a `ResourceInformation` is required for providing "routing configuration", such as argument name, controller
name and action name. In a later step this could be automatically guessed, jus as every `Repository` does for its
correspoinding `Entity` by FQCN matching. But for now this class is mandatory. That goes for both, the
`NodeResourceInformation` as well as for the `CommandResourceInformation`.

Domain objects
--------------

Reading is done via plain `TYPO3CR/Node` objects.

For commands there are distinct classes extending the `Netlogix\JsonApiOrg\NeosNodes\Domain\Command\AbstractCommand`
to fit into the same controller action. For now they are only property mapped, their `execute()` method is empty.

There is a `CommandController` that hands over the command object to a command bus and returns a "201" status code.

And there is a `NodeController`. Nodes have different linkage features, all represented by individual action names. I
basically added every reading linkage feature of jsonapi.org (list, show, showRelated, showRelationship), as well as
those linkage features for write operations (create, update, delete, createRelationship, updateRelationship). The later
ones throw exceptions since we don't want a CURDy way of writing nodes.

The `filter` mechanism is suggested by jsonapi.org but not striclty defined, so the actual filter mechanism is always
up to custom controller action code. That's what I did in `NodeController::listAction()`.

TypeConverter
-------------

The netlogix jsonapi.org lib provides type converters for targetType `object`. This means nodes, having their own
NodeTypeConverter, are not automatically covered. So I added a custom converters for Nodes. But that's very special
to TYPO3CR/Nodes. As long as public API domain objects have no custom converter classes, the default netlogix lib
content suffices.

Configuration
-------------

The whole Settings.yaml and Objects.yaml content could be skipped once there is annotation based configuration of
domain objects. But for now that's a lot of copy'n'paste data.

Used foreign code
-----------------

I startet with a plain "typo3/neos-base-distribution" and installed the "typo3/neosdemotypo3org".

On top of that I added the "netlogix/jsonapiorg" (dev-master) to provided property mapping and view.

The `include` and `fields` mechanism is provided by our lib, so no need to put that into individual controller code.
Both, including and sparse fields are always available when returning data, which means list, show, showRelated and
even all data responded as payload for every create and update request.

And I added the "netlogix/cqrs" (dev-master).

Mapped command objects always come with a "Log" wrapper since our current approach is to put the command objects to
persistence without having them marked as Entity.

Our default command bus and handler are only local PHP processing and direct execution.