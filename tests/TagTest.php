<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Artisan::call('doctrine:migrations:migrate');
        Artisan::call('db:seed');
    }

    public function tearDown()
    {
        Artisan::call('doctrine:migrations:reset');
        parent::tearDown();
    }

    /**
     * Get tags.
     *
     * @return void
     */
    public function testGetTags()
    {
        $this->get('/api/tag')->seeStatusCode(200)->seeJson([
            [ 'id' => 1, 'name' => 'tag1' ],
            [ 'id' => 2, 'name' => 'tag2' ],
            [ 'id' => 3, 'name' => 'tag3' ]
        ]);
    }

    /**
     * Create tag without posts.
     *
     * @return void
     */
    public function testPostTag()
    {
        $this->post('/api/tag', [
            'name' => 'tag4'
        ])->seeStatusCode(200);

        $this->seeInDatabase('Tags', [
            'name' => 'tag4'
        ]);
    }

    /**
     * Create tag with empty name.
     *
     * @return void
     */
    public function testPostTagEmptyName()
    {
        $this->post('/api/tag', [
            'name' => ''
        ])->seeStatusCode(422);

        $this->notSeeInDatabase('Tags', [
            'name' => ''
        ]);
    }

    /**
     * Create tag with a single post.
     *
     * @return void
     */
    public function testPostTagWithSinglePost()
    {
        $this->post('/api/tag', [
            'name' => 'tag4',
            'posts' => 1
        ])->seeStatusCode(200);

        $this->seeInDatabase('posts_tags', [
            'post_id' => 1,
            'tag_id' => 4
        ]);
    }

    /**
     * Create tag with a multiple posts.
     *
     * @return void
     */
    public function testPostTagWithMultiplePosts()
    {
        $this->post('/api/tag', [
            'name' => 'tag4',
            'posts' => [ 1, 2 ]
        ])->seeStatusCode(200);

        $this->seeInDatabase('posts_tags', [
            'post_id' => 1,
            'tag_id' => 4
        ]);

        $this->seeInDatabase('posts_tags', [
            'post_id' => 2,
            'tag_id' => 4
        ]);
    }

    /**
     * Create tag with a multiple posts. Should fail if post doesn't exist.
     *
     * @return void
     */
    public function testPostTagWithMultiplePostsWhenPostDoesNotExist()
    {
        $this->post('/api/tag', [
            'name' => 'tag4',
            'posts' => [ 1, 3 ]
        ])->seeStatusCode(422);

        $this->notSeeInDatabase('Tags', [
            'name' => 'tag4'
        ]);

        $this->notSeeInDatabase('posts_tags', [
            'post_id' => 1,
            'tag_id' => 4
        ]);

        $this->notSeeInDatabase('posts_tags', [
            'post_id' => 2,
            'tag_id' => 4
        ]);
    }

    /**
     * Create tag with a multiple posts. Should fail if tag already exist.
     *
     * @return void
     */
    public function testPostTagWithMultiplePostsWhenTagAlreadyExist()
    {
        $this->post('/api/tag', [
            'name' => 'tag3',
            'posts' => [ 1, 2 ]
        ])->seeStatusCode(422);

        $this->notSeeInDatabase('posts_tags', [
            'post_id' => 1,
            'tag_id' => 3
        ]);

        $this->notSeeInDatabase('posts_tags', [
            'post_id' => 2,
            'tag_id' => 3
        ]);
    }

    /**
     * Read tag.
     *
     * @return void
     */
    public function testGetTag()
    {
        $this->get('/api/tag/1')->seeStatusCode(200)->seeJson([ 'id' => 1, 'name' => 'tag1' ]);
    }

    /**
     * Read tag. Should fail if tag doesn't exist.
     *
     * @return void
     */
    public function testGetTagWhenNotExist()
    {
        $this->get('/api/tag/4')->seeStatusCode(404);
    }

    /**
     * Update tag.
     *
     * @return void
     */
    public function testUpdateTag()
    {
        $this->put('/api/tag/1', [
            'name' => 'tag4',
            'posts' => 1
        ])->seeStatusCode(200);

        $this->seeInDatabase('Tags', [
            'id' => 1,
            'name' => 'tag4'
        ]);

        $this->notSeeInDatabase('Tags', [
            'name' => 'tag1'
        ]);

        $this->seeInDatabase('posts_tags', [
            'post_id' => 1,
            'tag_id' => 1
        ]);

        $this->notSeeInDatabase('posts_tags', [
            'post_id' => 2,
            'tag_id' => 1
        ]);
    }

     /**
     * Update tag. Should fail if new name is empty.
     *
     * @return void
     */
    public function testUpdateTagEmptyName()
    {
        $this->put('/api/tag/1', [
            'name' => '',
            'posts' => 1
        ])->seeStatusCode(422);

        $this->notSeeInDatabase('Tags', [
            'id' => 1,
            'name' => ''
        ]);
    }

    /**
     * Update tag. Should fail if not exist
     *
     * @return void
     */
    public function testUpdateTagWhenNotExist()
    {
        $this->put('/api/tag/4', [
            'name' => 'tag4',
            'posts' => 1
        ])->seeStatusCode(404);

        $this->notSeeInDatabase('Tags', [
            'name' => 'tag4'
        ]);
    }

    /**
     * Update tag. Should fail if post doesn't exist.
     *
     * @return void
     */
    public function testUpdateTagWhenPostNotExist()
    {
        $this->put('/api/tag/1', [
            'name' => 'tag4',
            'posts' => 3
        ])->seeStatusCode(422);

        $this->notSeeInDatabase('Tags', [
            'name' => 'tag4'
        ]);
    }

    /**
     * Delete tag.
     *
     * @return void
     */
    public function testDeleteTag()
    {
        $this->delete('/api/tag/1')->seeStatusCode(200);

        $this->notSeeInDatabase('Tags', [
            'name' => 'tag1'
        ]);
    }

    /**
     * Delete tag. Should fail if not exist.
     *
     * @return void
     */
    public function testDeleteTagWhenNotExist()
    {
        $this->delete('/api/tag/4')->seeStatusCode(404);
    }
}
