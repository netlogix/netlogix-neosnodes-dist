2. Fetch a node and it's parents (breadcrumb)
=============================================

This example *does* contain a virtual relationship property. There is no actual "parents" property on a PHP Node
object, but the API just provides it.

It's implemented as an Eel query using the current node as context, just like the `BreadcrumbMenu` does.

Request to <http://nodeapi.local/api/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US&include=parents>:

    GET /api/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%2Fother-elements%40live%3Blanguage%3Den_US&include=parents HTTP/1.1
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
                    },
                    "data": [
                        {
                            "type": "TYPO3.Neos.NodeTypes:Page",
                            "id": "\/sites\/neosdemotypo3org\/features\/other-elements@live;language=en_US"
                        },
                        {
                            "type": "TYPO3.Neos.NodeTypes:Page",
                            "id": "\/sites\/neosdemotypo3org\/features@live;language=en_US"
                        },
                        {
                            "type": "TYPO3.NeosDemoTypo3Org:Homepage",
                            "id": "\/sites\/neosdemotypo3org@live;language=en_US"
                        }
                    ]
                }
            }
        },
        "included": [
            {
                "type": "TYPO3.Neos.NodeTypes:Page",
                "id": "\/sites\/neosdemotypo3org\/features@live;language=en_US",
                "attributes": {
                    "title": "Features",
                    "layout": "landingPage",
                    "subpageLayout": "default",
                    "uriPathSegment": "features",
                    "_index": 400,
                    "_hidden": false,
                    "_workspace": "live",
                    "_creationDateTime": "Sun, 26 Apr 2015 19:43:10 +0200"
                },
                "links": {
                    "self": "http:\/\/nodeapi.local\/api\/nodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%40live%3Blanguage%3Den_US"
                },
                "relationships": {
                    "childNodes": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/childNodes?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%40live%3Blanguage%3Den_US"
                        }
                    },
                    "parent": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parent?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%40live%3Blanguage%3Den_US"
                        }
                    },
                    "parents": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parents?node=%2Fsites%2Fneosdemotypo3org%2Ffeatures%40live%3Blanguage%3Den_US"
                        }
                    }
                }
            },
            {
                "type": "TYPO3.NeosDemoTypo3Org:Homepage",
                "id": "\/sites\/neosdemotypo3org@live;language=en_US",
                "attributes": {
                    "title": "Home",
                    "layout": "landingPage",
                    "uriPathSegment": "home",
                    "imageTitleText": "Photo by Mr. Coffee",
                    "_index": 100,
                    "_hidden": false,
                    "_workspace": "live",
                    "_creationDateTime": "Sun, 26 Apr 2015 19:43:09 +0200"
                },
                "links": {
                    "self": "http:\/\/nodeapi.local\/api\/nodes?node=%2Fsites%2Fneosdemotypo3org%40live%3Blanguage%3Den_US"
                },
                "relationships": {
                    "childNodes": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/childNodes?node=%2Fsites%2Fneosdemotypo3org%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/childNodes?node=%2Fsites%2Fneosdemotypo3org%40live%3Blanguage%3Den_US"
                        }
                    },
                    "parent": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parent?node=%2Fsites%2Fneosdemotypo3org%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parent?node=%2Fsites%2Fneosdemotypo3org%40live%3Blanguage%3Den_US"
                        }
                    },
                    "parents": {
                        "links": {
                            "self": "http:\/\/nodeapi.local\/api\/nodes\/relationships\/parents?node=%2Fsites%2Fneosdemotypo3org%40live%3Blanguage%3Den_US",
                            "related": "http:\/\/nodeapi.local\/api\/nodes\/parents?node=%2Fsites%2Fneosdemotypo3org%40live%3Blanguage%3Den_US"
                        }
                    }
                }
            }
        ]
    }