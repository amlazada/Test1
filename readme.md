## Lazada - PHP developer - Test1

### Development setup

- Ubuntu 14.04.5 LTS
- PHP 5.6.26
- mysql Ver 14.14
- Redis server v=2.8.4
- Composer version 1.2.1
- Laravel Framework version 5.3.16
- PHPUnit 3.7.28
- Laravel Doctrine 1.2
- Sendmail Version 8.14.4

Redis is assumed to be running in LRU mode.

Laravel development server is used to run the application: `php artisan serve`.

### Description

Running application provides access to resources `/tag` and `/post` via RESTful API:

#### CRUD Tag

##### Create tag

```
POST /api/tag

body:
- name
- (optional) posts[]: an array of ids of posts the tag is attached to

Response:
- 200, OK
- 422, name is empty
- 422, a tag with the same name already exist
```

##### Read tag

```
GET /api/tag/{$id}

Response:
- 200, [ 'id' => $id, 'name' => '{tag name}' ]
- 404, tag doesn't exist
```

##### Update tag

```
PUT/PATCH /api/tag/{$id}

body:
- (optional) name
- (optional) posts[]: an array of ids of posts the tag is attached to

Response:
- 200, OK
- 404, tag doesn't exist
- 422, name is empty
- 422, at least one of the items from 'posts[]' points to a post that doesn't exist
```

##### Delete tag

```
DELETE /api/tag/{$id}

Response:
- 200, OK
- 404, tag doesn't exist
```

##### Read all tags

```
GET /api/tag

Response:
- 200, []
- 200, [[ 'id' => $id, 'name' => '{tag name}' ]]
```

#### CRUD Post

##### Create post

```
POST /api/post

body:
- name
- (optional) text
- (optional) tags[]

Response:
- 200, OK
```

##### Read post

```
GET /api/post/{$id}

Response:
- 200, [
    'id' => {post id},
    'name' => {post name},
    'text' => {post text},
    'tags' => [ {tag names} ]
]
- 404, post doesn't exist
```

##### Update post

```
PUT/PATCH /api/post/{$id}

body:
- (optional) name
- (optional) text
- (optional) tags[]

Response:
- 200, OK
- 404, post doesn't exist
```

##### Delete post

```
DELETE /api/post/{$id}

Response:
- 200, OK
- 404, post doesn't exist
```

##### Read all posts

```
GET /api/post

Response:
- 200, []
- 200, [[ 'id' => $id, 'name' => '{post name}' ]]
```

#### Additional operations

##### Count a number of posts containing each of the tags

```
GET /api/post

query:
- countByTag

e.g.:
- /api/post?countByTag='tag1'
- /api/post?countByTag[]='tag1'
- /api/post?countByTag[]='tag1'&countByTag[]='tag2'

Response:
- 200, int
```

##### Read all posts containing each of the tags

```
GET /api/post

query:
- searchByTag

e.g.:
- /api/post?searchByTag='tag1'
- /api/post?searchByTag[]='tag1'
- /api/post?searchByTag[]='tag1'&searchByTag[]='tag2'

Response:
- 200, [[ 'id' => $id, 'name' => '{post name}' ]]
```

### Database

###### Table 'Posts'
- id: int
- name: string
- text: string

###### Table 'Tags'
- id: int
- name: string

###### Table 'posts_tags'
- post_id: int
- tag_id: int


###### Database migrations and seeds
Doctrine database migrations are available:
- `php artisan doctrine:migrations:migrate`
- `php artisan doctrine:migrations:reset`
- 
Database seed:
- `php artisan db:seed`