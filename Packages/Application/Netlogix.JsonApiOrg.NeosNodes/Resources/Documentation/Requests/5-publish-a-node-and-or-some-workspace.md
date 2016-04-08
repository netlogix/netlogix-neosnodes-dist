5. Publish a node and/or some workspace
=======================================

Publish given workspace into another:
-------------------------------------

Request to <http://nodeapi.local/api/commands>:

    POST /api/commands HTTP/1.1
    Accept: application/vnd.api+json
    Content-Type: application/vnd.api+json

    {
        "data": {
            "type": "Netlogix.JsonApiOrg.NeosNodes:PublishAllCommand",
            "attributes": {
                "targetWorkspaceName": "live",
                "sourceWorkspaceName": "user-schuler"
            }
        }
    }


Response:

    HTTP/1.1 201 Created
    Location: http://nodeapi.local/api/commands/11e1d013-9b7e-4803-af35-30258a72b370
    Content-Type: application/vnd.api+json
    
    {
        "data": {
            "type": "Netlogix.JsonApiOrg.NeosNodes:PublishAllCommand",
            "id": "11e1d013-9b7e-4803-af35-30258a72b370",
            "attributes": {
                "targetWorkspaceName": "live",
                "sourceWorkspaceName": "user-schuler"
            },
            "links": {
                "self": "http:\/\/nodeapi.local\/api\/commands\/11e1d013-9b7e-4803-af35-30258a72b370"
            }
        }
    }

Publish a collection of nodes into a workspace:
-----------------------------------------------

Request to <http://nodeapi.local/api/commands>:

    POST /api/commands HTTP/1.1
    Accept: application/vnd.api+json
    Content-Type: application/vnd.api+json

    {
        "data": {
            "type": "Netlogix.JsonApiOrg.NeosNodes:PublishNodesCommand",
            "attributes": {
                "targetWorkspaceName": "live"
            },
            "relationships": {
                "nodes": {
                    "data": [
                        {
                            "id": "\/sites\/neosdemotypo3org\/node-57077a820bc81\/main\/node-57077b874347d",
                            "type": "TYPO3.Neos.NodeTypes:Text"
                        }
                    ]
                }
            }
        }
    }


Response:

    HTTP/1.1 201 Created
    Location: http://nodeapi.local/api/commands/e1f507db-8afb-461b-bc42-8ebd819f13c8
    Content-Type: application/vnd.api+json
    
    {
        "data": {
            "type": "Netlogix.JsonApiOrg.NeosNodes:PublishNodesCommand",
            "id": "e1f507db-8afb-461b-bc42-8ebd819f13c8",
            "attributes": {
                "targetWorkspaceName": "live"
            },
            "links": {
                "self": "http:\/\/nodeapi.local\/api\/commands\/e1f507db-8afb-461b-bc42-8ebd819f13c8"
            },
            "relationships": {
                "nodes": {
                    "links": {
                        "self": "http:\/\/nodeapi.local\/api\/commands\/e1f507db-8afb-461b-bc42-8ebd819f13c8\/relationships\/nodes",
                        "related": "http:\/\/nodeapi.local\/api\/commands\/e1f507db-8afb-461b-bc42-8ebd819f13c8\/nodes"
                    }
                }
            }
        }
    }

Collecting responses:
---------------------

Especially the `PublishAllCommand` seems like on that is on one hand potentially asynchronously executed and on the
other hand by no means guessable by the client. So here's the clear need of creating some response channel.

Clearly "events" is what I'm taking about.

An easy way would be to just create an "events" endpoint URI which returns event objects. 
This can either be done by making this endpoint pretty stateful and have the user session keeping track of which events
are already present at client side and only return new ones.
Or this can be done stateless by having the client provide an even sequence number as a "limit offset".

The following thing is *not* part of the PHP code currently. It's completely made up to demonstrate polling.

Request to <http://nodeapi.local/api/events>:

    GET /api/events?sequenceNumber=1460121710 HTTP/1.1
    Accept: application/vnd.api+json

Response:

    HTTP/1.1 200 OK
    Content-Type: application/vnd.api+json
    
    {
        "data": [
            {
                "type": "Netlogix.JsonApiOrg.NeosNodes:Events.NodeCreated",
                "id": "89fabb74-d222-445e-a92f-86496f59306b",
                "attributes": {
                    "sequenceNumber": "1460121715"
                },
                "links": {
                    "self": "http:\/\/nodeapi.local\/api\/events/89fabb74-d222-445e-a92f-86496f59306b"
                },
                "relationships": {
                    "node": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/events/89fabb74-d222-445e-a92f-86496f59306b\/relationships\/node",
                            "related": "http:\/\/nodeapi.local\/api\/events/89fabb74-d222-445e-a92f-86496f59306b\/node"
                        }
                    }
                }
            },
            {
                "type": "Netlogix.JsonApiOrg.NeosNodes:Events.published",
                "id": "0e31a82c-fd93-11e5-86aa-5e5517507c66",
                "attributes": {
                    "sequenceNumber": "1460121715",
                    "targetWorkspaceName": "live"
                },
                "links": {
                    "self": "http:\/\/nodeapi.local\/api\/events/0e31a82c-fd93-11e5-86aa-5e5517507c66"
                },
                "relationships": {
                    "node": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/events/0e31a82c-fd93-11e5-86aa-5e5517507c66\/relationships\/node",
                            "related": "http:\/\/nodeapi.local\/api\/events/0e31a82c-fd93-11e5-86aa-5e5517507c66\/node"
                        }
                    }
                }
            }
        ],
    }

As you can see, a given "list" endpoint is not limited to always return the same type of elements. Of course it's
good practice to have the "events" endpoint always return events but having different types of events indicated by
their individual `type` property is perfectly fine.

Since jsonapi.org does not rely on URLs but covers the whole identity part as JSON payload, having a websocket in
place for the event stream is easily possible, too.