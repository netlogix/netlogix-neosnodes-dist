3. Create a new node in some context
====================================

If a command is transformed from JSON to a Flow object by the PropertyMapper as action argument, the "type" attribute
is required to match the argument annotation in terms of inheritance.

This means we could either use a single action fetching all different commands, implement one action per command or
something in between reflecting e.g. privilege scopes.

I choose to use a single one, just for the sake of demonstration:
`CommandController::createAction(AbstractCommand)`.

This means: All commands of this example use the same target URI to be posted to.

Of course when returning a `TYPO3.Neos.NodeTypes:*` object form the server to the client, making the target URL for
commands part of the `links` response section to go hypermedia is perfectly fine.

Request to <http://nodeapi.local/api/commands>:

    POST /api/commands HTTP/1.1
    Accept: application/vnd.api+json
    Content-Type: application/vnd.api+json

    {
        "data": {
            "type": "Netlogix.JsonApiOrg.NeosNodes:CreateNodeCommand",
            "attributes": {
                "type": "TYPO3.Neos.NodeTypes:Headline"
            },
            "relationships": {
                "parent": {
                    "data": {
                        "type": "TYPO3.Neos.NodeTypes:Page",
                        "id": "\/sites\/neosdemotypo3org\/features\/other-elements@live;language=en_US"
                    }
                }
            }
        }
    }

Response:

    HTTP/1.1 201 Created
    Location: http://nodeapi.local/api/commands/b101b545-2ae4-4220-b413-fc22d155dac4
    Content-Type: application/vnd.api+json
    
    {
        "data": {
            "type": "Netlogix.JsonApiOrg.NeosNodes:CreateNodeCommand",
            "id": "b101b545-2ae4-4220-b413-fc22d155dac4",
            "attributes": {
                "type": "TYPO3.Neos.NodeTypes:Headline"
            },
            "links": {
                "self": "http:\/\/nodeapi.local\/api\/commands\/b101b545-2ae4-4220-b413-fc22d155dac4"
            },
            "relationships": {
                "parent": {
                    "links": {
                        "self": "http:\/\/nodeapi.local\/api\/commands\/b101b545-2ae4-4220-b413-fc22d155dac4\/relationships\/parent",
                        "related": "http:\/\/nodeapi.local\/api\/commands\/b101b545-2ae4-4220-b413-fc22d155dac4\/parent"
                    }
                }
            }
        }
    }

As you might see, the response of that POST request is just a slightly transformed version of the input, not an "answer"
to the task of creating an object.

In case the client provided a valid `id` property for the command, the server would not even have been required to add
the "b101b545-2ae4-4220-b413-fc22d155dac4". In this case, jsonapi.org allows the server to return "204 - No Content"
and skip any result data.

In the context of CQRS and response correlation, providing the command identifier by the client and reuse it as 
correlation id might be a good idea.

The `Location` response header is optional as of jsonapi.org. It's not part of my current jsonapi.org but gets set
by my `CommandController->createAction()`.