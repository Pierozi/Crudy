# RESOURCE URL FORMAT

/articles
/comments
/peoples


# Relationship URL

/articles/1/relationships/comments
/comments/1/relationships/author

## Comments is a relationship of comment resource with article resource
## Author is a relationship of one people resource with comment resource

GET on /articles/1/relationships/comments return the relation
```
HTTP/1.1 200 OK
Content-Type: application/vnd.api+json

{
  "links": {
    "self": "/articles/1/relationships/comments",
    "related": "/articles/1/comments"
  },
  "data": [
    { "type": "comments", "id": "2" },
    { "type": "comments", "id": "3" }
  ]
}
```

GET on /comments/1/relationships/author return the relation
```
HTTP/1.1 200 OK
Content-Type: application/vnd.api+json

{
  "links": {
    "self": "/comments/1/relationships/author",
    "related": "/comments/1/author"
  },
  "data": {
    "type": "people", "id": "2"
  }
}
```

# Related resource URL is an URL of specific resources of an relationship
the resource content author related to comment 1
```
GET /comments/1/author HTTP/1.1
{
  "data": {
      "type": "people",
      "id": "2",
      "attributes": {
          "name": "John Doe"
      },
      "links": {
          "self": "/people/1"
      }
  },
  "links": {
      "self": "/comments/1/author"
  }
}
```

the resources content comments related to article 1
```
GET /articles/1/comments HTTP/1.1
{
  "data": [{
      "type": "comments",
      "id": "45",
      "attributes": {
          "message": "I love this API"
      },
      "links": {
          "self": "/comments/45"
      }
  }, {
      "type": "comments",
      "id": "12",
      "attributes": {
          "message": "JSON Specification well designed"
      },
      "links": {
          "self": "/comments/12"
      }
  }],
  "links": {
      "self": "/articles/1/comments"
  }
}
```

# TODOS

# Features
 - [x] Content Negotiation - Server Responsibilities
 - [x] Document Structure - Top Level
 - [x] Input / Output data integrity
 - [x] Dynamic namespace with HYPHEN-MINUS separator as resource URI
 - [x] Single error object
 - [ ] Multiples error object (with hoa group exception)
 - [ ] URL Parameters
  - [ ] fields
  - [ ] filters
  - [ ] offset //ID (NO USE OFFSET) it's better to use here an PRIMARY value for from instead integer position
  - [ ] limit  //Number of result from offset
 - [ ] Create resource with result 200
 - [ ] Create resource without result 204
 - [ ] Create resource in asynchronous with result 200 and data URL with ID queue job
 - [ ] Update resource
 - [ ] Delete resource
 - [ ] Read one resource
 - [ ] Read many resource
 - [ ] Read resource with relationship and included support
 - [ ] Included with recursive mode support
 - [ ] Get relationship of resource
 - [ ] Get related resource of relationship
 - [ ] Create resource with an relationship
 - [ ] Create resource with many relationships

# Unofficial Json-Api features

 - [ ] Call an command on specific resource in SYNC MODE
 - [ ] Call an command on specific resource in ASYNC MODE - return ID of queues job
 - [ ] Get command input format with HEAD http method
 - [ ] List all command in queues ( ASYNC MODE )
 - [ ] Get detail of specific command result ( ASYNC MODE )

