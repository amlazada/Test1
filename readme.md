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

Database seed:
- `php artisan db:seed`

### Issues
###### Coding style
I'm not familiar with PHP common coding styles, so, in general, coding style of this project is lacking consistency I usually striving for.

###### Generated API documentation
Automatically generate API documentation is always important, I've tried to use Swagger, but integrating it with laravel seemed to be taking too long. I've tried [laravel-apidoc-generator](https://github.com/mpociot/laravel-apidoc-generator), the result can be found at [/public/docs/index.html](/public/docs/index.html).

###### Testing
Due to time limitation, only test for the `/tag` resource is available at this moment: [/tests/TagTest.php](/tests/TagTest.php). I'm familiar with unit-testing and a big believer of it, but not being familiar with PHPUnit I'd like to have some improvements like better tests splitting, cleaner style.

###### Error handling
Both approaches of not handling error or covering everything with `try/catch` are naive and not suitable for real-world production environment. Usually, project requirements are what define an error handling model for a project. For example, take a look at [this line](https://github.com/amlazada/Test1/blob/master/app/Http/Controllers/TagController.php#L28):

```php
$tags = $this->em->getRepository("Test1\Entities\Tag")->findAll();
```

This operation may cause an exception, and a one way to handle it is:

```php
try {
  $tags = $this->em->getRepository("Test1\Entities\Tag")->findAll();
} catch (\Exception $e) {
  response($e, 500)
}
```

But there are few issues about that:
- Without any business requirements, there is nothing much to do in the catch block, basically, there is no meaningful difference between letting an exception go and handling it in this way
- Handling this type of errors is more of a cross-cutting concern, so handling an error like that 'in place' is not efficient for a real-world project

So, due to time limitations, I decided to leave it this way for now.

###### Dependency injection
Take a look, for example, at [this line](https://github.com/amlazada/Test1/blob/master/app/Http/Controllers/TagController.php#L63):

```php
$cachedTag = Redis::hgetAll('tag:'.$id);
```

With little to no exception using statics (singletons, etc.) is bad. I'd prefer to have the Redis service injected the same way I [inject Doctrine Entity Manager](https://github.com/amlazada/Test1/blob/master/app/Http/Controllers/TagController.php#L16):

```php
public function __construct(\Doctrine\ORM\EntityManagerInterface $em)
{
    $this->em = $em;
}
```

Again, having a limited time, I left it this way for now.

###### Database/cache synchronization policies
There are many ways to organize database/cache access and picking one is a big task itself. I went a simple way, but for a more serious application I'd like to spend more time designing/implementing it.