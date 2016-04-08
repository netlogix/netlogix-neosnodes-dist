4. Move a node
==============

Request to <http://nodeapi.local/api/commands>:

    POST /api/commands HTTP/1.1
    Accept: application/vnd.api+json
    Content-Type: application/vnd.api+json

    {
        "data": {
            "type": "Netlogix.JsonApiOrg.NeosNodes:MoveNodeCommand",
            "attributes": {
                "position": "before"
            },
            "relationships": {
                "node": {
                    "data": {
                        "type": "TYPO3.Neos.NodeTypes:Text",
                        "id": "\/sites\/neosdemotypo3org\/node-57077a820bc81\/main\/node-57077b0159bb2@live;language=en_US"
                    }
                },
                "targetNode": {
                    "data": {
                        "type": "TYPO3.Neos.NodeTypes:Text",
                        "id": "\/sites\/neosdemotypo3org\/node-57077a820bc81\/main\/node-57077b874347d@live;language=en_US"
                    }
                }
            }
        }
    }

Response:

    HTTP/1.1 201 Created
    Location: http://nodeapi.local/api/commands/a3ea49e0-3e45-4b64-a2d2-d0dc18dd7dd0
    Content-Type: application/vnd.api+json
    
    {
        "data": {
            "type": "Netlogix.JsonApiOrg.NeosNodes:MoveNodeCommand",
            "id": "a3ea49e0-3e45-4b64-a2d2-d0dc18dd7dd0",
            "attributes": {
                "position": "before"
            },
            "links": {
                "self": "http:\/\/nodeapi.local\/api\/commands\/a3ea49e0-3e45-4b64-a2d2-d0dc18dd7dd0"
            },
            "relationships": {
                "node": {
                    "links": {
                        "self": "http:\/\/nodeapi.local\/api\/commands\/a3ea49e0-3e45-4b64-a2d2-d0dc18dd7dd0\/relationships\/node",
                        "related": "http:\/\/nodeapi.local\/api\/commands\/a3ea49e0-3e45-4b64-a2d2-d0dc18dd7dd0\/node"
                    }
                },
                "targetNode": {
                    "links": {
                        "self": "http:\/\/nodeapi.local\/api\/commands\/a3ea49e0-3e45-4b64-a2d2-d0dc18dd7dd0\/relationships\/targetNode",
                        "related": "http:\/\/nodeapi.local\/api\/commands\/a3ea49e0-3e45-4b64-a2d2-d0dc18dd7dd0\/targetNode"
                    }
                }
            }
        }
    }