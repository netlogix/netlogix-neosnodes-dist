1. Fetch a node and it's child nodes (n levels)
===============================================

The following requests show that it's completely up to the consumer if only a single resource shall be returned or
any number of relationships.

It's simply the GET parameter `include` that tells the server which relationships to include and which to skip.

So the server side component for returning only a single page is the very same as for a page and its child pages.

As stated earlier, I can think of a virtual relationship `contentChildNodes` that returns all content nodes on
a page node no matter which nesting level it has. This is neither part of this example nor implemented currently, but
those kind of "convenience relationships" are perfectly fine as read model enhancements. I would add a couple of
those based on hard coded Eel queries directly to the DTO.

Have a look at the `NodeResource::getPayloadProperty()` and `NodeResource::getNodesByEelExpression()` methods. As soon
as those are aware of "virtual relationships" they can be exposed upon client request just as actual relationships can.


Fetching a node with no child nodes:
------------------------------------

Request to <http://nodeapi.local/api/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US>

    GET /api/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US HTTP/1.1
    Accept: application/vnd.api+json

Response:

    HTTP/1.1 200 OK
    Content-Type: application/vnd.api+json

    {
        "data": {
            "type": "TYPO3.Neos.NodeTypes:Page",
            "id": "\/sites\/neosdemotypo3org\/features\/other-elements@live;language=en_US",
            "attributes": {
                "title": "Other elements",
                "uriPathSegment": "other-elements",
                "_index": 800,
                "_hidden": false,
                "_workspace": "live",
                "_creationDateTime": "Sun, 26 Apr 2015 19:43:11 +0200"
            },
            "links": {
                "self": "http:\/\/nodeapi.local\/api\/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US"
            },
            "relationships": {
                "childNodes": {
                    "links": {
                        "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US",
                        "related": "http:\/\/nodeapi.local\/api\/nodes\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US"
                    }
                },
                "parent": {
                    "links": {
                        "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US",
                        "related": "http:\/\/nodeapi.local\/api\/nodes\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US"
                    }
                },
                "parents": {
                    "links": {
                        "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US",
                        "related": "http:\/\/nodeapi.local\/api\/nodes\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US"
                    }
                }
            }
        }
    }

Fetch a node with some child nodes (n=2):
-----------------------------------------

The "include=" GET argument being set to "childNodes.childNodes" is the only difference to the former request.

Request to <http://nodeapi.local/api/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US&include=childNodes.childNodes>:

    GET /api/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US&include=childNodes.childNodes HTTP/1.1
    Accept: application/vnd.api+json

Response:

    HTTP/1.1 200 OK
    Content-Type: application/vnd.api+json
    
    {
        "data": {
            "type": "TYPO3.Neos.NodeTypes:Page",
            "id": "\/sites\/neosdemotypo3org\/features\/other-elements@live;language=en_US",
            "attributes": {
                "title": "Other elements",
                "uriPathSegment": "other-elements",
                "_index": 800,
                "_hidden": false,
                "_workspace": "live",
                "_creationDateTime": "Sun, 26 Apr 2015 19:43:11 +0200"
            },
            "links": {
                "self": "http:\/\/nodeapi.local\/api\/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US"
            },
            "relationships": {
                "childNodes": {
                    "links": {
                        "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US",
                        "related": "http:\/\/nodeapi.local\/api\/nodes\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US"
                    },
                    "data": [
                        {
                            "type": "TYPO3.Neos:ContentCollection",
                            "id": "\/sites\/neosdemotypo3org\/features\/other-elements\/main@live;language=en_US"
                        },
                        {
                            "type": "TYPO3.Neos:ContentCollection",
                            "id": "\/sites\/neosdemotypo3org\/features\/other-elements\/teaser@live;language=en_US"
                        }
                    ]
                },
                "parent": {
                    "links": {
                        "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US",
                        "related": "http:\/\/nodeapi.local\/api\/nodes\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US"
                    }
                },
                "parents": {
                    "links": {
                        "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US",
                        "related": "http:\/\/nodeapi.local\/api\/nodes\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US"
                    }
                }
            }
        },
        "included": [
            {
                "type": "TYPO3.Neos:ContentCollection",
                "id": "\/sites\/neosdemotypo3org\/features\/other-elements\/main@live;language=en_US",
                "attributes": {
                    "_index": 100,
                    "_hidden": false,
                    "_workspace": "live",
                    "_creationDateTime": "Sun, 26 Apr 2015 19:43:11 +0200"
                },
                "links": {
                    "self": "http:\/\/nodeapi.local\/api\/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%40live%3Blanguage%3Den_US"
                },
                "relationships": {
                    "childNodes": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%40live%3Blanguage%3Den_US"
                        },
                        "data": [
                            {
                                "type": "TYPO3.Neos.NodeTypes:Headline",
                                "id": "\/sites\/neosdemotypo3org\/features\/other-elements\/main\/node53a18f52e9726@live;language=en_US"
                            },
                            {
                                "type": "TYPO3.Neos.NodeTypes:TwoColumn",
                                "id": "\/sites\/neosdemotypo3org\/features\/other-elements\/main\/node-53a1fc469bc10@live;language=en_US"
                            }
                        ]
                    },
                    "parent": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%40live%3Blanguage%3Den_US"
                        }
                    },
                    "parents": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%40live%3Blanguage%3Den_US"
                        }
                    }
                }
            },
            {
                "type": "TYPO3.Neos:ContentCollection",
                "id": "\/sites\/neosdemotypo3org\/features\/other-elements\/teaser@live;language=en_US",
                "attributes": {
                    "_index": 200,
                    "_hidden": false,
                    "_workspace": "live",
                    "_creationDateTime": "Sun, 26 Apr 2015 19:43:11 +0200"
                },
                "links": {
                    "self": "http:\/\/nodeapi.local\/api\/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fteaser%40live%3Blanguage%3Den_US"
                },
                "relationships": {
                    "childNodes": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fteaser%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fteaser%40live%3Blanguage%3Den_US"
                        },
                        "data": [
    
                        ]
                    },
                    "parent": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fteaser%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fteaser%40live%3Blanguage%3Den_US"
                        }
                    },
                    "parents": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fteaser%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fteaser%40live%3Blanguage%3Den_US"
                        }
                    }
                }
            },
            {
                "type": "TYPO3.Neos.NodeTypes:Headline",
                "id": "\/sites\/neosdemotypo3org\/features\/other-elements\/main\/node53a18f52e9726@live;language=en_US",
                "attributes": {
                    "title": "<h1>Other elements<\/h1>",
                    "_index": 100,
                    "_hidden": false,
                    "_workspace": "live",
                    "_creationDateTime": "Sun, 26 Apr 2015 19:43:11 +0200"
                },
                "links": {
                    "self": "http:\/\/nodeapi.local\/api\/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode53a18f52e9726%40live%3Blanguage%3Den_US"
                },
                "relationships": {
                    "childNodes": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode53a18f52e9726%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode53a18f52e9726%40live%3Blanguage%3Den_US"
                        }
                    },
                    "parent": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode53a18f52e9726%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode53a18f52e9726%40live%3Blanguage%3Den_US"
                        }
                    },
                    "parents": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode53a18f52e9726%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode53a18f52e9726%40live%3Blanguage%3Den_US"
                        }
                    }
                }
            },
            {
                "type": "TYPO3.Neos.NodeTypes:TwoColumn",
                "id": "\/sites\/neosdemotypo3org\/features\/other-elements\/main\/node-53a1fc469bc10@live;language=en_US",
                "attributes": {
                    "layout": "6-6",
                    "_index": 200,
                    "_hidden": false,
                    "_workspace": "live",
                    "_creationDateTime": "Sun, 26 Apr 2015 19:43:11 +0200"
                },
                "links": {
                    "self": "http:\/\/nodeapi.local\/api\/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode-53a1fc469bc10%40live%3Blanguage%3Den_US"
                },
                "relationships": {
                    "childNodes": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode-53a1fc469bc10%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode-53a1fc469bc10%40live%3Blanguage%3Den_US"
                        }
                    },
                    "parent": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode-53a1fc469bc10%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode-53a1fc469bc10%40live%3Blanguage%3Den_US"
                        }
                    },
                    "parents": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode-53a1fc469bc10%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%2Fmain%2Fnode-53a1fc469bc10%40live%3Blanguage%3Den_US"
                        }
                    }
                }
            }
        ]
    }